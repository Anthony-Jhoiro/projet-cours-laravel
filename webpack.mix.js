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
    .copy('node_modules/simplemde/dist/simplemde.min.js', 'public/js/ressources/simplemde.min.js')
    .copy('node_modules/simplemde/dist/simplemde.min.css', 'public/css/ressources/simplemde.min.css')
    .js('node_modules/bootstrap/dist/js/bootstrap.min.js', 'public/js/ressources')
    .js('node_modules/jquery/dist/jquery.min.js', 'public/js/ressources')
    .js('node_modules/popper.js/dist/popper.min.js', 'public/js/ressources/').sourceMaps();


mix.copy('resources/js/pages/recetteEdit.js', 'public/js/pages/recetteEdit.js');
mix.copy('resources/js/pages/home.js', 'public/js/pages/home.js');
mix.copy('resources/js/pages/profile.js', 'public/js/pages/profile.js');
mix.copy('resources/js/pages/home.js', 'public/js/pages/home.js');
mix.copy('resources/js/pages/nav-bar.js', 'public/js/pages/nav-bar.js');
