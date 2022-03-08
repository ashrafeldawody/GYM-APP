@extends('layouts.datatables')

@section('page-start')
    @include('dashboard.purchases.revenue')
@endsection
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
    {data: 'amount_paid', name: 'amount_paid',
    render: function( data, type, full, meta ) {
        return data.toFixed(2) + '$';
    }},
    @can('show_gym_data')
    {data: 'gym', name: 'gym'},
    @endcan
    @can('show_city_data')
    {data: 'city', name: 'city'},
    @endcan
@endsection
