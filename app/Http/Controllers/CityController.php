<?php

namespace App\Http\Controllers;

use App\DataTables\CitiesDataTable;
use App\Models\City;
use App\Http\Requests\StoreCityRequest;
use App\Http\Requests\UpdateCityRequest;
use App\Http\Resources\CityResource;
use App\Models\Manager;
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
            return Datatables::of($data)
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->make(true);
        }

        return $dataTable->render('dashboard.cities.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return array
     */
    public function create()
    {
        $managers = Manager::whereDoesntHave('roles')->get(['id', 'name'])->toArray();

        return [
            'formLable' => 'City',
            'fields' => [
                [
                    'label' => 'City Name',
                    'name' => 'name',
                    'type' => 'text',
                    'valueKey' => 'name'
                ],
                [
                    'label' => 'Manager',
                    'name' => 'manager_id',
                    'type' => 'select',
                    'valueKey' => 'id',
                    'text' => 'name',
                    'selectedText' => 'manager_name',
                    'selectedValue' => 'manager_id',
                    'compare' => 'manager_name',
                    'options' => $managers
                ]
            ]
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCityRequest  $request
     * @return array
     */
    public function store(StoreCityRequest $request)
    {
        Manager::find($request->toArray()['manager_id'])->setRole('city_manager');
        $city = City::create($request->toArray());
        $newCityData = Datatables::of(CityResource::collection([$city]))->make(true);
        return [
            'result' => true,
            'userMessage' => "<b>{$city->name}</b> has beed successfully created",
            'newRowData' => $newCityData
        ];

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
     * @return array
     */
    public function update(UpdateCityRequest $request,City $city): array
    {
        $newManagerId = $request->validated()['manager_id'];
        if ($newManagerId != $city->manager_id) {
            $city->manager->setRole('');
            Manager::find($newManagerId)->setRole('city_manager');
        }
        $city->update($request->validated());
        $newCityData = Datatables::of(CityResource::collection([$city]))->make(true);
        return [
            'result' => true,
            'userMessage' => "<b>{$city->name}</b> has beed successfully updated",
            'updatedData' => $newCityData
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\City  $city
     * @return array
     */
    public function destroy(City $city): array
    {
        if ($city != null) {
            $cityName = $city->name;
            if (count($city->gyms)) {
                return [
                    'result' => false,
                    'userMessage' => "Can't delete <b>$cityName</b>, the city has gyms"
                ];
            } else {
                Manager::find($city->manager->id)->setRole('');
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
