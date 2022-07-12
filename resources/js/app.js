import './bootstrap';

import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import { Link } from "@inertiajs/inertia-vue3";
import layout from "./components/layout.vue";
import defaultLayout from "./components/defaultLayout.vue";


const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => {
        const page = resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        );
        page.then((module) => {

            if ( module.default.components && module.default.components.layout ) {
                module.default.layout = module.default.components.layout;
            } else {
                module.default.layout = layout;
            }

            if ( name == 'Auth/Login'){
                module.default.layout = defaultLayout
            }
        });
        return page;
    },
    setup({el, app, props, plugin}) {
        return createApp({render: () => h(app, props)})
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .mixin({
                components: {
                    Link
                }
            })
            .mount(el);
    },
}).then(() => {

});

InertiaProgress.init({color: '#4B5563'});

// resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue'))