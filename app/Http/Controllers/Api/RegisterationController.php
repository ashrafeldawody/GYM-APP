<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreUserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Auth\Events\Registered;


class RegisterationController extends Controller
{
    public function registerNewUser(StoreUserRequest $request){
        //caution > [password_confirmation] must be in the request

        // request()->merge(['password' => Hash::make(request()->password)]);
        // request()->merge(['avatar' => request('avatar')->store('uploads','public')]);
        // dd(request());

        // $requestData = request()->all();
        // $newUser = User::create($requestData);

        $newUser = User::create([
            'name' => request()->name,
            'email' => request()->email,
            'gender'=> request()->gender,
            'birth_date'=> request()->birth_date,
            'password'=> Hash::make(request()->password),
            'avatar'=> request('avatar')->store('uploads','public'),
        ]);

        if($newUser){
            event(new Registered($newUser));
            $newUser["Verification Status"] = "An Email has been sent to your mail, Please verify your mail";
            return $newUser;
        }else{
            return "An error ocurred while registering your information";
        }


    }
}
