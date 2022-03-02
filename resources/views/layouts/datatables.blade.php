@extends('layouts.dashboard')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">@yield('table_header')</div>
                <div class="card-body">
                    <div class="mb-3 p-3 border rounded bg-white sticky-top shadow">
                        <div class="d-flex">
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

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">New message</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Recipient:</label>
                        <input type="text" class="form-control" id="recipient-name">
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Message:</label>
                        <textarea class="form-control" id="message-text"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Update</button>
            </div>
        </div>
    </div>
</div>

@yield('table_script')
<script type="text/javascript">
    const controlsPanel = $('#controlsPanel');
    const editButton = $('#editButton');
    const deleteButton = $('#deleteButton');
    const userMessage = $('#userMessage');

    $(function () {
        let datatable = $('#datatable').DataTable({
            bAutoWidth: false,
            scrollX: true,
            responsive: true,
            processing: true,
            serverSide: true,
            pageLength: 5,
            ajax: @yield('table_route'),
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

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        });

        editButton.click(function () {
            console.log(datatable.rows('.selected').data());
            console.log(datatable.rows('.selected').data()[0]);
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
                    console.log(response);
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
            selectedCount > 1 ? editButton.hide() : editButton.show();
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
