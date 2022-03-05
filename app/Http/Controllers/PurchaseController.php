<?php

namespace App\Http\Controllers;

use App\DataTables\PurchasesDataTable;
use App\Http\Resources\PurchaseResource;
use App\Models\City;
use App\Models\Gym;
use App\Models\Purchase;
use App\Http\Requests\StorePurchaseRequest;
use App\Http\Requests\UpdatePurchaseRequest;
use App\Models\TrainingPackage;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PurchasesDataTable $dataTable)
    {
        if (request()->ajax()) {
            return Datatables::of(PurchaseController::getData())
                ->addIndexColumn()
                ->make(true);
        }
        return $dataTable->render('dashboard.purchases.index',
            [
                'weekly_revenue'=>Auth::user()->revenue(7),
                'monthly_revenue'=>Auth::user()->revenue(30),
                'yearly_revenue'=>Auth::user()->revenue(365),
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $packages = TrainingPackage::select('id','name')->orderBy('name')->get();
        $users = User::select('id','name')->orderBy('name')->get();

        if(Auth::user()->hasRole('city_manager'))
            $gyms = Auth::user()->city->gyms;
        else if(Auth::user()->hasRole('gym_manager'))
            $gyms = Auth::user()->gym;
        else
            $gyms = Gym::select('id','name')->orderBy('name')->get();

        return view('dashboard.purchases.buy',compact('packages','users','gyms'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePurchaseRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePurchaseRequest $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function show(Purchase $purchase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function edit(Purchase $purchase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePurchaseRequest  $request
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePurchaseRequest $request, Purchase $purchase)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function destroy(Purchase $purchase)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * a method that return the data object according to the logged-in user
     */
    private static function getData(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        if (Auth::user()->hasRole('gym_manager')) {
            return PurchaseResource::collection(Auth::user()->gym->purchases);
        } else if (Auth::user()->hasRole('city_manager')) {
            return PurchaseResource::collection(Auth::user()->city->purchases);
        } else {
            return PurchaseResource::collection(Purchase::with('trainingPackage','user','gym','gym.city')->get());
        }
    }
}
