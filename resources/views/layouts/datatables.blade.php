@extends('layouts.dashboard')

@section('content')
<div class="container">
    @yield('page-start')
    <div class="row justify-content-center">
        <div class="col-md-12 mb-5">
            <div class="card">
                <div class="card-header bg-light sticky-top">
                    <div class="d-flex justify-content-between">
                        <div class="h5 align-self-center my-2">@yield('table_header')</div>
                        <div class="d-flex">
                            <div id="controlsPanel" style="display: none;">
                                <button id="editButton" class="btn btn-primary mr-2"><i
                                        class="fa fa-pen mr-2"></i>Edit</button>
                                <button id="deleteButton" class="btn btn-danger mr-2"><i
                                        class="fa fa-trash mr-2"></i>Delete</button>
                            </div>
                            <button id="addButton" class="btn btn-success"><i class="fa fa-plus mr-2"></i>Add</button>
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
    style="position: fixed; right: 0; top: 0; margin-top: 1rem !important; z-index: 99999;">
    <div class="toast-header">
        <strong id="toastTitle" class="mr-auto" style="min-width: 200px"></strong>
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
                <form id="addEditForm"></form>
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

{{-- @yield('table_script') --}}

<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/select/1.3.4/js/dataTables.select.min.js"></script>

<script type="text/javascript">
    $(function () {
        const ajaxUrl = @yield('table_route', 'null');
        const formDataEndpoint = @yield('form_data_endpoint', 'null');
        const addEndpoint = @yield('add_endpoint', 'null');
        const updateEndpoint = @yield('update_endpoint', 'null');
        const destroyEndpoint = @yield('destroy_endpoint', 'null');

        if (!ajaxUrl) return;

        let isSelectable = addEndpoint != null || updateEndpoint != null || destroyEndpoint != null;
        console.log(isSelectable);

        const controlsPanel = $('#controlsPanel');
        const addButton = $('#addButton');
        const editButton = $('#editButton');
        const deleteButton = $('#deleteButton');
        const formElem = $('#addEditForm');
        const formLable = $('#formModalLabel');
        const formConfirmBtn = $('#formConfirmBtn');
        const alertsDiv = $('#alertsDiv');
        const confirmModal = $('#confirmModal');
        const confirmMessage = $('#confirmMessage');

        if (!addEndpoint) addButton.hide();

        let datatable = $('#datatable').DataTable({
            bAutoWidth: false,
            scrollX: true,
            responsive: true,
            processing: true,
            serverSide: true,
            pageLength: 10,
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
            select: isSelectable && {
                style: 'os',
                selector: 'td'
            },
            createdRow: function (row, data, index) {
                $(row).css('cursor', 'pointer');
            },
            order: [[ 1, 'asc' ]]
        });

        datatable.on('select deselect draw.dt', function (e, dt, type, indexes) {
            const selectedCount = datatable.rows('.selected').data().length;
            toggleControlPanel(selectedCount > 0);
        });

        // ----- * ----- * ----- * -----

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        });

        addButton.click(function() {
            formConfirmBtn.off().click(submitAdd);
            formConfirmBtn.attr('class', 'btn btn-success');
            formConfirmBtn.html('Add');
            showFormModal(false);
        });

        editButton.click(function() {
            formConfirmBtn.off().click(submitEdit);
            formConfirmBtn.attr('class', 'btn btn-primary');
            formConfirmBtn.html('Update');
            showFormModal(true);
        });

        deleteButton.click(showDeleteConfirm);

        $('#confirmDeleteBtn').click(confirmDelete);

        // ----- * ----- * ----- * ----- * ----- * ----- * -----
        // ----- * ----- *      Add / Edit       * ----- * -----
        // ----- * ----- * ----- * ----- * ----- * ----- * -----

        function showFormModal(isToEdit) {
            $.ajax({
                url: formDataEndpoint,
                method: 'GET'
            })
            .done(function(formData) {
                // get data of selected row if isToEdit
                let selectedRow = null;
                if (isToEdit) {
                    const selectedRows = datatable.rows('.selected').data();
                    selectedRow = selectedRows.length > 0 ? selectedRows[0] : null;
                }

                // Generate form fields
                createForm(formData, selectedRow, isToEdit);

                // Show the modal
                alertsDiv.html('');
                $('#formModal').modal().show();
            });
        }

        function createForm(formData, selectedRow = null, isToEdit) {
            // Set the form label
            formLable.html((isToEdit ? 'Edit ' : 'Add ') + formData.formLable);

            // Create the html form fields
            let formFields = '';

            formData.fields.forEach(field => {
                if (field.type == 'text' || field.type == 'email') {
                    formFields += createTextField(field, selectedRow);
                } else if (!isToEdit && field.type == 'password') {
                    formFields += createTextField(field);
                } else if (field.type == 'select') {
                    formFields += createSelectField(field, selectedRow);
                } else if (field.type == 'radio') {
                    formFields += createRadioField(field, selectedRow);
                } else if (field.type == 'time') {
                    let timeValue = selectedRow ? selectedRow[field.valueKey] : '';
                    formFields += createDateTimeField(field, selectedRow, timeValue);
                } else if (field.type == 'date') {
                    let dateValue = selectedRow ? selectedRow[field.valueKey] : '';
                    if (dateValue) dateValue = new Date(dateValue).toISOString().split("T")[0];
                    formFields += createDateTimeField(field, selectedRow, dateValue);
                }
            });

            // set formFields html in the form
            formElem.html(formFields);
        }

        function createTextField(field, selectedRow = null) {
            let textValue = selectedRow ? selectedRow[field.valueKey] : '';
            return `<div class="form-group">
                    <label for="${field.name}_input" class="col-form-label">${field.label}</label>
                    <input type="${field.type}" name="${field.name}" value="${textValue}" class="form-control" id="${field.name}_input">
                </div>`;
        }

        function createSelectField(field, selectedRow) {
            let selectedOption = selectedRow ? selectedRow[field.compare] : '';
            return `<div class="form-group">
                    <label class="col-form-label">${field.label}</label>
                    <select name="${field.name}" class="form-control">
                        <option disabled>Select ${field.label}</option>
                        ${
                            field.options.map(option =>
                                `<option value="${option[field.valueKey]}" ${selectedOption == option[field.text] ? 'selected' : ''}>
                                    ${option[field.text]}
                                </option>`
                            ).join("")
                        }
                    </select>
                </div>`;
        }

        function createRadioField(field, selectedRow) {
            let radioValue = selectedRow ? selectedRow[field.valueKey] : '';
            return `<div class="form-group">
                    <label class="col-form-label">${field.label}</label>
                    ${
                        field.options.map(option =>
                            `<div class="form-check">
                                <input class="form-check-input" type="radio" ${option.value == radioValue ? 'checked' : ''}
                                    name="${field.name}" id="${option.value}_input" value="${option.value}">
                                <label class="form-check-label" for="${option.value}_input">${option.text}</label>
                            </div>`
                        ).join("")
                    }
                </div>`;
        }

        function createDateTimeField(field, selectedRow, value) {
            return `<div class="form-group">
                    <label for="${field.name}_input" class="col-form-label">${field.label}</label>
                    <input type="${field.type}" name="${field.name}" value="${value}" class="form-control" id="${field.name}_input">
                </div>`;
        }

        // ----- * ----- * ----- * -----

        function submitEdit() {
            let data = formElem.serialize();

            const itemId = datatable.rows('.selected').data()[0].id;

            $.ajax({
                url: updateEndpoint + `/${itemId}`,
                method: 'PATCH',
                data: data
            })
            .done(function(response) {
                handleEditSuccess(response);
            })
            .fail(function(response) {
                handleEditFail(response);
            });
        }

        function handleEditSuccess(response) {
            datatable.rows('.selected').data(response.updatedData).draw(false);
            datatable.rows('.selected').deselect();
            $('#formModal .close').click();
            showSuccessToast('Edit success', response.userMessage);
        }

        function handleEditFail(response) {
            let message = response.responseJSON.message;
            let errors = response.responseJSON.errors;
            let errorsAlerts = '<div class="alert alert-danger" role="alert">';
                errorsAlerts += `<p><strong>${message}</strong></p>`;
            for (const error in errors) {
                errorsAlerts += `<div>${errors[error]}</div>`;
            }
            errorsAlerts += '</div>';
            alertsDiv.html(errorsAlerts);
        }

        // ----- * ----- * ----- * -----

        function submitAdd() {
            let data = formElem.serialize();

            $.ajax({
                url: addEndpoint,
                method: 'POST',
                data: data
            })
            .done(function(response) {
                handleAddSuccess(response);
            })
            .fail(function(response) {
                handleAddFail(response);
            });
        }

        function handleAddSuccess(response) {

        }

        function handleAddFail(response) {

        }

        // ----- * ----- * ----- * ----- * ----- * ----- * -----
        // ----- * ----- *        Delete         * ----- * -----
        // ----- * ----- * ----- * ----- * ----- * ----- * -----

        function showDeleteConfirm() {
            let selectedData = datatable.rows('.selected').data();
            if (!selectedData.length) return;

            let rowData = '<p class="text-danger">Are you sure, data will be deleted</p>';
            let columns = datatable.settings().init().columns;
            datatable.columns().every(function(index) {
                let columnName = columns[index].name;
                if (columnName && columnName != 'DT_RowIndex') {
                    let headerText = datatable.column(index).header().textContent;
                    let data = selectedData[0][columnName];
                    rowData += `<div><b>${headerText}:</b> ${data}</div>`;
                }
            });
            confirmMessage.html(rowData);
            confirmModal.modal().show();
        }

        function confirmDelete() {
            itemId = datatable.rows('.selected').data()[0].id;
            if (itemId) {
                toggleControlPanel(false);
                $.ajax({
                    url: destroyEndpoint + `/${itemId}`,
                    method: 'DELETE'
                })
                .done(function(response) {
                    if (response.result == true) {
                        datatable.row('.selected').remove().draw(true);
                        $('#confirmModal .close').click();
                        showSuccessToast('Delete success', response.userMessage);
                    } else {
                        datatable.rows('.selected').deselect();
                        $('#confirmModal .close').click();
                        showErrorToast('Delete failed', response.userMessage);
                    }
                });
            }
        }

        // ----- * ----- * ----- * ----- * ----- * ----- * -----
        // ----- * ----- *       Controls        * ----- * -----
        // ----- * ----- * ----- * ----- * ----- * ----- * -----

        function toggleControlPanel(show) {
            show ? showControlPanel() : hideControlPanle();
        }

        function showControlPanel() {
            controlsPanel.show();
            updateEndpoint ? editButton.show() : editButton.hide();
            destroyEndpoint ? deleteButton.show() : deleteButton.hide();
        }

        function hideControlPanle() {
            controlsPanel.hide();
        }

        // ----- * ----- * ----- * -----

        function showSuccessToast(title, message) {
            $('.toast #toastTitle').html(title);
            $('.toast #toastMessage').attr('class', 'text-success');
            $('.toast #toastMessage').html(message);
            $('.toast').toast('show');
        }

        function showErrorToast(title, message) {
            $('.toast #toastTitle').html(title);
            $('.toast #toastMessage').attr('class', 'text-danger');
            $('.toast #toastMessage').html(message);
            $('.toast').toast('show');
        }
    });
</script>
@endsection
