import { createInertiaApp } from '@inertiajs/vue3';
import { createNotivue } from 'notivue';
import { createApp, h } from 'vue';
import { ZiggyVue } from 'ziggy-js';
import 'notivue/notification.css';
import 'notivue/animations.css';

import Default from '@/layouts/default.vue';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';
const notivue = createNotivue({
    position: 'top-right',
    limit: 5,
});

createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : appName),
    layout: () => Default,
    progress: {
        color: '#4575AF',
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(notivue)
            .mount(el!);
    },
});
