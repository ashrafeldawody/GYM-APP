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
        return view('dashboard.home.index');
    }

    public function maleFemaleAttendanceData()
    {
        $Male = Attendance::countByGender('male');
        $Female = Attendance::countByGender('female');
        return compact('Male','Female');
    }

    public function revenuePerMonth($year)
    {
        $purchases = Purchase::whereYear('created_at',$year)->select(DB::raw('sum(amount_paid)/100 as total'), DB::raw("DATE_FORMAT(created_at,'%M %Y') as month"))->groupBy('month')->get();
        $sorted_income = $purchases->sortBy(function ($item, $i) {
            return ( Carbon::parse($item->month)->format("m") );
        });
        $months = $sorted_income->pluck('month')->toArray();
        $incomes = $sorted_income->pluck('total')->toArray();
        return compact('months','incomes');

    }
    public function getCityAttendanceChart(){
        $citiesSessions = City::select('name')->withCount('sessions')->get();
        return app()->chartjs
            ->name('citiesAttendancesChart')
            ->type('pie')
            ->size(['width' => 400, 'height' => 200])
            ->labels($citiesSessions->pluck('name')->toArray())
            ->datasets([
                [
                    'backgroundColor' => ["#84FF63","#8463FF","#6384FF",'#FFB399', '#FF33FF', '#FFFF99', '#00B3E6', '#E6B333', '#3366E6', '#999966',],
                    'hoverBackgroundColor' => ["#84FF63",'#FF6384', '#36A2EB','#FFB399', '#FF33FF', '#FFFF99', '#00B3E6', '#E6B333', '#3366E6', '#999966',],
                    'data' => $citiesSessions->pluck('sessions_count')->toArray()
                ]
            ])
            ->options([]);
    }
    public function getTopUsersChart(){
        $users = User::select('name')->withCount('trainingSessions')->limit(10)->get();
        return app()->chartjs
            ->name('topUsersChart')
            ->type('pie')
            ->size(['width' => 400, 'height' => 200])
            ->labels($users->pluck('name')->toArray())
            ->datasets([
                [
                    'backgroundColor' => ['#FF6633', '#FFB399', '#FF33FF', '#FFFF99', '#00B3E6', '#E6B333', '#3366E6', '#999966', '#99FF99', '#B34D4D', '#80B300', '#809900', '#E6B3B3', '#6680B3', '#66991A'],
                    'hoverBackgroundColor' => ['#FF6633', '#FFB399', '#FF33FF', '#FFFF99', '#00B3E6', '#E6B333', '#3366E6', '#999966', '#99FF99', '#B34D4D', '#80B300', '#809900', '#E6B3B3', '#6680B3', '#66991A'],
                    'data' => $users->pluck('training_sessions_count')->toArray()
                ]
            ])
            ->options([]);
    }
}
