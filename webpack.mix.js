const mix = require('laravel-mix');

// Plugins
require('laravel-mix-tailwind')

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/scss/bootstrap.scss', 'public/css')
    .sass('resources/scss/tailwind.scss', 'public/css')
    .tailwind('./tailwind.config.js')
    .sass('resources/scss/app.scss', 'public/css')
    // .copyDirectory("node_modules/chart.js/dist", "public/vendor/chart.js")
    // .copyDirectory("node_modules/jquery/dist", "public/vendor/jquery")
    // .copyDirectory("node_modules/datatables.net/js", "public/vendor/datatables/js")
    // .copyDirectory("node_modules/datatables.net-dt/css", "public/vendor/datatables/css")
    // .copyDirectory("node_modules/datatables.net-dt/images", "public/vendor/datatables/images")
    // .copyDirectory("node_modules/datatables.net-bs4/css", "public/vendor/datatables/css")
    // .copyDirectory("node_modules/datatables.net-bs4/js", "public/vendor/datatables/js")
    // .copyDirectory("node_modules/datatables.net-bs4/js", "public/vendor/datatables/js")
    // .copyDirectory("node_modules/pikaday", "public/vendor/pikaday")
    // .js("node_modules/moment/moment.js", "public/vendor/moment")
    .copyDirectory("node_modules/choices.js/public/assets", "public/vendor/choices.js")
