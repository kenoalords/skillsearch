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

mix.js('node_modules/video.js/dist/video.min.js', 'public/js')
	.js('node_modules/blazy/blazy.min.js', 'public/js')
	.js('node_modules/semantic-ui-css/semantic.min.js', 'public/js')
	.combine([
		'node_modules/semantic-ui-css/semantic.min.css',
		'node_modules/toastr/build/toastr.css',
		'node_modules/video.js/dist/video.css',
		'node_modules/cropperjs/dist/cropper.css',
		'node_modules/izitoast/dist/css/iziToast.css',
		'node_modules/slick-carousel/slick/slick.css',
		'node_modules/slick-carousel/slick/slick-theme.css'
		], 'public/css/all.css')
	.js('resources/assets/js/app.js', 'public/js')
	.sass('resources/assets/sass/app.scss', 'public/css')
	.version();




