@extends('layouts.datatables')

@section('table_header')
    {{ __('Coaches Table') }}
@endsection

@section('table_route')
    "{{ route('dashboard.gyms.index') }}"
@endsection

@section('form_data_endpoint')
    "{{ route('dashboard.gyms.formData') }}"
@endsection

@section('add_endpoint')
    "{{ route('dashboard.gyms.create') }}"
@endsection

@section('update_endpoint')
    "{{ route('dashboard.gyms.update', '') }}"
@endsection

@section('destroy_endpoint')
    "{{ route('dashboard.gyms.destroy', '') }}"
@endsection
@section('table_columns')
    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
    {data: 'name', name: 'name'},
    @can('show_gym_data')
        {data: 'gym', name: 'gym'},
    @endcan
    @can('show_city_data')
        {data: 'city', name: 'city'},
    @endcan
@endsection
