@extends('layouts.datatables')

@section('table_header')
    {{ __('General Managers Table') }}
@endsection

@section('table_route')
    "{{ route('dashboard.general_managers.index') }}"
@endsection

@section('form_data_endpoint')
    "{{ route('dashboard.general_managers.create') }}"
@endsection

@section('add_endpoint')
    "{{ route('dashboard.general_managers.store') }}"
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
@endsection
