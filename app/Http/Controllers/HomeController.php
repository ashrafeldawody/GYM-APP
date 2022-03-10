<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\City;
use App\Models\Purchase;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $years = Purchase::select(DB::raw('YEAR(created_at) as year'))->distinct()->orderBy('year','desc')->get()->pluck('year');
        return view('dashboard.home.index',compact('years'));
    }

    public function maleFemaleAttendanceData()
    {
        $males = Attendance::countByGender('male');
        $females = Attendance::countByGender('female');
        return [
            'labels' => ['Male','Female'],
            'values' => [$males,$females],
        ];
    }

    public function revenuePerMonth($year)
    {
        $purchases = Purchase::whereYear('created_at',$year)->select(DB::raw('sum(amount_paid)/100 as total'), DB::raw("DATE_FORMAT(created_at,'%M %Y') as month"))->groupBy('month')->get();
        $sorted_income = $purchases->sortBy(function ($item, $i) {
            return ( Carbon::parse($item->month)->format("m") );
        });
        $labels = $sorted_income->pluck('month')->toArray();
        $values = $sorted_income->pluck('total')->toArray();
        return compact('labels','values');

    }
    public function topCities(){
        $citiesSessions = City::select('name')->withCount('sessions')->limit(10)->get();
        $labels = $citiesSessions->pluck('name')->toArray();
        $values = $citiesSessions->pluck('sessions_count')->toArray();
        return compact('labels','values');
    }
    public function topUsers(){
        $users = User::select('name')->withCount('trainingSessions')->limit(10)->get();
        $labels = $users->pluck('name')->toArray();
        $values = $users->pluck('training_sessions_count')->toArray();
        return compact('labels','values');
    }
}
