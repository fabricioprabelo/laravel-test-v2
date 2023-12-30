import "./bootstrap";
import "../css/app.css";

import NProgress from "nprogress";
import { createApp, h } from "vue";
import { createInertiaApp, router } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy/dist/vue.m";
import i18n from "./i18n";
import capitalize from "./capitalize";
import axios from "./axios";
import inputmask from "./inputmask";

const appName = import.meta.env.VITE_APP_NAME || "Laravel";

router.on("start", () => NProgress.start());
router.on("finish", (event) => {
    if (event.detail.visit.completed) {
        NProgress.done();
    } else if (event.detail.visit.interrupted) {
        NProgress.set(0);
    } else if (event.detail.visit.cancelled) {
        NProgress.done();
        NProgress.remove();
    }
});

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        ),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(i18n)
            .use(capitalize)
            .use(axios)
            .use(inputmask)
            .mount(el);
    },
    progress: {
        delay: 250,
        color: "#4B5563",
        includeCSS: true,
        showSpinner: false,
    },
});
