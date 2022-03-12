@extends('layouts.datatables')

@section('table_header')
    {{ __('Users Table') }}
@endsection

@section('table_id')
    '#users-table'
@endsection

@section('table_route')
    "{{ route('dashboard.users.index') }}"
@endsection

@section('form_data_endpoint')
    "{{ route('dashboard.users.create') }}"
@endsection

@section('add_endpoint')
    "{{ route('dashboard.users.store') }}"
@endsection

@section('update_endpoint')
    "{{ route('dashboard.users.update', '') }}"
@endsection

@section('destroy_endpoint')
    "{{ route('dashboard.users.destroy', '') }}"
@endsection

@section('table_columns')
    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
    {data: 'name', name: 'name'},
    {data: 'email', name: 'email'},
    {data: 'gender', name: 'gender'},
    {data: 'birth_date', name: 'birth_date'},
@endsection
