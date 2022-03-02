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
        $user = Manager::find(Auth::user()->id);
        $user->password = Hash::make($request->all()['password']);
        $user->save();
        Auth::logout();
        return redirect()->route('login');
    }
    public function updateBasicInformation(Request $request)
    {
        dd($request);
    }

}
