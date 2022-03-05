<?php

namespace App\Http\Controllers;

use App\Models\Manager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        return view('dashboard.accountSettings.index',compact('user'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed',
        ]);
        Auth::user()->update([
            'password' => Hash::make($request->all()['password'])
        ]);
        return redirect()->route('dashboard.account.index')->with('message', 'Your Password has been updated!');
    }
    public function updateBasicInformation(Request $request)
    {

        $request->validate([
            'name' => 'required|min:3|max:100',
            'email' => 'required|email:rfc,dns|max:100',
            'gender' => 'required|in:male,female',
            'birth_date' => 'date_format:Y-m-d|before:today',
            'avatar' => 'mimes:jpg,jpeg,bmp,png'
        ]);
        Auth::user()->update([
              "name" => $request->name,
              "email" => $request->email,
              "birth_date" => $request->birth_date,
              "gender" => $request->gender,
        ]);
        if($request->file('avatar') != null){
            Auth::user()->update([
                "avatar" => $request->file('avatar')->store('images/avatars','public')
            ]);
        }
        return redirect()->route('dashboard.account.index')->with('message', 'Your Information has been updated!');
    }

}
