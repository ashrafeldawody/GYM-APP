<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;



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


    public function update($userId){

        $userToken = User::where('id', $userId)->first(['remember_token'])->remember_token;
        $requestToken = request()->bearerToken();
        dd($userToken,$requestToken);
        if($userToken == $requestToken){

            $userObj = User::find('id',$userId);
            dd($userObj);
            //request()->merge(['profile_img' => request('profile_img')->store('uploads','public')]);

            $user = User::where('id', $userId)
                ->update(['name' => request()->has('name') ? request()->name : $userObj->name,
            ]);

            return $user;
        }else{
            return "Error updating your information";
        }
    }
}
