<?php

namespace App\Http\Controllers;

use App\DataTables\CityManagersDataTable;
use App\Models\Manager;
use App\Http\Requests\StoreManagerRequest;
use App\Http\Requests\UpdateManagerRequest;
use App\Http\Resources\CityManagersResource;
use Yajra\DataTables\Facades\DataTables;

class CityManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CityManagersDataTable $dataTable)
    {
        $cityManagers = Manager::role('city_manager')->get();
        if (request()->ajax()) {
            $data = CityManagersResource::collection($cityManagers);
            return DataTables::of($data)
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->make(true);
        }
        return $dataTable->render('dashboard.cityManagers.index');
    }

        /**
     * Create an array of fields to create a form in the frontend
     *
     * @return array with data neened to create frontend form dinamically
     */
    public function getFormData()
    {
        return [
            'formLable' => 'City Manager',
            'fields' => [
                [
                    'type' => 'text',
                    'label' => 'Manager Name',
                    'name' => 'name',
                    'valueKey' => 'name'
                ],
                [
                    'type' => 'email',
                    'label' => 'Email',
                    'name' => 'email',
                    'valueKey' => 'email'
                ],
                [
                    'type' => 'password',
                    'label' => 'Password',
                    'name' => 'password'
                ],
                [
                    'type' => 'password',
                    'label' => 'Confirm Password',
                    'name' => 'password_confirmation'
                ],
                [
                    'type' => 'text',
                    'label' => 'National Id',
                    'name' => 'national_id',
                    'valueKey' => 'national_id'
                ],
                [
                    'type' => 'radio',
                    'label' => 'Gender',
                    'name' => 'gender',
                    'valueKey' => 'gender',
                    'options' => [
                        ['value' => 'male', 'text' => 'Male'],
                        ['value' => 'female', 'text' => 'Female'],
                    ]
                ],
                [
                    'type' => 'date',
                    'label' => 'Birth Date',
                    'name' => 'birth_date',
                    'valueKey' => 'birth_date'
                ],
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
     * @param  \App\Http\Requests\StoreManagerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreManagerRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Manager  $manager
     * @return \Illuminate\Http\Response
     */
    public function show(Manager $manager)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Manager  $manager
     * @return \Illuminate\Http\Response
     */
    public function edit(Manager $manager)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateManagerRequest  $request
     * @param  \App\Models\Manager  $manager
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateManagerRequest $request, Manager $manager)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Manager  $manager
     * @return \Illuminate\Http\Response
     */
    public function destroy(Manager $manager)
    {
        //
    }
}