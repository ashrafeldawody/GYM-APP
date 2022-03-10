const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/main.js', 'public/js')
    .sass('resources/sass/main.scss', 'public/css')
    .copy('node_modules/admin-lte/dist/img', 'public/dist/img')
    .copy('node_modules/admin-lte/plugins/fontawesome-free/webfonts', 'public/webfonts')
