let  mix = require('laravel-mix');
let SWPrecacheWebpackPlugin = require('sw-precache-webpack-plugin');

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

mix.babel([
		'node_modules/bulma/css/bulma.css',
		'node_modules/video.js/dist/video.css',
		'node_modules/cropperjs/dist/cropper.css',
		'node_modules/izitoast/dist/css/iziToast.css',
		'node_modules/slick-carousel/slick/slick.css',
		'node_modules/slick-carousel/slick/slick-theme.css'
		], 'public/css/all.css')
	.js('resources/assets/js/app.js', 'public/js')
	.sass('resources/assets/sass/app.scss', 'public/css')
	.options({
		processCssUrls: true,
	})
	.babel(['public/css/all.css', 'public/css/app.css'], 'public/css/main.css');

mix.webpackConfig( webpack => {
	return {
		plugins: [
			new SWPrecacheWebpackPlugin({
				cacheId: 'ubanji-v1.3',
				filename: 'service-worker.js',
				staticFileGlobs: ['public/**/*.{css,eot,svg,ttf,woff,woff2,js,html}'],
				minify: true,
				stripPrefix: 'public/',
				handleFetch: true,
				dynamicUrlToDependencies: {
				  '/': ['resources/views/welcome.blade.php'],
				},
				staticFileGlobsIgnorePatterns: [/\.map$/, /mix-manifest\.json$/, /manifest\.json$/, /service-worker\.js$/],
				runtimeCaching: [
				  {
				      urlPattern: /^https:\/\/fonts\.googleapis\.com\//,
				      handler: 'cacheFirst'
				  }
				],
				importScripts: ['./js/worker.js']
			})
		]
	}
} )