@extends('layouts.dashboard')

@section('content')

    <div class="w-75 m-auto">
        @if(Session::has('message'))
            <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
        @endif
    <div class="card card-primary">

        <div class="card-header">
            @yield("card-title")
        </div>

        <form action="@yield("form-action")" method="POST" enctype="multipart/form-data" id="mainForm">
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
    </div>
@endsection

