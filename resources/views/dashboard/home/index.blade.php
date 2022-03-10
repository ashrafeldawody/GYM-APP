@extends('layouts.dashboard')

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header border-0">
                            <h3 class="card-title">Male / Female Attendance</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="maleFemaleChart"></canvas>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header border-0">
                            <h3 class="card-title">Top Cities Attendances</h3>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <canvas id="citiesAttendances"></canvas>

                            {{--                            {!! $citiesAttendances->render() !!}--}}
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header border-0">
                            <h3 class="card-title">Revenue Of {{ now()->year }}</h3>
                        </div>
                        <div class="card-body">
{{--                            {!! $revenuePerMonth->render() !!}--}}
                            <canvas id="revenuePerMonth"></canvas>

                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header border-0">
                            <h3 class="card-title">Top Users</h3>
                        </div>
                        <div class="card-body">
{{--                            {!! $usersCart->render() !!}--}}
                            <canvas id="usersCart"></canvas>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function(){
            loadMaleFemaleChart('#maleFemaleChart','{{route('dashboard.carts.male-female-attendance')}}');
            loadRevenueChart('#revenuePerMonth','{{route('dashboard.carts.revenue',2022)}}');
        } )
    </script>
@endsection
