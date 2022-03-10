@extends('layouts.datatables')
@section('table_header')
    {{ __('Gyms Table') }}
@endsection

@section('table_route')
    "{{ route('dashboard.gyms.index') }}"
@endsection

@section('form_data_endpoint')
    "{{ route('dashboard.gyms.create') }}"
@endsection

@section('add_endpoint')
    "{{ route('dashboard.gyms.store') }}"
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
    {data: 'created_at', name: 'created_at'},
    {data: 'cover_image', name: 'cover_image',
    render: function( data, type, full, meta ) {
    return "<img src=\"/" + data + "\" height=\"100rem\" alt='No Image'/>";
    }
    },
    @can('show_city_data')
        {data: 'city_manager_name', name: 'city_manager_name'},
    @endcan
@endsection
