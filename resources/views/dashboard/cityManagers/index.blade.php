@extends('layouts.datatables')

@section('table_header')
    {{ __('City Managers Table') }}
@endsection

@section('table_route')
    "{{ route('dashboard.city_managers.index') }}"
@endsection

@section('form_data_endpoint')
    "{{ route('dashboard.city_managers.create') }}"
@endsection

@section('update_endpoint')
    "{{ route('dashboard.general_managers.update', '') }}"
@endsection

@section('table_columns')
    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
    {data: 'name', name: 'name'},
    {data: 'email', name: 'email'},
    {data: 'national_id', name: 'national_id'},
    {data: 'gender', name: 'gender'},
    {data: 'birth_date', name: 'birth_date'},
    {data: 'city', name: 'city'},
@endsection
