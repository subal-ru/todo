const mix = require('laravel-mix');

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

mix.js('resources/js/home.js', 'public/js/home.js')
.js('resources/js/root.js', 'public/js/root.js')
.js('resources/js/mypage.js', 'public/js/mypage.js')
.sass('resources/sass/home.scss', 'public/css/home.css')
.sass('resources/sass/root.scss', 'public/css/root.css')
.sass('resources/sass/mypage.scss', 'public/css/mypage.css')
.disableSuccessNotifications();