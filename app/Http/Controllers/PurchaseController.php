<?php

namespace App\Http\Controllers;

use App\DataTables\PurchasesDataTable;
use App\Http\Resources\PurchaseResource;
use App\Models\City;
use App\Models\Purchase;
use App\Http\Requests\StorePurchaseRequest;
use App\Http\Requests\UpdatePurchaseRequest;
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
        return $dataTable->render('dashboard.purchases.index',['revenue'=>Auth::user()->revenue()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // This  will show the view of  buy_package_for_user form
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePurchaseRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePurchaseRequest $request)
    {
        // This method will store a new package record in the database
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
