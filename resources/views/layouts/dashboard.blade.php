@extends('layouts.app')

@section('body')
    <script src="{{ mix('js/app.js') }}"></script>

    <x-navbar></x-navbar>
    <x-sidebar></x-sidebar>

    <div class="content-wrapper p-4">
        @yield('content')
    </div>
@endsection

