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
    .react()
    mix.js('resources/js/bundle.js','public/js')
    .postCss('resources/css/main.css','public/css',[
        require('autoprefixer'),
    ])
    .postCss('resources/css/tailwind.css', 'public/css', [
        require('postcss-import'),
        require('tailwindcss'),
        require('autoprefixer'),
    ])
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/custom.scss','public/css')
    .sass('resources/sass/login.scss','public/css');
if (mix.inProduction()) {
    mix.version();
}