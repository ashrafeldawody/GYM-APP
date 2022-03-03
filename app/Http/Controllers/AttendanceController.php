<?php

namespace App\Http\Controllers;

use App\DataTables\AttendanceDataTable;
use App\Http\Resources\AttendanceResource;
use App\Http\Resources\PurchaseResource;
use App\Models\Attendance;
use App\Http\Requests\StoreAttendanceRequest;
use App\Http\Requests\UpdateAttendanceRequest;
use App\Models\Purchase;
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
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    private static function getData()
    {
        $authUser = Auth::user();
        //Gym::All()[8]->trainingSessions[0]->attendancies;
       // TrainingSession::All()->first()->attendancies;
        if ($authUser->hasRole('gym_manager')) {

           return AttendanceResource::collection(Attendance::with('trainingSession', 'user')
                ->whereIn('training_session_id', $authUser->gymManager->gym->trainingSessions->pluck('id'))
                ->get());

        } else if ($authUser->hasRole('city_manager')) {

            return null;

        } else {
            return AttendanceResource::collection(Attendance::with('trainingSession', 'user')->get());
        }

    }


}
