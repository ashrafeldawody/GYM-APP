<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserInfoRequest;
use App\Http\Resources\AttendanceApiResource;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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

        // Validator::make(request()->all(), [
        // 'title' =>['required',Rule::unique('posts')->ignore($update)], //ignore unique title on this id on update
        // 'description'=>['required','min:10'],
        // 'user_id'=>['required'],
        // ])->validate();

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

    public function getRemainingSessions(Request $request)
    {

        $attendedSessions = $request->user()->attendances->count();
        $totalTrainingSessions = $request->user()->packages->pluck('sessions_number')->sum();
        $remainingSessionsCount = $totalTrainingSessions - $attendedSessions;

        return response()->json([
            'total_training_sessions' => $totalTrainingSessions,
            'remaining_training_sessions' => $remainingSessionsCount,
        ]);
    }

    public function setRemainingSession(Request $request)
    {
    }
}
