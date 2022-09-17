const mix = require('laravel-mix');
const  fs = require('fs');

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');

// ALL PAGES SEPERATLY
fs.readdirSync('resources/assets/js/pages')
    .filter(p => /\.js$/.test(p))
    .forEach(p => mix.js('resources/assets/js/pages/' + p, 'public/assets/js/pages'))

fs.readdirSync('resources/assets/sass/pages')
    .filter(p => /\.scss$/.test(p))
    .forEach(p => mix.sass('resources/assets/sass/pages/' + p, 'public/assets/css/pages'))