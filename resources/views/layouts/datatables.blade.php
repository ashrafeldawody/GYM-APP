@extends('layouts.dashboard')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 mb-5">
            <div class="card">
                <div class="card-header">@yield('table_header')</div>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <div class="w-100">
                        {{$dataTable->table()}}
                    </div>
                    <div class="rounded fixed-bottom">
                        <div class="d-flex px-3 py-2" style="background-color: #1f1f1fd1">
                            <p class="m-auto"><span id="userMessage"></span></p>
                            <div id="controlsPanel" style="display: none;">
                                <button id="editButton" class="btn btn-primary mr-2"><i
                                        class="fa fa-pen mr-2"></i>Edit</button>
                                <button id="deleteButton" class="btn btn-danger mr-2"><i
                                        class="fa fa-trash mr-2"></i>Delete</button>
                            </div>
                            <button id="deleteButton" class="btn btn-success"><i
                                    class="fa fa-plus mr-2"></i>Add</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                <form id="addEditForm"></form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Update</button>
            </div>
        </div>
    </div>
</div>

{{-- @yield('table_script') --}}

<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/select/1.3.4/js/dataTables.select.min.js"></script>

<script type="text/javascript">
    $(function () {
        const ajaxUrl = @yield('table_route', 'null');
        const formDataEndpoint = @yield('form_data_endpoint', 'null');

        if (!ajaxUrl) return;

        const controlsPanel = $('#controlsPanel');
        const editButton = $('#editButton');
        const deleteButton = $('#deleteButton');
        const userMessage = $('#userMessage');
        const formElem = $('#addEditForm');
        const formLable = $('#formModalLabel');

        let datatable = $('#datatable').DataTable({
            bAutoWidth: false,
            scrollX: true,
            responsive: true,
            processing: true,
            serverSide: true,
            pageLength: 5,
            ajax: ajaxUrl,
            columns: [
                { "data": null, "defaultContent": "" },
                @yield('table_columns')
            ],
            columnDefs: [
                {
                    orderable: false,
                    className: 'select-checkbox',
                    targets: 0
                },
                {
                    orderable: false,
                    targets: 1
                }
            ],
            select: {
                style: 'os'/* 'multi' */,
                selector: 'td:first-child'
            },
            order: [[ 1, 'asc' ]]
        });

        datatable.on('select deselect', function (e, dt, type, indexes) {
            const selectedCount = datatable.rows('.selected').data().length;
            toggleControlPanel(selectedCount > 0);
        });

        // ----- * ----- * ----- * -----

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        });

        editButton.click(function () {
            $.ajax({
                url: formDataEndpoint,
                method: 'GET'
            })
            .done(function(formData) {
                // Set the form label
                formLable.html('Edit ' + formData.formLable);

                // Create the html form fields
                let formFields = '';
                formData.fields.forEach(field => {
                    if (field.type == 'text') {
                        formFields +=
                            `<div class="form-group">
                                <label for="${field.name}Input" class="col-form-label">${field.label}</label>
                                <input type="text" name="${field.name}" class="form-control" id="${field.name}Input">
                            </div>`;
                    } else if (field.type == 'select') {
                        formFields +=
                            `<div class="form-group">
                                <label for="${field.name}Input" class="col-form-label">${field.label}</label>
                                <select name="${field.name}" class="form-control">
                                    <option disabled>Select ${field.label}</option>
                                    ${
                                        field.options.map(option =>
                                            `<option value="${option.value}">${option.text}</option>`
                                        ).join("")
                                    }
                                </select>
                            </div>`;
                    }
                });
                formElem.html(formFields);

                // Show the modal
                $('#formModal').modal().show();
            });
        });

        deleteButton.click(function () {
            const itemId = datatable.rows('.selected').data()[0].id;
            if (itemId) {
                toggleControlPanel(false);
                $.ajax({
                    url: @yield('destroy_endpoint') + `/${itemId}`,
                    method: 'DELETE'
                })
                .done(function(response) {
                    if (response.result == true) {
                        datatable.row('.selected').remove().draw(true);
                        showSuccessMessage(response.userMessage);
                    } else {
                        datatable.rows('.selected').deselect();
                        showErrorMessage(response.userMessage);
                    }
                });
            }
        });

        // ----- * ----- * ----- * -----

        function toggleControlPanel(show) {
            show ? showControlPanel() : hideControlPanle();
        }

        function showControlPanel() {
            controlsPanel.show();
            const selectedCount = datatable.rows('.selected').data().length;
            formDataEndpoint ? editButton.show() : editButton.hide();
            showInfoMessage(`${selectedCount} items has been selected`);
        }

        function hideControlPanle() {
            controlsPanel.hide();
            showInfoMessage("");
        }

        // ----- * ----- * ----- * -----

        function showInfoMessage(message) {
            userMessage.attr('class', 'text-info');
            userMessage.html(message);
        }

        function showSuccessMessage(message) {
            userMessage.attr('class', 'text-success');
            userMessage.html(message);
        }

        function showErrorMessage(message) {
            userMessage.attr('class', 'text-danger');
            userMessage.html(message);
        }
    });
</script>
@endsection
