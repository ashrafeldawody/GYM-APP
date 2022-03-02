<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function updatePassword(Request $request, $id)
    {
        dd($request);
    }
    public function updateBasicInformation(Request $request, $id)
    {
        dd($request);
    }

}
