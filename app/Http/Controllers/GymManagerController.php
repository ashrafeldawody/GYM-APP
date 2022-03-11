<?php

namespace App\Http\Controllers;

use App\DataTables\GymManagersDataTable;
use App\Http\Resources\CityGymResource;
use App\Http\Resources\GymManagersResource;
use App\Models\City;
use App\Models\GymManager;
use App\Models\Manager;
use App\Http\Requests\StoreManagerRequest;
use Illuminate\Support\Facades\Auth;
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
            return DataTables::of(GymManagerController::getData())
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
                // ----- * ----- Add form ----- * -----
                [
                    'label' => 'Manager',
                    'name' => 'manager_id',
                    'type' => 'select',
                    'valueKey' => 'id',
                    'text' => 'name',
                    'compare' => 'manager_name',
                    'options' => $managers,
                    'addOnly' => true
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
                    'addOnly' => true
                ],
                // ----- * ----- Edit form ----- * -----
                [
                    'type' => 'text',
                    'label' => 'Manager Name',
                    'name' => 'name',
                    'valueKey' => 'name',
                    'editOnly' => true
                ],
                [
                    'type' => 'email',
                    'label' => 'Email',
                    'name' => 'email',
                    'valueKey' => 'email',
                    'editOnly' => true
                ],
                [
                    'type' => 'text',
                    'label' => 'National Id',
                    'name' => 'national_id',
                    'valueKey' => 'national_id',
                    'editOnly' => true
                ],
                [
                    'type' => 'radio',
                    'label' => 'Gender',
                    'name' => 'gender',
                    'valueKey' => 'gender',
                    'options' => [
                        ['value' => 'male', 'text' => 'Male'],
                        ['value' => 'female', 'text' => 'Female'],
                    ],
                    'editOnly' => true
                ],
                [
                    'type' => 'date',
                    'label' => 'Birth Date',
                    'name' => 'birth_date',
                    'valueKey' => 'birth_date',
                    'editOnly' => true
                ],
                [
                    'type' => 'file',
                    'label' => 'Avatar Image',
                    'name' => 'avatar',
                    'valueKey' => 'avatar',
                    'editOnly' => true
                ],
            ]
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreManagerRequest  $request
     * @return array
     */
    public function store(StoreManagerRequest $request)
    {
        $manager  = Manager::find($request->validated()['manager_id']);
        $manager->setRole('gym_manager');
        GymManager::create($request->validated());
        $newManagerData = Datatables::of(GymManagersResource::collection([$manager]))->make(true);
        return [
            'result' => true,
            'userMessage' => "<b>$manager->name</b> Has been created successfuly",
            'newRowData' => $newManagerData
        ];
    }

    /**
     * Remove the specified resource from storage.
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

    public function getData()
    {
        if (Auth::user()->hasRole('admin')) {
            return GymManagersResource::collection(Manager::role('gym_manager')->get());
        } else {
            return GymManagersResource::collection(Auth::user()->city->gyms()->with('managers')->get()->pluck('managers')->flatten());
        }
    }

    public function ban($id): array
    {
        $manager = Manager::find($id);
        if ($manager->isbanned()) {
            $manager->unban();
            return [
                'result' => true,
                'isBanned' => false,
                'userMessage' => "<b>$manager->name</b> unbanned successfuly",
            ];
        } else {
            $manager->ban();
            return [
                'result' => true,
                'isBanned' => true,
                'userMessage' => "<b>$manager->name</b> banned successfuly",
            ];
        }
    }
}
