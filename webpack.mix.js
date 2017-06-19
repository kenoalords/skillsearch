const { mix } = require('laravel-mix');

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

mix.js('node_modules/waypoints/lib/jquery.waypoints.min.js', 'public/js')
	.js('node_modules/wavesurfer.js/dist/wavesurfer.min.js', 'public/js')
	.js('node_modules/masonry-layout/dist/masonry.pkgd.min.js', 'public/js')
	.js('node_modules/video.js/dist/video.min.js', 'public/js')
	.js('node_modules/blazy/blazy.min.js', 'public/js')
	.js('node_modules/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js', 'public/js')
	.copy('node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css', 'public/css')
	.js('resources/assets/js/app.js', 'public/js')
	.sass('resources/assets/sass/app.scss', 'public/css');

