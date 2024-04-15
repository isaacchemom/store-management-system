import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import Vue from '@vitejs/plugin-vue';
import path from 'path';

export default defineConfig({
    plugins: [
        Vue(),
        laravel({
            input: ['resources/css/app.css', 'resources/js/app1.js'],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap'),
            '$':  'jQuery',
        }
    },


    
});
