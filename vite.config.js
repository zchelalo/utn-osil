import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // 'resources/sass/app.scss',

                'resources/css/app.css',
                "resources/css/congresos.css",
                "resources/css/form.css",
                "resources/css/talleres.css",

                'resources/js/index.jsx',

                'resources/js/app.js',
                "resources/js/congresos.js",
                "resources/js/form.js",

                "resources/js/librerias/swiper.js",
                // "resources/js/librerias/sweetalert2.js",
                "resources/js/librerias/bootstrap.js",
                "resources/js/librerias/popper.js",

                "resources/css/librerias/swiper.css",
                // "resources/css/librerias/sweetalert2.css",
                "resources/css/librerias/bootstrap.css"
            ],
            refresh: true,
        }),
        react(),
    ],
    server: {
        hmr: {
            host: 'localhost',
        },
    }
});
