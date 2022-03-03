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
                ->rawColumns(['action'])
                ->make(true);
        }

        return $dataTable->render('dashboard.cities.index');
    }

    public function getFormData()
    {
        return [
            'formLable' => 'City',
            'fields' => [
                [
                    'label' => 'City Name',
                    'name' => 'name',
                    'type' => 'text'
                ],
                [
                    'label' => 'Manager',
                    'name' => 'manager_id',
                    'type' => 'select',
                    'options' => [
                        ['value' => '1', 'text' => 'AAA'],
                        ['value' => '2', 'text' => 'BBB'],
                        ['value' => '3', 'text' => 'CCC'],
                        ['value' => '4', 'text' => 'DDD'],
                    ]
                ]
            ]
        ];
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
        if ($city != null) {
            $cityName = $city->name;
            if (count($city->gyms)) {
                return [
                    'result' => false,
                    'userMessage' => "Can't delete <b>$cityName</b>, the city has gyms"
                ];
            } else {
                $city->delete();
                return [
                    'result' => true,
                    'userMessage' => "<b>$cityName</b> has been successfully deleted"
                ];
            }
        }
        return [
            'result' => false,
            'userMessage' => 'Unknown error'
        ];
    }
}
