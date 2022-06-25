import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/inertia-vue3'
import { InertiaProgress } from '@inertiajs/progress'
import { Head, Link } from '@inertiajs/inertia-vue3'
import Layout from '@/Shared/Layout'

createInertiaApp({
    resolve: async name => {
        let page = (await import(`./Pages/${name}`)).default;

        page.layout ??= Layout;
        return page;
    },
    title: title => title ? `${title} - Ticketing System` : 'Ticketing System',
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .component('Link', Link)
            .component('Head', Head)
            .mount(el)
    },
})

InertiaProgress.init({
    delay: 250,
    color: 'red',
    includeCSS: true,
    showSpinner: true,
})
