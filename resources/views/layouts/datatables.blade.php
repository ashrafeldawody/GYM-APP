@extends('layouts.dashboard')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">@yield('table_header')</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="">
                            {{$dataTable->table()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@yield('table_script')

<script type="text/javascript">
    window.addEventListener('DOMContentLoaded', (event) => {
    $(function () {
        let table = $(@yield('table_id')).DataTable({
            processing: true,
            serverSide: true,
            ajax: @yield('table_route'),
            columns: [
                @yield('table_columns')
                {
                    data: 'action',
                    name: 'action',
                    orderable: true,
                    searchable: true
                },
            ]
        });
    });
});
</script>

