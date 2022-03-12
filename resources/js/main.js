try {
    window.$ = window.jQuery = require('jquery');
    window.Popper = require('admin-lte/plugins/popper/popper.min');

    require('admin-lte/plugins/bootstrap/js/bootstrap.bundle.min');

    require('admin-lte/plugins/datatables/jquery.dataTables.min');
    require('admin-lte/plugins/datatables-select/js/select.bootstrap4.min');
    require('admin-lte/plugins/datatables-buttons/js/dataTables.buttons.min');
    require('admin-lte/plugins/datatables-responsive/js/responsive.bootstrap4.min');

    require('admin-lte/plugins/select2/js/select2.full.min');
    require('admin-lte/plugins/bs-custom-file-input/bs-custom-file-input.min.js');
    require('admin-lte/plugins/chart.js/Chart.bundle.min');

    require('./charts');
    require('./darkMode');

    require("admin-lte/build/js/AdminLTE")

    require("./app.datatables.js")
} catch (e) {}

