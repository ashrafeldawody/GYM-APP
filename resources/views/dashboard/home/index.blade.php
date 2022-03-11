@extends('layouts.dashboard')

@section('content')
    <div class="content">
        <div class="container-fluid">
            @hasrole('admin')
            <div class="row">
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-success"><i class="fas fa-city"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Cities</span>
                            <span class="info-box-number">{{$citiesCount}}</span>
                        </div>
                    </div>

                </div>

                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning"><i class="fas fa-dumbbell"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Gyms</span>
                            <span class="info-box-number">{{$gymsCount}}</span>
                        </div>

                    </div>

                </div>

                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-danger"><i class="far fa-calendar"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Training Sessions</span>
                            <span class="info-box-number">{{ $trainingSessionsCount }}</span>
                        </div>

                    </div>

                </div>
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-info"><i class="far fa-user"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Users</span>
                            <span class="info-box-number">{{$usersCount}}</span>
                        </div>
                    </div>
                </div>
            </div>
            @endrole
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
                            <h3 class="card-title">Top Users</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="top-users"></canvas>

                        </div>
                    </div>

                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header border-0">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title">Yearly Revenue</h3>
                                <div class="form-group">
                                    <select class="form-control" id="yearSelect">
                                        @foreach($years as $year)
                                            <option value="{{$year}}">{{$year}}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="revenuePerMonth"></canvas>

                        </div>
                    </div>
                    @hasrole('admin')
                    <div class="card">
                        <div class="card-header border-0">
                            <h3 class="card-title">Top Cities Attendances</h3>
                        </div>
                        <div class="card-body table-responsive p-0">
                            <canvas id="top-cities"></canvas>
                        </div>
                    </div>
                    @endhasrole
                </div>
            </div>
        </div>
    </div>
    @hasrole('admin')
    <script>
        loadPieChart('#top-cities','{{route('dashboard.charts.top-cities')}}');
    </script>
    @endhasrole
    <script>
        $(function(){
            loadPieChart('#maleFemaleChart','{{route('dashboard.charts.male-female-attendance')}}');
            loadRevenueChart('#revenuePerMonth','{{route('dashboard.charts.revenue',2022)}}');
            loadPieChart('#top-users','{{route('dashboard.charts.top-users')}}');
            $('#yearSelect').on('change', function (e) {
                let selectedYear = this.value;
                let url = '{{ route("dashboard.charts.revenue", ":year") }}';
                loadRevenueChart('#revenuePerMonth',url.replace(':year', selectedYear));
            });

        } )
    </script>
@endsection
