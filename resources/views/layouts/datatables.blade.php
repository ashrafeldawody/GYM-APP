@extends('layouts.dashboard')

@section('content')

<div class="container">
    @yield('page-start')
    <div class="row justify-content-center">
        <div class="col-md-12 mb-5">
            <div class="card">
                <div class="card-header"
                    style="position: -webkit-sticky; position: sticky; top: 0; z-index: 1020; backdrop-filter: blur(10px);">
                    <div class="d-flex justify-content-between">
                        <div class="h5 align-self-center my-2">@yield('table_header')</div>
                        <div class="d-flex">
                            <div id="controlsPanel" style="display: none;">
                                <div class="d-flex">
                                    <button id="toggleBanButton" class="btn btn-info mr-2"><i
                                            class="fa fa-trash pr-md-2 m-auto"></i>Ban</button>
                                    <button id="editButton" class="btn btn-primary mr-2"><i
                                            class="fa fa-pen pr-md-2 m-auto"></i>Edit</button>
                                    <button id="deleteButton" class="btn btn-danger mr-2"><i
                                            class="fa fa-trash pr-md-2 m-auto"></i>Delete</button>
                                </div>
                            </div>
                            <button id="addButton" class="btn btn-success"><i class="fa fa-plus pr-md-2 m-auto"></i>Add</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <div class="w-100">
                        {{$dataTable->table()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="toast shadow-lg m-3 fade hide" role="alert" aria-live="assertive" aria-atomic="true" data-delay="3500"
    style="position: fixed; right: 1.2rem; top: 0; margin-top: 1.2rem !important; z-index: 99999;">
    <div class="toast-header">
        <strong id="toastTitle" class="mr-auto w-100" style="min-width: 200px; width: 100%;"></strong>
        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="toast-body">
        <p id="toastMessage"></p>
    </div>
</div>

<div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addEditForm" enctype="multipart/form-data"></form>
                <div id="alertsDiv"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button id="formConfirmBtn" class="btn btn-primary">Update</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmTitle">Confirm</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="confirmMessage"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button id="confirmDeleteBtn" type="button" class="btn btn-danger">Delete</button>
            </div>
        </div>
    </div>
</div>

<script>
    const ajaxUrl = @yield('table_route', 'null');
    const formDataEndpoint = @yield('form_data_endpoint', 'null');
    const addEndpoint = @yield('add_endpoint', 'null');
    const updateEndpoint = @yield('update_endpoint', 'null');
    const destroyEndpoint = @yield('destroy_endpoint', 'null');
    const toggleBanEndpoint = @yield('toggle_ban_endpoint', 'null');

    const tableColumns = [@yield('table_columns')];

    const csrfToken = "{{ csrf_token() }}";

    window.useAppDatatablesScript = true;
</script>
@endsection
