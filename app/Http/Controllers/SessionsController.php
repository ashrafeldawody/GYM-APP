<?php

namespace App\Http\Controllers;

use App\DataTables\SessionsDataTable;
use App\Http\Resources\CityResource;
use App\Http\Resources\SessionResource;
use App\Models\City;
use App\Models\TrainingPackage;
use App\Models\TrainingSession;
use App\Http\Requests\StoreTrainingSessionRequest;
use App\Http\Requests\UpdateTrainingSessionRequest;
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
            $data = SessionResource::collection(TrainingSession::all());
            return Datatables::of($data)
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

        return [
            'formLable' => 'City Manager',
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
}
