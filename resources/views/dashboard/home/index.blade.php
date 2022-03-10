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
                                <h3 class="card-title">Revenue Of {{ now()->year }}</h3>
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
    <script>
        $(function(){
            loadPieChart('#maleFemaleChart','{{route('dashboard.charts.male-female-attendance')}}');
            loadRevenueChart('#revenuePerMonth','{{route('dashboard.charts.revenue',2022)}}');
            loadPieChart('#top-cities','{{route('dashboard.charts.top-cities')}}');
            loadPieChart('#top-users','{{route('dashboard.charts.top-users')}}');
            $('#yearSelect').on('change', function (e) {
                let selectedYear = this.value;
                let url = '{{ route("dashboard.charts.revenue", ":year") }}';
                loadRevenueChart('#revenuePerMonth',url.replace(':year', selectedYear));
            });

        } )
    </script>
@endsection
