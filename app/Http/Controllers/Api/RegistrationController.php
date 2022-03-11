<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreUserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Auth\Events\Registered;

class RegistrationController extends Controller
{
    public function registerNewUser(StoreUserRequest $request)
    {
        $newUser = User::create([
            'name' => request()->name,
            'email' => request()->email,
            'gender' => request()->gender,
            'birth_date' => request()->birth_date,
            'password' => Hash::make(request()->password),
        ]);

        if ($request->has('avatar')) {
            User::where('id', $newUser->id)
                ->update(['avatar' => $request->file('avatar')->store('uploads', 'public')]);
        }

        if ($newUser) {
            event(new Registered($newUser));
            $newUser["Verification Status"] = "An Email has been sent to your mail, Please verify your mail";

            return $newUser;
        } else {

            return response()
                ->json(['message' => 'An error ocurred while registering your information!']);
        }
    }
}
