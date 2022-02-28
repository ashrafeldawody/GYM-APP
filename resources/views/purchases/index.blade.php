@extends('layouts.datatables')

@section('table_header')
    {{ __('purchases Table') }}
@endsection

@section('table_id')
    '#purchases-table'
@endsection

@section('table_route')
    "{{ route('dashboard.purchases.index') }}"
@endsection

@section('table_columns')
    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
    {data: 'user_name', name: 'user_name'},
    {data: 'user_email', name: 'user_email'},
    {data: 'package_name', name: 'package_name'},
    {data: 'amount_paid', name: 'amount_paid'},
    {data: 'gym', name: 'gym'},
    {data: 'city', name: 'city'},
@endsection
