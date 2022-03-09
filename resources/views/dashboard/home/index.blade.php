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
                            {!! $maleFemaleChart->render() !!}
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header border-0">
                            <h3 class="card-title">Top Cities Attendances</h3>
                        </div>
                        <div class="card-body table-responsive p-0">
                            {!! $citiesAttendances->render() !!}
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header border-0">
                            <h3 class="card-title">Revenue Of {{ now()->year }}</h3>
                        </div>
                        <div class="card-body">
                            {!! $revenuePerMonth->render() !!}

                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header border-0">
                            <h3 class="card-title">Top Users</h3>
                        </div>
                        <div class="card-body">
                            {!! $usersCart->render() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
