<?php

namespace App\Http\Controllers;

use App\DataTables\GymManagersDataTable;
use App\Http\Resources\CityGymCoachesResource;
use App\Http\Resources\CityGymResource;
use App\Http\Resources\GymManagersResource;
use App\Models\City;
use App\Models\Manager;
use App\Http\Requests\StoreManagerRequest;
use App\Http\Requests\UpdateManagerRequest;
use Yajra\DataTables\Facades\DataTables;

class GymManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(GymManagersDataTable $dataTable)
    {
        if (request()->ajax()) {
            $data = GymManagersResource::collection(Manager::role('gym_manager')->get());
            return DataTables::of($data)
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->make(true);
        }
        return $dataTable->render('dashboard.gymManagers.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return array
     */
    public function create()
    {
        $managers = Manager::whereDoesntHave('roles')->get(['id', 'name'])->toArray();
        $data  = CityGymResource::collection(City::with('gyms')->get());
        return [
            'formLable' => 'Gym Manager',
            'fields' => [
                [
                    'label' => 'Manager',
                    'name' => 'manager_id',
                    'type' => 'select',
                    'valueKey' => 'id',
                    'text' => 'name',
                    'compare' => 'manager_name',
                    'options' => $managers
                ],
                [
                    'type' => 'nestedSelect',
                    'cities' => $data,
                    'levels' => [
                        [
                            'key' => 'cities',
                            'label' => 'City',
                            'text' => 'name',
                        ],
                        [
                            'key' => 'gyms',
                            'label' => 'Gym',
                            'text' => 'name',
                            'valueKey' => 'id',
                            'inputName' => 'gym_id'
                        ],
                    ],
                ]
            ]
        ];
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
     * @return array
     */
    public function destroy($id)
    {
        $GymManager = Manager::find($id);
        $GymManagerName = Manager::find($id)->name;
        $GymManager->setRole('');
        return [
            'result' => true,
            'userMessage' => "<b>$GymManagerName</b> Deleted Successfuly"
        ];
    }

}
