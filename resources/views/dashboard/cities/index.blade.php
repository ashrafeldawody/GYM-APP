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

@section('form_data_endpoint')
    "{{ route('dashboard.cities.formData') }}"
@endsection

@section('table_columns')
    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
    {data: 'name', name: 'name'},
    {data: 'manager_name', name: 'manager_name'},
@endsection
