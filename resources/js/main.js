try {
    window.$ = window.jQuery = require('jquery');
    window.Popper = require('admin-lte/plugins/popper/popper.min');

    require('admin-lte/plugins/bootstrap/js/bootstrap.bundle');

    require('admin-lte/plugins/datatables/jquery.dataTables.min');
    require('admin-lte/plugins/datatables-select/js/select.bootstrap4.min');
    require('admin-lte/plugins/datatables-buttons/js/dataTables.buttons');

    require('admin-lte/plugins/select2/js/select2.full.min');

    require("admin-lte/build/js/AdminLTE")
} catch (e) {}

window.addEventListener('DOMContentLoaded', (event) => {

    let toggleSwitch = document.querySelector('.theme-switch input[type="checkbox"]');
    let currentTheme = localStorage.getItem('theme');
    let mainHeader = document.querySelector('.main-header');

    if (currentTheme) {
        if (currentTheme === 'dark') {
            if (!document.body.classList.contains('dark-mode')) {
                document.body.classList.add("dark-mode");
            }
            if (mainHeader.classList.contains('navbar-light')) {
                mainHeader.classList.add('navbar-dark');
                mainHeader.classList.remove('navbar-light');
            }
            toggleSwitch.checked = true;
        }
    }

    function switchTheme(e) {
    if (e.target.checked) {
        if (!document.body.classList.contains('dark-mode')) {
            document.body.classList.add("dark-mode");
        }
        if (mainHeader.classList.contains('navbar-light')) {
            mainHeader.classList.add('navbar-dark');
            mainHeader.classList.remove('navbar-light');
        }
        localStorage.setItem('theme', 'dark');
    } else {
        if (document.body.classList.contains('dark-mode')) {
            document.body.classList.remove("dark-mode");
        }
        if (mainHeader.classList.contains('navbar-dark')) {
            mainHeader.classList.add('navbar-light');
            mainHeader.classList.remove('navbar-dark');
        }
        localStorage.setItem('theme', 'light');
    }
}

toggleSwitch.addEventListener('change', switchTheme, false);
});
