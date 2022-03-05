try {
    window.$ = window.jQuery = require('jquery');
    window.Popper = require('admin-lte/plugins/popper/popper.min');

    require('admin-lte/plugins/datatables/jquery.dataTables.min');
    require('admin-lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min');
    require('admin-lte/plugins/datatables-select/js/select.bootstrap4.min');
    require('admin-lte/plugins/bootstrap/js/bootstrap');

    require('admin-lte/plugins/select2/js/select2.full.min');

    require("admin-lte/build/js/AdminLTE")
} catch (e) {}

