<?php

namespace App\Http\Controllers;

use App\DataTables\CitiesDataTable;
use App\Models\City;
use App\Http\Requests\StoreCityRequest;
use App\Http\Requests\UpdateCityRequest;
use App\Http\Resources\CityResource;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CitiesDataTable $dataTable)
    {
        if (request()->ajax()) {
            $data = CityResource::collection(City::with('manager')->get());
            return  Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actions =
                        '<a href="#" class="btn btn-sm btn-primary">Edit</a>
                    <a href="#" class="btn btn-sm btn-danger">Delete</a>';
                    return $actions;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return $dataTable->render('dashboard.cities');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCityRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCityRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function show(City $city)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function edit(City $city)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCityRequest  $request
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCityRequest $request, City $city)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function destroy(City $city)
    {
        //
    }
}
