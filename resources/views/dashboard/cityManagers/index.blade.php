@extends('layouts.datatables')

@section('table_header')
    {{ __('City Managers Table') }}
@endsection

@section('table_route')
    "{{ route('dashboard.city-managers.index') }}"
@endsection

@section('form_data_endpoint')
    "{{ route('dashboard.city-managers.formData') }}"
@endsection

@section('add_endpoint')
    "{{ route('dashboard.city-managers.create') }}"
@endsection

@section('update_endpoint')
    "{{ route('dashboard.city-managers.update', '') }}"
@endsection

@section('destroy_endpoint')
    "{{ route('dashboard.city-managers.destroy', '') }}"
@endsection

@section('table_columns')
    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
    {data: 'name', name: 'name'},
    {data: 'email', name: 'email'},
    {data: 'national_id', name: 'national_id'},
    {data: 'gender', name: 'gender'},
    {data: 'birth_date', name: 'birth_date'},
@endsection
