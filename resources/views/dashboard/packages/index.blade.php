@extends('layouts.datatables')

@section('table_header')
    {{ __('Packages Table') }}
@endsection

@section('table_id')
    '#packages-table'
@endsection

@section('table_route')
    "{{ route('dashboard.packages.index') }}"
@endsection

@section('form_data_endpoint')
    "{{ route('dashboard.packages.create') }}"
@endsection

@section('add_endpoint')
    "{{ route('dashboard.packages.store') }}"
@endsection

@section('update_endpoint')
    "{{ route('dashboard.packages.update', '') }}"
@endsection

@section('destroy_endpoint')
    "{{ route('dashboard.packages.destroy', '') }}"
@endsection

@section('table_columns')
    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
    {data: 'name', name: 'name'},
    {data: 'price', name: 'price'},
    {data: 'sessions_number', name: 'sessions_number'},
@endsection
