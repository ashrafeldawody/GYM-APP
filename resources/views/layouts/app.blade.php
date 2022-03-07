<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel App') }}</title>
    @stack('scripts')
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="{{ mix('css/main.css') }}" rel="stylesheet">
    <script src="{{ mix('js/main.js') }}"></script>

</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
        @yield('body')
</div>
</body>
</html>
