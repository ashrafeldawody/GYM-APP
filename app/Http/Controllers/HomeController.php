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
        $maleFemaleChart = $this->maleFemaleAttendanceChart();
        $revenuePerMonth = $this->revenuePerMonth();
        $citiesAttendances = $this->getCityAttendanceChart();
        $usersCart = $this->getTopUsersChart();
        return view('dashboard.home.index', compact('maleFemaleChart','revenuePerMonth','citiesAttendances','usersCart'));
    }

    private function maleFemaleAttendanceChart()
    {
        $maleAttendances = Attendance::countByGender('male');
        $femaleAttendances = Attendance::countByGender('female');
        return app()->chartjs
            ->name('maleFemaleChart')
            ->type('pie')
            ->size(['width' => 400, 'height' => 200])
            ->labels(['Male', 'Female'])
            ->datasets([
                [
                    'backgroundColor' => ['#FF6384', '#36A2EB'],
                    'hoverBackgroundColor' => ['#FF6384', '#36A2EB'],
                    'data' => [$maleAttendances, $femaleAttendances]
                ]
            ])
            ->options([]);
    }

    private function revenuePerMonth()
    {
        $purchases = Purchase::whereYear('created_at',now()->year)->select(DB::raw('sum(amount_paid)/100 as total'), DB::raw("DATE_FORMAT(created_at,'%M %Y') as month"))->groupBy('month')->get();
        $sorted_income = $purchases->sortBy(function ($item, $i) {
            return ( Carbon::parse($item->month)->format("m") );
        });

        return app()->chartjs
            ->name('revenueChart')
            ->type('line')
            ->size(['width' => 400, 'height' => 200])
            ->labels($sorted_income->pluck('month')->toArray())
            ->datasets([
                [
                    "label" => "Revenue of " . now()->year,
                    "borderColor" => "#80b6f4",
                    "pointBorderColor" => "#80b6f4",
                    "pointBackgroundColor" => "#80b6f4",
                    "pointHoverBackgroundColor" => "#80b6f4",
                    "pointHoverBorderColor" => "#80b6f4",
                    "pointBorderWidth" => "10",
                    "pointHoverRadius" => "10",
                    "pointHoverBorderWidth" => "1",
                    "pointRadius" => "3",
                    "fill" => "false",
                    "borderWidth" => "4",
                    'data' => $sorted_income->pluck('total')->toArray(),
                ]
            ])
            ->options([]);

    }
    private function getCityAttendanceChart(){
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
    private function getTopUsersChart(){
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
