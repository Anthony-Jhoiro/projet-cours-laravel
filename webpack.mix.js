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

mix .js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .copy('node_modules/simplemde/dist/simplemde.min.js', 'public/js/ressources/simplemde.min.js')
    .copy('node_modules/simplemde/dist/simplemde.min.css', 'public/css/simplemde.min.css')
    .js('node_modules/bootstrap/dist/js/bootstrap.min.js', 'public/js/ressources/bootstrap.min.js')
    .js('node_modules/jquery/dist/jquery.min.js', 'public/js/ressources/jquery.min.js')
    .js('node_modules/popper.js/dist/popper.min.js', 'public/js/ressources/popper.min.js');
