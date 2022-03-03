<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;



class UserController extends Controller
{
    // public function index(){
    //     $users = UserResource::collection(User::all());
    //     return $users;
    // }

    
    public function show($UserId){
        // $userData = User::find($UserId);
        //to let the user show his info on the app
        $userData = UserResource::make(User::find($UserId));
        return $userData;
    }

    public function store(StoreUserRequest $request){
        //caution > [password_confirmation] must be in the request

        request()->merge([
            'password' => Hash::make(request()->password),
        ]);

        $requestData = request()->all();
        $newUser = User::create($requestData);

        // $newUser = User::create([
        //     'name' => request()->name,
        //     'gender' => request()->gender,
        //     'email' => request()->email,
        //     'password' => Hash::make(request()->password),
        //     'birth_date' => request()->birth_date,
        //     'profile_img' => request()->profile_img,
        // ]);

        return $newUser;
    }
}
