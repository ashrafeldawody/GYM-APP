@extends('layouts.dashboard')

@section('content')

    @if (Session::has('success'))
        <div class="alert alert-success text-center">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
            <p>{{ Session::get('success') }}</p>
        </div>
    @endif

    @if(count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card card-primary w-75 m-auto">
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
@yield('page-footer')
@endsection

