const mix = require('laravel-mix');
const  fs = require('fs');

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');


// ALL PAGES SEPERATLY
fs.readdirSync('resources/js/pages')
    .filter(p => /\.js$/.test(p))
    .forEach(p => mix.js('resources/js/pages/' + p, 'public/js/pages'))

fs.readdirSync('resources/sass/pages')
    .filter(p => /\.scss$/.test(p))
    .forEach(p => mix.sass('resources/sass/pages/' + p, 'public/css/pages'))