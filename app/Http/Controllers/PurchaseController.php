<?php

namespace App\Http\Controllers;

use App\DataTables\PurchasesDataTable;
use App\Http\Resources\PackageResource;
use App\Http\Resources\PurchaseResource;
use App\Models\Purchase;
use App\Http\Requests\StorePurchaseRequest;
use App\Http\Requests\UpdatePurchaseRequest;
use App\Models\TrainingPackage;
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
        return $dataTable->render('dashboard.purchases.index');
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
        $authUser = Auth::user();
        if ($authUser->cannot('show_gym_data')) {

            // The Auth user is gym manager, so we have to return the data in his gym only

            return PurchaseResource::collection(Purchase::with('trainingPackage', 'user')
                ->where('gym_id', $authUser->gymManager->gym->id)
                ->get());

        } else if ($authUser->cannot('show_city_data')) {

            // The Auth User is City Manager, so we have to return the data in his city only

            return PurchaseResource::collection(Purchase::with('trainingPackage', 'user')
                ->whereIn('gym_id', PurchaseController::getCityGymIds($authUser->city))
                ->get());

        } else {

            // The Auth User is Admin, so reveal the whole data

            return PurchaseResource::collection(Purchase::with('trainingPackage', 'user')->get());
        }

    }

    /**
     * A method that takes city and returns an array of gymIds in this city
     */
    private static function getCityGymIds($city): array
    {
        $cityGyms = $city->gyms;
        $gymIds = [];
        foreach ($cityGyms as $gym) {
            $gymIds[] = $gym->id;
        }
        return $gymIds;
    }

}
