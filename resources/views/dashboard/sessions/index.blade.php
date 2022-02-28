@extends('layouts.datatables')

@section('table_header')
    {{ __('Cities Table') }}
@endsection

@section('table_id')
    '#cities-table'
@endsection

@section('table_route')
    "{{ route('dashboard.cities.index') }}"
@endsection

@section('table_columns')
    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
    {data: 'name', name: 'name'},
    {data: 'manager_name', name: 'manager_name'},
@endsection
