<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserInfoRequest;
use App\Http\Resources\AttendanceApiResource;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    // public function __construct($userId){
    //     $userToken = User::where('id', $userId)->first(['remember_token'])->remember_token;
    //     $requestToken = request()->bearerToken();
    //     if ($userToken != $requestToken) {
    //         return response()
    //         ->json(['message' => 'Forbidden access, You are not allowed to show or edit this information!']);
    //     }
    // }
    // public function index(){
    //     $users = UserResource::collection(User::all());
    //     return $users;
    // }

    public function show($userId){
        $userToken = User::find($userId)->remember_token;
        $requestToken = request()->bearerToken();

        if ($userToken == $requestToken) {
            $userData = UserResource::make(User::find($userId));
            return $userData;
        } else {
            return response()
                    ->json(['message' => 'Forbidden access, You are not allowed to show this information!']);
        }
    }

    public function getHistory($userId,User $user){
        $userToken = User::find($userId)->remember_token;
        $requestToken = request()->bearerToken();

        if($userToken == $requestToken){
            return AttendanceApiResource::collection($user->attendances);
        }else{
            return response()
                ->json(['message' => 'Forbidden access, You are not allowed to show this information!']);
        }

    }



    public function update($userId,Request $request,UpdateUserInfoRequest $validate){

        $userToken =User::find($userId)->remember_token;
        $requestToken = request()->bearerToken();

        unset($request['_method']);
        unset($request['password_confirmation']);

        if($userToken == $requestToken){
            $request->merge(['password' => Hash::make(request()->password)]);
            User::find($userId)->update(request()->all());

            if($request->has('avatar')){
                User::find($userId)
                    ->update(['avatar'=> $request->file('avatar')->store('uploads','public')]);
            }

            return response()
                ->json(['message' => 'Information updated successfully!']);

        }else{
            return response()
                ->json(['message' => 'Error updating your information!']);
        }
    }

    public function getRemainingSessions($userId) {
        $userToken = User::find($userId)->remember_token;
        $requestToken = request()->bearerToken();
        if($userToken == $requestToken) {
            $attendedSessions = User::find($userId)->attendances->count();
            $totalTrainingSessions = User::find($userId)->packages->pluck('sessions_number')->sum();
            $remainingSessionsCount = $totalTrainingSessions - $attendedSessions;
            return response()->json([
                'total_training_sessions'=> $totalTrainingSessions,
                'remaining__training_sessions'=> $remainingSessionsCount,
            ]);
        } else {
            return response()
                ->json(['message' => 'Forbidden access, You are not allowed to show this information!']);
        }
    }

    public function setRemainingSession($userId){
        $userToken = User::find($userId)->remember_token;
        $requestToken = request()->bearerToken();
        if($userToken == $requestToken){

        }
    }
}
