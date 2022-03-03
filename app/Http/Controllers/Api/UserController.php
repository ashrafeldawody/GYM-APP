<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Models\User;


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

    public function store(){
        $requestData = request()->all();
        $newuser = User::create($requestData);
        return $newuser;
    }
}
