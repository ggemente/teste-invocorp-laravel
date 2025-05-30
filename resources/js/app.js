import './bootstrap';

import { createApp, h } from 'vue';
import { createInertiaApp, Link, Head } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';

import '../css/app.css';

createInertiaApp({
    title: title => title ? `${title} - ${import.meta.env.VITE_APP_NAME || 'Laravel'}` : import.meta.env.VITE_APP_NAME || 'Laravel',
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) });
        app.use(plugin);
        app.component('Link', Link);
        app.component('Head', Head);

        if (typeof window.route === 'function') {
            app.config.globalProperties.route = window.route;
        } else {
            console.warn("Ziggy's route function not found. Ensure @routes is in your Blade layout and Ziggy is configured.");
        }

        app.mount(el);
    },
    progress: {
        color: '#29d',
        showSpinner: true,
    },
});