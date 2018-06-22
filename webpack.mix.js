let mix = require('laravel-mix');

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
// Process CMS
mix.sass('resources/assets/sass/cms/app.sass', 'public/css/cms.css')
   .js(['resources/assets/js/cms/app.js',
        'resources/assets/js/cms/location.js',
    ], 'public/js/cms.js')
   .sourceMaps()
   .version();



// Process Frontend
mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css')
   .sourceMaps()
   .version();

mix.copyDirectory('resources/assets/images', 'public/images');