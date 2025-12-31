import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/product.css',
                'resources/js/app.js',
                'resources/js/product/show.js',
                'resources/js/product/index.js',
                'resources/js/product-detail.js',

            ],
            refresh: true,
        }),
    ],
});
