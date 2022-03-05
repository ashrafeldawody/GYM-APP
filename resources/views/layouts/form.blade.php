@extends('layouts.dashboard')

@section('content')
    <div class="card card-primary w-75 m-auto">
        <div class="card-header">
            @yield("card-title")
        </div>

        <form action="@yield("form-action")" method="POST" enctype="multipart/form-data">
        @csrf
        @yield('form-method')
        <div class="card-body">
                @yield('form-content')
        </div>
            <div class="card-footer text-right">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>

    </div>
@endsection

