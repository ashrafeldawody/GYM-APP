@extends('layouts.dashboard')

@section('content')

<div class="container">
    @yield('page-start')
    <div class="row justify-content-center">
        <div class="col-md-12 mb-5">
            <div class="card">
                <div class="card-header bg-light"
                    style="position: -webkit-sticky; position: sticky; top: 0; z-index: 1020;">
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

<script>
    const ajaxUrl = @yield('table_route', 'null');
    const formDataEndpoint = @yield('form_data_endpoint', 'null');
    const addEndpoint = @yield('add_endpoint', 'null');
    const updateEndpoint = @yield('update_endpoint', 'null');
    const destroyEndpoint = @yield('destroy_endpoint', 'null');

    const tableColumns = [@yield('table_columns')];
</script>

<script type="text/javascript">
    let nestedSelectOptions = {};

    function updateNestedSelect(event, index, label, text, valueKey) {
        index = +index;
        let nextIndex = index + 1;
        let targerSelect = document.getElementById(`level_${nextIndex}_select`);

        if (!targerSelect || !text) return;

        let targetSelect = event.target;
        let data = nestedSelectOptions[index + "." + targetSelect.value];

        targerSelect.innerHTML = `<option>Select ${label}</option>`;
        targerSelect.innerHTML += data.map((option) =>
            `<option value="${option[valueKey] || option[text]}">${option[text]}</option>`
        ).join("");

        while (document.getElementById(`level_${++nextIndex}_select`)) {
            let nextLevelSelect = document.getElementById(`level_${nextIndex}_select`);
            nextLevelSelect.innerHTML = `<option>Select from above first</option>`;
        }
    }

    $(function () {
        const ajaxUrl = @yield('table_route', 'null');
        const formDataEndpoint = @yield('form_data_endpoint', 'null');
        const addEndpoint = @yield('add_endpoint', 'null');
        const updateEndpoint = @yield('update_endpoint', 'null');
        const destroyEndpoint = @yield('destroy_endpoint', 'null');

        if (!ajaxUrl) return;

        let isSelectable = addEndpoint != null || updateEndpoint != null || destroyEndpoint != null;

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
            scrollX: true,
            sScrollXInner: "100%",
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
            order: [[ 2, 'asc' ]]
        });

        // Prevent error alerts
        $.fn.dataTable.ext.errMode = 'none';

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
            let loadNestedSelect = null;

            formData.fields.forEach(field => {
                if (field.type === 'text' || field.type === 'email' || field.type === 'number') {
                    formFields += createTextField(field, selectedRow);
                } else if (!isToEdit && field.type === 'password') {
                    formFields += createTextField(field);
                } else if (field.type === 'select') {
                    formFields += createSelectField(field, selectedRow);
                } else if (field.type === 'nestedSelect') {
                    separateSelectLevel(field);
                    formFields += createNestedSelect(field);
                    loadNestedSelect = field;
                } else if (field.type === 'radio') {
                    formFields += createRadioField(field, selectedRow);
                } else if (field.type === 'time') {
                    let timeValue = selectedRow ? selectedRow[field.valueKey] : '';
                    if (timeValue) {
                        const found = timeValue.match(/\d\d:\d\d:\d\d/g);
                        if (found && found.length > 0) timeValue =found[0];
                    }
                    formFields += createDateTimeField(field, selectedRow, timeValue);
                } else if (field.type === 'date') {
                    let dateValue = selectedRow ? selectedRow[field.valueKey] : '';
                    if (dateValue) dateValue = new Date(dateValue).toISOString().split("T")[0];
                    formFields += createDateTimeField(field, selectedRow, dateValue);
                } else if (field.type === 'file') {
                    formFields += createFileField(field);
                }
            });

            // set formFields html in the form
            formElem.html(formFields);

            $('.select2').select2();
            $('.custom-file-input').init();
        }

        function createTextField(field, selectedRow = null) {
            let textValue = selectedRow ? selectedRow[field.valueKey] : '';
            return `<div class="form-group">
                    <label for="${field.name}_input" class="col-form-label">${field.label}</label>
                    <input type="${field.type}" name="${field.name}" value="${textValue}" class="form-control" id="${field.name}_input">
                </div>`;
        }

        // needs:
        // field {label, name, text, valueKey, selectedText, selectedValue, multiSelect}
        function createSelectField(field, selectedRow) {
            let currentSelected = '';
            if (selectedRow) {
                let selectedText = selectedRow[field.selectedText];
                let selectedId = selectedRow[field.selectedValue];
                if (selectedText && selectedId) {
                    currentSelected = `<option value="${selectedId}" 'selected'>${selectedText}</option>`;
                }
            }
            return `<div class="form-group">
                    <label class="col-form-label">${field.label}</label>
                    <select name="${field.name}${field.multiSelect ? '[]' : ''}" class="${field.multiSelect ? 'select2' : 'form-control'}"
                            ${field.multiSelect ? 'multiple="multiple" data-placeholder="Select a ' + field.label + '" style="width: 100%;"' : ''}>
                        <option disabled>Select ${field.label}</option>
                        ${currentSelected}
                        ${
                            field.options.map(option =>
                                `<option value="${option[field.valueKey]}">${option[field.text]}</option>`
                            ).join("")
                        }
                    </select>
                </div>`;
        }

        function createNestedSelect(field) {
            let selects = field.levels.map((level, index) => {
                let nextLevelLabel = index < field.levels.length - 1 ? field.levels[index+1].label : '';
                let nextLevelText = index < field.levels.length - 1 ? field.levels[index+1].text : '';
                let nextLevelValueKey = index < field.levels.length - 1 ? field.levels[index+1].valueKey : '';
                return `<div class="form-group">
                    <label class="col-form-label">${level.label}</label>
                    <select onchange="updateNestedSelect(event, '${index}', '${nextLevelLabel}', '${nextLevelText}', '${nextLevelValueKey}')"
                        id="level_${index}_select" name="${level.inputName || ''}${level.multiSelect ? '[]' : ''}"
                        class="${level.multiSelect ? 'select2' : 'form-control'}"
                        ${level.multiSelect ? 'multiple="multiple" data-placeholder="Select a ' + level.label + '" style="width: 100%;"' : ''}>
                        <option>Select ${level.label}</option>
                        ${
                            index == 0 && field[level.key].map((option) =>
                                `<option>${option[level.text]}</option>`
                            ).join('')
                        }
                    </select>
                </div>`;
            }).join('');
            return selects;
        }

        function separateSelectLevel(field, levelIndex = 0) {
            if (field.levels) {
                let level = field.levels[0];
                let levelOptions = field[level.key];
                levelOptions.forEach((option, index) => {
                    let dataKey = null;
                    if (field.levels.length > 1) { // Not the last level
                        dataKey = option[level.text];
                        let nextLevelKey = field.levels[1]['key'];
                        let nestedOptions = option[nextLevelKey];
                        nestedSelectOptions[levelIndex + "." + dataKey] = nestedOptions;

                        let nextLevels = field.levels.filter((_, index) => index > 0);
                        if (nextLevels.length) {
                            separateSelectLevel({
                                [nextLevels[0].key]: nestedOptions,
                                levels: nextLevels
                            }, levelIndex + 1);
                        }
                    }
                });
            }
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

        function createFileField(field) {
            return `<div class="form-group">
                    <label class="col-form-label">${field.label}</label>
                    <div class="custom-file">
                        <input type="file" name="${field.name}" class="custom-file-input" id="${field.name}_input">
                        <label class="custom-file-label" for="${field.name}_input">Choose file</label>
                    </div>
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
            if (response.result === true) {
                datatable.rows('.selected').data(response.updatedData).draw(false);
                datatable.rows('.selected').deselect();
                $('#formModal .close').click();
                showSuccessToast('Edit success', response.userMessage);
            } else {
                $('#confirmModal .close').click();
                showErrorToast('Delete failed', response.userMessage);
            }
        }

        function handleEditFail(response) {
            if (response && response.responseJSON) {
                showErrorsList(response.responseJSON);
            }
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
            console.log('response', response);
            if (response.newRowData) {
                datatable.row.add(response.newRowData).draw(false);
                datatable.page('last').draw('page');
                $('#formModal .close').click();
                showSuccessToast('Add success', response.userMessage);
            } else {
                $('#formModal .close').click();
                showSuccessToast('Add success',
                    "Add success but somthing wrong happened! please refresh the page");
            }
        }

        function handleAddFail(response) {
            if (response && response.responseJSON) {
                showErrorsList(response.responseJSON);
            }
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
                    handleDeleteSuccess(response);
                }).fail(function(response) {
                    handleDeleteFail(response);
                });
            }
        }

        function handleDeleteSuccess(response) {
            if (response.result === true) {
                datatable.row('.selected').remove().draw(true);
                $('#confirmModal .close').click();
                showSuccessToast('Delete success', response.userMessage);
            } else {
                datatable.rows('.selected').deselect();
                $('#confirmModal .close').click();
                showErrorToast('Delete failed', response.userMessage);
            }
        }

        function handleDeleteFail() {
            datatable.rows('.selected').deselect();
            $('#confirmModal .close').click();
            showErrorToast('Delete failed', "Something wrong happened, Unknown error");
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

        function showErrorsList(responseJSON) {
            if (responseJSON) {
                let message = responseJSON.message;
                let errors = responseJSON.errors;
                let errorsAlerts = '<div class="alert alert-danger" role="alert">';
                    errorsAlerts += `<p><strong>${message}</strong></p>`;
                for (const error in errors) {
                    errorsAlerts += `<div>${errors[error]}</div>`;
                }
                errorsAlerts += '</div>';
                alertsDiv.html(errorsAlerts);
            }
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
            $('.toast #toastTitle').attr('class', 'text-danger');
            $('.toast #toastMessage').html(message);
            $('.toast #toastMessage').attr('class', 'text-danger');
            $('.toast').toast('show');
        }
    });
</script>
@endsection
