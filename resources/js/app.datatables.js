$(function () {
    if (!window.useAppDatatablesScript || !ajaxUrl) return;

    window.nestedSelectOptions = {};
    window.updateNestedSelect = function(event, index, label, text, valueKey) {
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

    let isSelectable = addEndpoint != null || updateEndpoint != null || destroyEndpoint != null;

    const controlsPanel = $('#controlsPanel');
    const addButton = $('#addButton');
    const editButton = $('#editButton');
    const deleteButton = $('#deleteButton');
    const toggleBanButton = $('#toggleBanButton');
    const formElem = $('#addEditForm');
    const formLable = $('#formModalLabel');
    const formConfirmBtn = $('#formConfirmBtn');
    const alertsDiv = $('#alertsDiv');
    const confirmModal = $('#confirmModal');
    const confirmMessage = $('#confirmMessage');

    // ----- * ----- * ----- * -----

    formElem.on("submit", function (e) {
        e.preventDefault();
        formConfirmBtn.click();
    });

    if (!addEndpoint) addButton.hide();

    let datatable = $('#datatable').DataTable({
        scrollX: true,
        sScrollXInner: "100%",
        processing: true,
        responsive: true,
        serverSide: true,
        pageLength: 10,
        ajax: ajaxUrl,
        columns: [
            { "data": null, "defaultContent": "" },
            ...tableColumns
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
        order: [[2, 'asc']]
    });

    // Prevent error alerts
    $.fn.dataTable.ext.errMode = 'none';

    datatable.on('select deselect draw.dt', function (e, dt, type, indexes) {
        const selectedCount = datatable.rows('.selected').data().length;
        toggleControlPanel(selectedCount > 0);
    });
    datatable.on( 'responsive-resize', function ( e, datatable, columns ) {
        let count = columns.reduce( function (a,b) {
            return b === false ? a+1 : a;
        }, 0 );

        console.log( count +' column(s) are hidden' );
    } );
    // ----- * ----- * ----- * -----

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            "Access-Control-Allow-Origin": "*"
        }
    });

    addButton.click(function () {
        formConfirmBtn.off().click(submitAdd);
        formConfirmBtn.attr('class', 'btn btn-success');
        formConfirmBtn.html('Add');
        showFormModal(false);
    });

    editButton.click(function () {
        formConfirmBtn.off().click(submitEdit);
        formConfirmBtn.attr('class', 'btn btn-primary');
        formConfirmBtn.html('Update');
        showFormModal(true);
    });

    deleteButton.click(showDeleteConfirm);

    toggleBanButton.click(toggleBanManager);

    $('#confirmDeleteBtn').click(confirmDelete);

    // ----- * ----- * ----- * ----- * ----- * ----- * -----
    // ----- * ----- *      Add / Edit       * ----- * -----
    // ----- * ----- * ----- * ----- * ----- * ----- * -----

    function showFormModal(isToEdit) {
        $.ajax({
            url: formDataEndpoint,
            method: 'GET',
            crossDomain: true,
        })
            .done(function (formData) {
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
            if (field.editOnly === true && !isToEdit) return;
            if (field.addOnly === true && isToEdit) return;

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
                    if (found && found.length > 0) timeValue = found[0];
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
        $('.custom-file input').change(function (e) {
            e.target.files.length && $(this).next('.custom-file-label').html(e.target.files[0].name);
        });
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
                        ${field.options.map(option =>
            `<option value="${option[field.valueKey]}">${option[field.text]}</option>`
        ).join("")
            }
                    </select>
                </div>`;
    }

    function createNestedSelect(field) {
        let selects = field.levels.map((level, index) => {
            let nextLevelLabel = index < field.levels.length - 1 ? field.levels[index + 1].label : '';
            let nextLevelText = index < field.levels.length - 1 ? field.levels[index + 1].text : '';
            let nextLevelValueKey = index < field.levels.length - 1 ? field.levels[index + 1].valueKey : '';
            return `<div class="form-group">
                    <label class="col-form-label">${level.label}</label>
                    <select onchange="updateNestedSelect(event, '${index}', '${nextLevelLabel}', '${nextLevelText}', '${nextLevelValueKey}')"
                        id="level_${index}_select" name="${level.inputName || ''}${level.multiSelect ? '[]' : ''}"
                        class="${level.multiSelect ? 'select2' : 'form-control'}"
                        ${level.multiSelect ? 'multiple="multiple" data-placeholder="Select a ' + level.label + '" style="width: 100%;"' : ''}>
                        <option>Select ${level.label}</option>
                        ${index == 0 && field[level.key].map((option) =>
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
                    ${field.options.map(option =>
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
                        <input type="file" accept="image/*" name="${field.name}" class="custom-file-input" id="${field.name}_input">
                        <label class="custom-file-label" for="${field.name}_input">Choose file</label>
                    </div>
                </div>`;
    }

    // ----- * ----- * ----- * -----

    function submitEdit() {
        if (!$("#addEditForm input[name='_method']").length) {
            formElem.prepend('<input type="hidden" name="_method" value="PATCH">');
        }

        let data = formElem.serialize();

        const itemId = datatable.rows('.selected').data()[0].id;

        $.ajax({
            url: updateEndpoint + `/${itemId}`,
            method: 'POST',
            data: new FormData(formElem.get(0)),
            processData: false,
            contentType: false,
        })
            .done(function (response) {
                handleEditSuccess(response);
            })
            .fail(function (response) {
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
        $.ajax({
            url: addEndpoint,
            method: 'POST',
            data: new FormData(formElem.get(0)),
            processData: false,
            contentType: false,
        })
            .done(function (response) {
                handleAddSuccess(response);
            })
            .fail(function (response) {
                handleAddFail(response);
            });
    }

    function handleAddSuccess(response) {
        if (response.newRowData) {
            datatable.row.add(response.newRowData).draw(false);
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
        datatable.columns().every(function (index) {
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
                .done(function (response) {
                    handleDeleteSuccess(response);
                }).fail(function (response) {
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
    // ----- * ----- *      Toggle Ban       * ----- * -----
    // ----- * ----- * ----- * ----- * ----- * ----- * -----

    function toggleBanManager() {
        const itemId = datatable.rows('.selected').data()[0].id;

        $.ajax({
            url: toggleBanEndpoint + `/${itemId}`,
            method: 'PATCH'
        })
            .done(function (response) {
                handleToggleBanSuccess(response);
            })
            .fail(function (response) {
                handleToggleBanFail(response);
            });
    }

    function handleToggleBanSuccess(response) {
        if (response.result === true) {
            let selectedData = datatable.rows('.selected').data()[0];
            selectedData['is_banned'] = response.isBanned;
            updateToggleBanText(response.isBanned);
            showSuccessToast('Toggle ban success', response.userMessage);
        } else {
            datatable.rows('.selected').deselect();
            showErrorToast('Toggle ban failed', response.userMessage);
        }
    }

    function handleToggleBanFail() {
        datatable.rows('.selected').deselect();
        showErrorToast('Toggle ban failed', "Something wrong happened, Unknown error");
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
        if (toggleBanEndpoint) {
            toggleBanButton.show()
            let selectedData = datatable.rows('.selected').data()[0];
            if (selectedData) updateToggleBanText(selectedData['is_banned']);
        } else {
            toggleBanButton.hide();
        }
    }

    function hideControlPanle() {
        controlsPanel.hide();
    }

    // ----- * ----- * ----- * -----

    function updateToggleBanText(isBanned) {
        isBanned === true ? toggleBanButton.html('<i class="fas fa-user-check mr-2"></i>Unban') : toggleBanButton.html('<i class="fas fa-ban mr-2"></i>Ban');
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
        showToastMessage(title, message, 'text-success');
    }

    function showErrorToast(title, message) {
        showToastMessage(title, message, 'text-danger');
    }

    function showToastMessage(title, message, cssClass) {
        $('.toast #toastTitle').attr('class', cssClass);
        $('.toast #toastTitle').html(title);
        $('.toast #toastMessage').attr('class', cssClass);
        $('.toast #toastMessage').html(message);
        $('.toast').toast('show');
    }
});
