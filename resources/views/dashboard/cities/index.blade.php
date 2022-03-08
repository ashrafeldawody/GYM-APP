@extends('layouts.datatables')

@section('table_header')
    {{ __('Cities Table') }}
@endsection

@section('destroy_endpoint')
    "{{ route('dashboard.cities.destroy', '') }}"
@endsection

@section('table_route')
    "{{ route('dashboard.cities.index') }}"
@endsection

@section('add_endpoint')
    "{{ route('dashboard.cities.store') }}"
@endsection

@section('update_endpoint')
    "{{ route('dashboard.cities.update', '') }}"
@endsection

@section('form_data_endpoint')
    "{{ route('dashboard.cities.create') }}"
@endsection

@section('table_columns')
    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
    {data: 'name', name: 'name'},
    {data: 'manager_name', name: 'manager_name'},
@endsection
