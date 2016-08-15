var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.styles([
        './public/semantic/container.css',
        './public/semantic/sidebar.css',
        './public/semantic/transition.css',
        './public/semantic/icon.css',
        './public/semantic/loader.css',
        './public/semantic/popup.css',
        './public/semantic/sticky.css',
        './public/Gbh/css/website.css'
    ], './public/Gbh/css/website.min.css');
});