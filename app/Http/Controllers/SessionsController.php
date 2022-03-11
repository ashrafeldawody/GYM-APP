<?php

namespace App\Http\Controllers;

use App\DataTables\SessionsDataTable;
use App\Http\Resources\CityGymCoachesResource;
use App\Http\Resources\GymCoachesResource;
use App\Http\Resources\SessionResource;
use App\Models\City;
use App\Models\Coach;
use App\Models\TrainingSession;
use App\Http\Requests\StoreTrainingSessionRequest;
use App\Http\Requests\UpdateTrainingSessionRequest;
use App\Models\TrainingSessionCoach;
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
                    'valueKey' => 'starts_at'
                ],
                [
                    'type' => 'time',
                    'label' => 'Start Time',
                    'name' => 'starts_at',
                    'valueKey' => 'starts_at'
                ],
                [
                    'type' => 'time',
                    'label' => 'Finish Time',
                    'name' => 'finishes_at',
                    'valueKey' => 'finishes_at'
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
                        'inputName' => 'coach_id',
                        'multiSelect' => true
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
     * @return array
     */
    public function store(StoreTrainingSessionRequest $request)
    {
        $sessionName = $request->toArray()['name'];
        $sessionDay = $request->toArray()['day'];
        $sessionStartsAt = $request->toArray()['starts_at'];
        $sessionFinishesAt = $request->toArray()['finishes_at'];
        $coachesIds = $request->toArray()['coach_id'];
        $gymId = Coach::find($coachesIds[0])->gym->id;
        $startsAt = date('Y-m-d H:i:s', strtotime("$sessionDay $sessionStartsAt"));
        $finishesAt = date('Y-m-d H:i:s', strtotime("$sessionDay $sessionFinishesAt"));

        if (SessionsController::checkOverLab($request, '')) {
            return [
                'result' => false,
                'userMessage' => "<b>$sessionName->name</b> Can't be added because it overlabs with an existing session"
            ];
        }

        $session = TrainingSession::create([
            'name' => $sessionName,
            'starts_at' => $startsAt,
            'finishes_at' => $finishesAt,
            'gym_id' => $gymId,
        ]);

        foreach ($coachesIds as $coachId) {
            TrainingSessionCoach::create([
                'coach_id' => $coachId,
                'training_session_id' => $session->id,
                'manager_id' => Auth::user()->id,
            ]);
        }

        $newSessionData = Datatables::of(SessionResource::collection([$session]))->make(true);
        return [
            'result' => true,
            'userMessage' => "<b>$sessionName</b> has been successfully Created",
            'newRowData' => $newSessionData,
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTrainingSessionRequest  $request
     * @param  \App\Models\TrainingSession  $trainingSession
     * @return array
     */
    public function update(UpdateTrainingSessionRequest $request, $trainingSessionID)
    {
        $trainingSession = TrainingSession::find($trainingSessionID);
        $sessionName = $request->toArray()['name'];
        $sessionDay = $request->toArray()['day'];
        $sessionStartsAt = $request->toArray()['starts_at'];
        $sessionFinishesAt = $request->toArray()['finishes_at'];
        $coachesIds = $request->toArray()['coach_id'] ?? '';
        $startsAt = date('Y-m-d H:i:s', strtotime("$sessionDay $sessionStartsAt"));
        $finishesAt = date('Y-m-d H:i:s', strtotime("$sessionDay $sessionFinishesAt"));

        if (($startsAt != $trainingSession->starts_at || $finishesAt != $trainingSession->finishes_at)) {
            if ($trainingSession->attendances->count() > 0) {
                return [
                    'result' => false,
                    'userMessage' => "Cann't Edit <b>$sessionName</b> time because it has attendances in it"
                ];
            }
            if (SessionsController::checkOverLab($request, $trainingSession)) {
                return [
                    'result' => false,
                    'userMessage' => "<b>$sessionName/b> Can't be added because it overlabs with an existing session"
                ];
            }
        }
        $trainingSession->update([
            'name' => $sessionName,
            'starts_at' => $startsAt,
            'finishes_at' => $finishesAt,
        ]);

        if ($coachesIds != '') {
            TrainingSessionCoach::where('training_session_id', $trainingSession->id)->delete();
            foreach ($coachesIds as $coachId) {
                TrainingSessionCoach::create([
                    'coach_id' => $coachId,
                    'training_session_id' => $trainingSession->id,
                    'manager_id' => Auth::user()->id,
                ]);
            }
        }
        $newSessionData = Datatables::of(SessionResource::collection([$trainingSession]))->make(true);
        return [
            'result' => true,
            'userMessage' => "<b>$sessionName</b> has been successfully updated",
            'updatedData' => $newSessionData
        ];
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
            return SessionResource::collection(TrainingSession::with('gym', 'gym.city')->get());
        }
    }

    private function checkOverLab($request, $trainingSessionId): bool
    {
        // (StartA <= EndB)  and  (EndA >= StartB)
        $sessionDay = $request->toArray()['day'];
        $gymId = Coach::find($request->toArray()['coach_id'][0])->gym->id;
        $trainingSessions = TrainingSession::whereDate('starts_at', $sessionDay)->where('gym_id', $gymId)->get();
        $sessionStartsAt = $request->toArray()['starts_at'];
        $sessionFinishesAt = $request->toArray()['finishes_at'];
        $startsAt = date('Y-m-d H:i:s', strtotime("$sessionDay $sessionStartsAt"));
        $finishesAt = date('Y-m-d H:i:s', strtotime("$sessionDay $sessionFinishesAt"));
        if ($trainingSessions->count() > 0) {
            foreach ($trainingSessions as $session) {
                if ($trainingSessionId != '' && $trainingSessionId == $session->id) continue;
                if ( ($startsAt <= $session->finishes_at)  and  ($finishesAt >= $session->starts_at)) {
                    return true;
                }
            }
        }
        return false;
    }
}
