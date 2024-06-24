import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                /*'resources/css/pages/crear.css',
                'resources/css/pages/citas.css',
                'resources/css/pages/editar.css',
                'resources/css/pages/listacitas.css',
                'resources/css/pages/login.css',
                'resources/css/pages/nav.css',
                'resources/css/pages/styles.css',
                'resources/css/pages/welcome.css',*/
                'resources/js/app.js',
                'resources/js/pages/citas.js',
                'resources/js/pages/editar_citas.js',
                'resources/js/pages/crear_doctores.js',
            ],
            refresh: true,
        }),
    ],
});
