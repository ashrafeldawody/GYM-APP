<?php

namespace App\Http\Controllers;

use App\DataTables\SessionsDataTable;
use App\Http\Resources\CityGymCoachesResource;
use App\Http\Resources\CityResource;
use App\Http\Resources\GymCoachesResource;
use App\Http\Resources\SessionResource;
use App\Models\City;
use App\Models\Coach;
use App\Models\Gym;
use App\Models\Manager;
use App\Models\TrainingPackage;
use App\Models\TrainingSession;
use App\Http\Requests\StoreTrainingSessionRequest;
use App\Http\Requests\UpdateTrainingSessionRequest;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class SessionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(SessionsDataTable $dataTable)
    {
        // This method has to return a datatables view that has these columns'
        // name | starts_at | finishes_at
        if (request()->ajax()) {
            return Datatables::of(SessionsController::getData())
                ->addIndexColumn()
                ->make(true);
        }
        return $dataTable->render('dashboard.sessions.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return array
     */
    public function create()
    {

        // The creation form will have
        // name | day | start time | finish time | coaches (multiple select)
        // we have to
        $formData = [
            'formLable' => 'Training Session',
            'fields' => [
                [
                    'type' => 'text',
                    'label' => 'Session Name',
                    'name' => 'name',
                    'valueKey' => 'name'
                ],
                [
                    'type' => 'date',
                    'label' => 'Day',
                    'name' => 'day',
                    'valueKey' => 'day'
                ],
                [
                    'type' => 'time',
                    'label' => 'Start Time',
                    'name' => 'start_time',
                    'valueKey' => 'start_time'
                ],
                [
                    'type' => 'time',
                    'label' => 'Finish Time',
                    'name' => 'finish_time',
                    'valueKey' => 'finish_time'
                ],
            ]
        ];
        if (Auth::user()->hasRole('gym_manager')) {
            $coaches = Auth::user()->gym->coaches()->get(['id', 'name'])->toArray();
            $formData['fields'][] = [
                'label' => 'Coach',
                'name' => 'coach_id',
                'type' => 'select',
                'valueKey' => 'id',
                'text' => 'name',
                'compare' => 'coach_name',
                'options' => $coaches
            ];
        } else if (Auth::user()->hasRole('city_manager')) {
            $data  = GymCoachesResource::collection(Auth::User()->gyms);
            $formData['fields'][] = [
                'type' => 'nestedSelect',
                'gyms' => $data,
                'levels' => [
                   [
                       'key' => 'gyms',
                       'label' => 'Gym',
                       'text' => 'name',
                   ],
                   [
                       'key' => 'coaches',
                       'label' => 'coach',
                       'valueKey' => 'id',
                       'text' => 'name',
                       'inputName' => 'coach_id'
                   ]
                ],
            ];
        } else {
            $data  = CityGymCoachesResource::collection(City::with('gyms', 'gyms.coaches')->get());
            $formData['fields'][] = [

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
                    ],
                    [
                        'key' => 'coaches',
                        'label' => 'coach',
                        'valueKey' => 'id',
                        'text' => 'name',
                        'inputName' => 'coach_id'
                    ]
                ],
            ];
        }
        return $formData;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTrainingSessionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTrainingSessionRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TrainingSession  $trainingSession
     * @return \Illuminate\Http\Response
     */
    public function show(TrainingSession $trainingSession)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TrainingSession  $trainingSession
     * @return \Illuminate\Http\Response
     */
    public function edit(TrainingSession $trainingSession)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTrainingSessionRequest  $request
     * @param  \App\Models\TrainingSession  $trainingSession
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTrainingSessionRequest $request, TrainingSession $trainingSession)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TrainingSession  $trainingSession
     * @return array
     */
    public function destroy($id): array
    {
        $trainingSession = TrainingSession::find($id);
        $trainingSessionName = $trainingSession->name;
        if ($trainingSession->attendances->count()) {
            return [
                'result' => false,
                'userMessage' => "Can't delete <b>$trainingSessionName</b> Session because it has Users Attends to it"
            ];
        } else {
            $trainingSession->delete();
            return [
                'result' => true,
                'userMessage' => "<b>$trainingSessionName</b> has been successfully deleted"
            ];
        }
    }
    /**
     * Remove the specified resource from storage.
     * a method that return the data object according to the logged-in user
     */
    private static function getData(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        if (Auth::user()->hasRole('gym_manager')) {
            return SessionResource::collection(Auth::user()->gym->trainingSessions);
        } else if (Auth::user()->hasRole('city_manager')) {
            return SessionResource::collection(Auth::user()->city->sessions);
        } else {
            return SessionResource::collection(TrainingSession::all());
        }
    }
}
