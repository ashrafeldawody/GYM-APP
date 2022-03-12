<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\City;
use App\Models\Gym;
use App\Models\Purchase;
use App\Models\TrainingSession;
use App\Models\User;
use Carbon\Carbon;
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
        $citiesCount = City::count();
        $gymsCount = Gym::count();
        $trainingSessionsCount = TrainingSession::count();
        $usersCount = User::count();
        $years = Purchase::select(DB::raw('YEAR(created_at) as year'))->distinct()->orderBy('year', 'desc')->get()->pluck('year');
        return view('dashboard.home.index', compact('years', 'citiesCount', 'gymsCount', 'trainingSessionsCount', 'usersCount'));
    }

    public function maleFemaleAttendanceData()
    {
        $labels = ['Male', 'Female'];
        $males = Attendance::countByGender('male');
        $females = Attendance::countByGender('female');
        if ($males == 0 && $females == 0) {
            return [
                'labels' => $labels,
                'values' => [],
            ];
        } else {
            return [
                'labels' => $labels,
                'values' => [$males, $females],
            ];
        }
    }

    public function revenuePerMonth($year)
    {
        if (auth()->user()->hasRole('gym_manager')) {
            $purchasesIDs = auth()->user()->purchases->pluck('id')->toArray();
            $purchases = Purchase::whereYear('created_at', $year)->whereIn('id', $purchasesIDs)->select(DB::raw('sum(amount_paid)/100 as total'), DB::raw("DATE_FORMAT(created_at,'%M %Y') as month"))->groupBy('month')->get();
        } else if (auth()->user()->hasRole('city_manager')) {
            $purchasesIDs = auth()->user()->city->purchases->pluck('id')->toArray();
            $purchases = Purchase::whereYear('created_at', $year)->whereIn('id', $purchasesIDs)->select(DB::raw('sum(amount_paid)/100 as total'), DB::raw("DATE_FORMAT(created_at,'%M %Y') as month"))->groupBy('month')->get();
        } else {
            $purchases = Purchase::whereYear('created_at', $year)->select(DB::raw('sum(amount_paid)/100 as total'), DB::raw("DATE_FORMAT(created_at,'%M %Y') as month"))->groupBy('month')->get();
        }

        $sorted_income = $purchases->sortBy(function ($item) {
            return (Carbon::parse($item->month)->format("m"));
        });
        $labels = $sorted_income->pluck('month')->toArray();
        $values = $sorted_income->pluck('total')->toArray();
        return compact('labels', 'values');
    }

    public function topCities()
    {
        $citiesSessions = City::select('name')->withCount('sessions')->limit(10)->get();
        $labels = $citiesSessions->pluck('name')->toArray();
        $values = $citiesSessions->pluck('sessions_count')->toArray();
        return compact('labels', 'values');
    }

    public function topUsers()
    {
        if (auth()->user()->hasRole('gym_manager')) {
            $userIDs = auth()->user()->gym->attendances->pluck('user_id')->toArray();
            $users = User::whereIn('id', $userIDs)->select('name')->whereHas('trainingSessions')->withCount('trainingSessions')->limit(10)->get();
        } else if (auth()->user()->hasRole('city_manager')) {
            $userIDs = auth()->user()->city->attendances->pluck('user_id')->toArray();
            $users = User::whereIn('id', $userIDs)->select('name')->whereHas('trainingSessions')->withCount('trainingSessions')->limit(10)->get();
        } else {
            $users = User::select('name')->whereHas('trainingSessions')->withCount('trainingSessions')->limit(10)->get();
        }

        $labels = $users->pluck('name')->toArray();
        $values = $users->pluck('training_sessions_count')->toArray();
        return compact('labels', 'values');
    }
}
