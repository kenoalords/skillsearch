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
	// .js('node_modules/jplayer/dist/jplayer/jquery.jplayer.min.js', 'public/js')
	.js('node_modules/medium-editor/dist/js/medium-editor.js', 'public/js')
	.js('node_modules/blazy/blazy.min.js', 'public/js')
	.js('node_modules/semantic-ui-css/semantic.min.js', 'public/js')
	.copy('node_modules/semantic-ui-css/semantic.min.css', 'public/css')
	.copy('node_modules/jplayer/dist/skin/pink.flag/css/jplayer.pink.flag.min.css', 'public/css')
	.js('resources/assets/js/app.js', 'public/js')
	.sass('node_modules/toastr/build/toastr.min.css', 'public/css')
	.sass('resources/assets/sass/app-new.scss', 'public/css');





