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
// Options
mix.options({
    processCssUrls: false,
    cssNano: false,
});

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
    .sourceMaps()
    .webpackConfig(require('./webpack.config'));

// Images
mix.copy('resources/images', 'public/images');

// Fonts
mix.copy(
    "node_modules/line-awesome/dist/line-awesome/fonts/**/*",
    "public/fonts"
);

if (mix.inProduction()) {
    mix.version();
}
