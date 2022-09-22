const mix = require('laravel-mix');
const  fs = require('fs');
require('laravel-mix-blade-reload');

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .bladeReload()
    .sourceMaps();

// ALL PAGES SEPERATLY
fs.readdirSync('resources/assets/js/pages').filter(p => /\.js$/.test(p))
    .forEach(p => mix.js('resources/assets/js/pages/' + p, 'public/assets/js/pages'))

fs.readdirSync('resources/assets/sass/pages').filter(p => /\.scss$/.test(p))
    .forEach(p => mix.sass('resources/assets/sass/pages/' + p, 'public/assets/css/pages'))

if (!mix.inProduction()) {
    mix.webpackConfig({
        devServer: {
            https: {
                key: fs.readFileSync('{{ key }}'),
                cert: fs.readFileSync('{{ cert }}')
            }
        },
        output: {
            filename: '[name].js',
            publicPath: '/',
            globalObject: 'self'
        },
        module: {
            rules: [{
                test: /\.s[ac]ss$/i,
                use: ["sass-loader",],
            }],
        },
    }).options({
        hmrOptions: {
            host: '{{ domain }}',
            port: 8080
        }
    })
}