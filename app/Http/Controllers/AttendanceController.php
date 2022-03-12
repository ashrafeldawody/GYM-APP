<?php

namespace App\Http\Controllers;

use App\DataTables\AttendanceDataTable;
use App\Http\Resources\AttendanceApiResource;
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
        if (request()->ajax()) {

            return Datatables::of(AttendanceController::getData())
                ->addIndexColumn()
                ->make(true);
        }
        return $dataTable->render('dashboard.attendance.index');
    }

    /**
     * a method that return the data object according to the logged-in user
     */
    private static function getData(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        if (Auth::user()->hasRole('gym_manager')) {
            return AttendanceResource::collection(Auth::user()->gym->attendances);
س        } else if (Auth::user()->hasRole('city_manager')) {
            return AttendanceResource::collection(Auth::user()->city->attendances);
        } else {
            return AttendanceResource::collection(Attendance::with('user','trainingSession','trainingSession.gym','trainingSession.gym.city')->get());
        }
    }
}
