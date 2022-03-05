<?php

namespace App\Http\Controllers;

use App\DataTables\AttendanceDataTable;
use App\Http\Resources\AttendanceResource;
use App\Models\Attendance;
use App\Http\Requests\StoreAttendanceRequest;
use App\Http\Requests\UpdateAttendanceRequest;
use App\Models\TrainingSession;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AttendanceDataTable $dataTable)
    {
        // This method has to return a datatables view that has these columns'
        // user_name | user_email | training_session_name | attendance_time | attendance_date | gym | city
        // gym will be shown in case of city manager only
        // city will be shown in case  of admin only
        if (request()->ajax()) {

            return Datatables::of(AttendanceController::getData())
                ->addIndexColumn()
                ->make(true);
        }
        return $dataTable->render('dashboard.attendance.index');
    }

    public function getFormData()
    {
        $users = User::get(['id', 'name'])->toArray();
        $trainingSessions = TrainingSession::get(['id', 'name'])->toArray();
        return [
            'formLable' => 'Attendance',
            'fields' => [
                [
                    'type' => 'select',             // input type
                    'label' => 'Users',             // label above the input
                    'name' => 'user_id',            // name of the input
                    // key used to select the current option (row -> datatable row)
                    //     row(compare) === options[i][text]
                    // row('user_name') === $users[i]['name']
                    'compare' => 'user_name',
                    'options' => $users,            // options list
                    'text' => 'name',               // key used to get text of options
                    'valueKey' => 'id',             // key used to get value of options
                ],
                [
                    'type' => 'select',
                    'label' => 'Session Name',
                    'name' => 'training_session_id',
                    'compare' => 'session_name',
                    'options' => $trainingSessions,
                    'text' => 'name',
                    'valueKey' => 'id',
                ],
                [
                    'type' => 'time',
                    'label' => 'Session Time',
                    'name' => 'time',
                    'valueKey' => 'attendance_time'
                ],
                [
                    'type' => 'date',
                    'label' => 'Session Date',
                    'name' => 'time',
                    'valueKey' => 'attendance_date'
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
     * @param  \App\Http\Requests\StoreAttendanceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAttendanceRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function show(Attendance $attendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function edit(Attendance $attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAttendanceRequest  $request
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAttendanceRequest $request, Attendance $attendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attendance $attendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * a method that return the data object according to the logged-in user
     */
    private static function getData(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        if (Auth::user()->hasRole('gym_manager')) {
            return AttendanceResource::collection(Auth::user()->gym->attendances);
        } else if (Auth::user()->hasRole('city_manager')) {
            return AttendanceResource::collection(Auth::user()->city->attendances);
        } else {
            return AttendanceResource::collection(Attendance::with('user','trainingSession','trainingSession.gym','trainingSession.gym.city')->get());
        }
    }
}
