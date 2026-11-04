import filamentVue from '@vitejs/plugin-vue'
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { bunny } from 'laravel-vite-plugin/fonts';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    build: {
        rolldownOptions: { preserveEntrySignatures: 'exports-only' },
    },
    plugins: [
        filamentVue(),
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/filament/forms/components/text-input.ts',
                'resources/js/filament/forms/components/select.ts',
                'resources/js/filament/forms/components/textarea.ts',
                'resources/js/filament/forms/components/date-picker.ts',
                'resources/js/filament/forms/components/toggle-buttons.ts',
                'resources/js/filament/forms/components/date-time-picker.ts',
                'resources/js/filament/forms/components/checkbox.ts',
                'resources/js/filament/schemas/components/js-form.ts',
                'resources/js/filament/infolists/components/js-infolist.ts',
            ],
            refresh: true,
            fonts: [
                bunny('Instrument Sans', {
                    weights: [400, 500, 600],
                }),
            ],
        }),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
