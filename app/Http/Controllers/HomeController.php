<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Purchase;
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
        return view('dashboard.home.index', compact('maleFemaleChart','revenuePerMonth'));
    }

    private function maleFemaleAttendanceChart()
    {
        $maleAttendances = Attendance::countByGender('male');
        $femaleAttendances = Attendance::countByGender('female');
        return app()->chartjs
            ->name('pieChartTest')
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
            ->name('lineChartTest')
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

}
