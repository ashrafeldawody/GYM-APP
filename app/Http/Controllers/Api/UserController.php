<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserInfoRequest;
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
    // public function index(){
    //     $users = UserResource::collection(User::all());
    //     return $users;
    // }

    public function show($userId){
        $userToken = User::where('id', $userId)->first(['remember_token'])->remember_token;
        $requestToken = request()->bearerToken();

        if ($userToken == $requestToken) {
            $userData = UserResource::make(User::find($userId));
            return $userData;
        } else {

        return response()
                ->json(['message' => 'Forbidden access, You are not allowed to show this information!']);
        }
    }        
    


    public function update($userId,Request $request,UpdateUserInfoRequest $validate){

        $userToken = User::where('id', $userId)->first(['remember_token'])->remember_token;
        $requestToken = request()->bearerToken();

        unset($request['_method']);
        unset($request['password_confirmation']);

        if($userToken == $requestToken){
            $request->merge(['password' => Hash::make(request()->password)]);
            User::where('id', $userId)->update(request()->all());

            if($request->has('avatar')){
                User::where('id', $userId)
                    ->update(['avatar'=> $request->file('avatar')->store('uploads','public')]);
            }

            return response()
                ->json(['message' => 'Information updated successfully!']);

        }else{
            return response()
                ->json(['message' => 'Error updating your information!']);
        }
    }

    public function getRemainingSessions($userId){
        $userToken = User::where('id', $userId)->first(['remember_token'])->remember_token;
        $requestToken = request()->bearerToken();
        if($userToken == $requestToken){   

        $remainingSessionsCount = User::where('id',$userId)->random()->trainingSessions
          ->where('starts_at', '>',Carbon::now())->count();
        $total_training_sessions = User::where('id',$userId)->random()->trainingSessions;

        return response()
        ->json([
            'total_training_sessions'=> $total_training_sessions,
            'remaining__training_sessions'=> $remainingSessionsCount,
            ]);
        }
    }

    public function setRemainingSession($userId){
        $userToken = User::where('id', $userId)->first(['remember_token'])->remember_token;
        $requestToken = request()->bearerToken();
        if($userToken == $requestToken){

        }
    }
}

/*
 * get the remaining packages replace all by
 * TrainingSession::all()->where('starts_at', '>', Illuminate\Support\Carbon::now())->count();
 * $this->trainingSessions->count(); // total
 * $this->trainingSessions->where('starts_at', '>', Illuminate\Support\Carbon::now())->count(); // remaining
 *
 * */


