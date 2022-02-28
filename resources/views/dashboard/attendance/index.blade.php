@extends('layouts.datatables')

@section('table_header')
    {{ __('Attendance Table') }}
@endsection

@section('table_id')
    '#attendance-table'
@endsection

@section('table_route')
    "{{ route('dashboard.attendance.index') }}"
@endsection

@section('table_columns')
    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
    {data: 'user_name', name: 'user_name'},
    {data: 'user_email', name: 'user_email'},
    {data: 'session_name', name: 'session_name'},
    {data: 'attendance_time', name: 'attendance_time'},
    {data: 'attendance_date', name: 'attendance_date'},
    {data: 'gym', name: 'gym'},
    {data: 'city', name: 'city'},
@endsection
