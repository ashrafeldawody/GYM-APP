<?php

namespace App\Http\Controllers;

use App\DataTables\PackagesDataTable;
use App\Http\Resources\CityResource;
use App\Http\Resources\PackageResource;
use App\Models\City;
use App\Models\TrainingPackage;
use App\Http\Requests\StoreTrainingPackageRequest;
use App\Http\Requests\UpdateTrainingPackageRequest;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class PackagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PackagesDataTable $dataTable)
    {
        // This method has to return a datatables view that has these columns'
        // package_name | price in dollars | sessions_number

        if (request()->ajax()) {

            $data = PackageResource::collection(TrainingPackage::all());
            return Datatables::of($data)
                ->addIndexColumn()
                ->make(true);
        }

        return $dataTable->render('dashboard.packages.index');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTrainingPackageRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTrainingPackageRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TrainingPackage  $trainingPackage
     * @return \Illuminate\Http\Response
     */
    public function show(TrainingPackage $trainingPackage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TrainingPackage  $trainingPackage
     * @return \Illuminate\Http\Response
     */
    public function edit(TrainingPackage $trainingPackage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTrainingPackageRequest  $request
     * @param  \App\Models\TrainingPackage  $trainingPackage
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTrainingPackageRequest $request, TrainingPackage $trainingPackage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TrainingPackage  $trainingPackage
     * @return \Illuminate\Http\Response
     */
    public function destroy(TrainingPackage $trainingPackage)
    {
        //
    }
}
