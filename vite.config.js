import { defineConfig } from 'vite';

import vue from '@vitejs/plugin-vue'
import { quasar, transformAssetUrls } from '@quasar/vite-plugin'

export default defineConfig({
    build: {
        // output dir for production build
        outDir: './dist',
        emptyOutDir: true,

        // emit manifest so PHP can find the hashed files
        manifest: true,

        // our entry
        rollupOptions: {
            input: './assets/js/app.js'
        }
    },

    plugins: [
        vue({
            template: { transformAssetUrls }
        }),

        quasar({
            sassVariables: 'assets/css/variables.scss',
        }),
    ],
});
