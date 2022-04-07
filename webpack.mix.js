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

mix.js('resources/js/app.js', 'public/js')
    .vue()
    .postCss('resources/css/app.css', 'public/css', [
        require('postcss-import'),
        require('tailwindcss/nesting'),
        require('postcss-nested'),
        require('tailwindcss'),
        require('postcss-custom-properties'),
        require('autoprefixer'),
    ])
    .postCss('resources/css/cms.css', 'public/css', [
        require('postcss-import'),
        require('tailwindcss/nesting'),
        require('postcss-nested'),
        require('tailwindcss'),
        require('postcss-custom-properties'),
        require('autoprefixer'),
    ])
    .webpackConfig(require('./webpack.config'));

mix.copy('resources/images', 'public/images');

if (mix.inProduction()) {
    mix.version();
}
