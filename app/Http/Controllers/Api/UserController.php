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

        if($userToken == $requestToken){ //to make sure every user show and edit his info only
            $userData = UserResource::make(User::find($userId));
            return $userData;
        }else{
            return "Forbidden access, You are not allowed to show this information";
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


            return "Information updated successfully";
        }else{
            return "Error updating your information";
        }
    }
}
