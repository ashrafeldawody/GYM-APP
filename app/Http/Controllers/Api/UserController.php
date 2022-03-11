<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserInfoRequest;
use App\Http\Resources\AttendanceApiResource;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Models\TrainingSession;
use App\Models\Attendance;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserController extends Controller
{

    public function show(Request $request)
    {
        return UserResource::make($request->user());
    }

    public function getHistory(Request $request)
    {
        return AttendanceApiResource::collection($request->user()->attendances);
    }


    public function update(Request $request, UpdateUserInfoRequest $validate)
    {

        unset($request['_method']);
        unset($request['password_confirmation']);

        $request->merge(['password' => Hash::make(request()->password)]);
        $request->user()->update(request()->all());

        if ($request->has('avatar')) {
            $request->user()
                ->update(['avatar' => $request->file('avatar')->store('uploads', 'public')]);
        }

        return response()
            ->json(['message' => 'Information updated successfully!']);
    }

    public function getSessionsInfo(Request $request, $sessionId)
    {
        $totalTrainingSessions = $request->user()->purchases->pluck('sessions_number')->sum();

        return response()->json([
            'total_training_sessions' => $totalTrainingSessions,
            'remaining_training_sessions' => UserController::getRemainingSessions($request),
        ]);
    }

    public function attend(Request $request)
    {
        $selectedSession = TrainingSession::find(request()->id);
        $userSessions = $request->user()->attendances->pluck('training_session_id')->toArray();

        if (UserController::getRemainingSessions($request) <= 0) {
            return response()->json(['message' => "You must buy a package first!"]);
        }

        if (Carbon::parse($selectedSession['finishes_at']) < Carbon::now()) {
            return response()->json([
                'Message' => "This Session is already ended!",
            ]);
        }

        if (!Carbon::parse($selectedSession['starts_at'])->isToday()) {
            return response()->json([
                'Message' => "The session is not available!",
            ]);
        }

        if (in_array(request()->id, $userSessions)) {
            return response()->json(['message' => "You already attended this session"]);
        }

        Attendance::create([
            "user_id" => request()->user()->id,
            "training_session_id" => $selectedSession->id,
            "attendance_datetime" => Carbon::now(),
        ]);

        return response()->json([
            'Message' => "Session Attended successfully!",
        ]);
    }

    public function getRemainingSessions(Request $request)
    {
        $attendedSessions = $request->user()->attendances->count();
        $totalTrainingSessions = $request->user()->purchases->pluck('sessions_number')->sum();
        return $totalTrainingSessions - $attendedSessions;
    }
}
