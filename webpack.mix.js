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

mix.js('resources/js/app.js', 'public/js')
    .vue()
    .sass('resources/sass/app.scss', 'public/css')
    .css('resources/css/search.css','public/css')
    .css('resources/css/bandTemp.css','public/css')
    .css('resources/css/welcome.css','public/css')
    .css('resources/css/bandsPage.css','public/css')
    .css('resources/css/dashboard.css','public/css')
    .css('resources/css/verzoeken.css','public/css');


