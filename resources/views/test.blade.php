@extends('layouts.dashboard')

@section('content')
{!! $dataTable->table() !!}
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    $(function () {
    var table = $('#cities-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('dashboard.cities.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            //{data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'manager_id', name: 'manager_id'},
            //{data: '', name: ''},
            // {
            //     data: 'action',
            //     name: 'action',
            //     orderable: true,
            //     searchable: true
            // },
        ]
    });
  });
</script>
