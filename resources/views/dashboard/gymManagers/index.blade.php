@extends('layouts.datatables')

@section('table_header')
    {{ __('Gym Managers Table') }}
@endsection

@section('table_route')
    "{{ route('dashboard.gym_managers.index') }}"
@endsection

@section('form_data_endpoint')
    "{{ route('dashboard.gym_managers.create') }}"
@endsection

@section('add_endpoint')
    "{{ route('dashboard.gym_managers.store') }}"
@endsection

@section('update_endpoint')
    "{{ route('dashboard.general_managers.update', '') }}"
@endsection

@section('destroy_endpoint')
    "{{ route('dashboard.gym_managers.destroy', '') }}"
@endsection

@section('toggle_ban_endpoint')
    "{{ route('dashboard.gym_managers.ban', '') }}"
@endsection

@section('table_columns')
    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
    {data: 'name', name: 'name'},
    {data: 'email', name: 'email'},
    {data: 'national_id', name: 'national_id'},
    {data: 'gender', name: 'gender'},
    {data: 'birth_date', name: 'birth_date'},
    {data: 'gym', name: 'gym'},
    @can('show_city_data')
        {data: 'city', name: 'city'},
    @endcan
@endsection
