import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin'
import inject from '@rollup/plugin-inject'
import fs from 'fs'
import path from 'path'

export default defineConfig({
    server: {
        https: {
            key: fs.readFileSync('{{ key }}'),
            cert: fs.readFileSync('{{ cert }}'),
        },
        cors: true,
        host: '{{ domain }}'
    },
    plugins: [
        inject({
            $: 'jquery',
        }),
        laravel({
            input: ['resources/scss/app.scss', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap'),
        }
    },
});
