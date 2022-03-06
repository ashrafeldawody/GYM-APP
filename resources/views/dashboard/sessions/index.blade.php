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

@section('table_columns')
    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
    {data: 'name', name: 'name'},
    {data: 'starts_at', name: 'starts_at'},
    {data: 'finishes_at', name: 'finishes_at'},
@endsection
