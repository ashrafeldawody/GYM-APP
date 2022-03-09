@extends('layouts.datatables')

@section('table_header')
    {{ __('Sessions Table') }}
@endsection

@section('table_id')
    '#sessions-table'
@endsection

@section('table_route')
    "{{ route('dashboard.sessions.index') }}"
@endsection

@section('destroy_endpoint')
    "{{ route('dashboard.sessions.destroy', '') }}"
@endsection


@section('form_data_endpoint')
    "{{ route('dashboard.sessions.create') }}"
@endsection

@section('add_endpoint')
    "{{ route('dashboard.sessions.store') }}"
@endsection

@section('update_endpoint')
    "{{ route('dashboard.sessions.update', '') }}"
@endsection



@section('table_columns')
    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
    {data: 'name', name: 'name'},
    {data: 'starts_at', name: 'starts_at'},
    {data: 'finishes_at', name: 'finishes_at'},
    @can('show_gym_data')
        {data: 'gym', name: 'gym'},
    @endcan
    @can('show_city_data')
        {data: 'city', name: 'city'},
    @endcan
@endsection
