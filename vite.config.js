import laravel from "laravel-vite-plugin";

const { defineConfig } = require('vite');
const vue = require('@vitejs/plugin-vue');
const path = require('path');
const sass = require('sass');

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
        vue(),
        {
            name: 'sass',
            //@ts-ignore
            renderChunk: (code, chunk) => {
                if (chunk.fileName.endsWith('.css')) {
                    return sass
                        .renderSync({ data: code })
                        .css.toString()
                        .replace(/\/\*[\s\S]*?\*\//g, '');
                }
            },
        },
    ],
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources/js'),
        },
    },
});
