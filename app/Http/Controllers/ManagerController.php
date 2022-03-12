<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateBasicInformationRequest;
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
        return view('dashboard.accountSettings.index', compact('user'));
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

    public function updateBasicInformation(UpdateBasicInformationRequest $request)
    {
        Auth::user()->update([
            "name" => $request->name,
            "email" => $request->email,
            "birth_date" => $request->birth_date,
            "gender" => $request->gender,
        ]);
        if ($request->file('avatar') != null) {
            Auth::user()->update([
                "avatar" => $request->file('avatar')->store('images', 'public')
            ]);
        }
        return redirect()->route('dashboard.account.index')->with('message', 'Your Information has been updated!');
    }
}
