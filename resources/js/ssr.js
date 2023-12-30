import NProgress from "nprogress";
import { createSSRApp, h } from "vue";
import { renderToString } from "@vue/server-renderer";
import { createInertiaApp, router } from "@inertiajs/vue3";
import createServer from "@inertiajs/vue3/server";
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

createServer((page) =>
    createInertiaApp({
        page,
        render: renderToString,
        title: (title) => `${title} - ${appName}`,
        resolve: (name) =>
            resolvePageComponent(
                `./Pages/${name}.vue`,
                import.meta.glob("./Pages/**/*.vue")
            ),
        setup({ App, props, plugin }) {
            return createSSRApp({ render: () => h(App, props) })
                .use(plugin)
                .use(ZiggyVue, {
                    ...page.props.ziggy,
                    location: new URL(page.props.ziggy.location),
                })
                .use(i18n)
                .use(capitalize)
                .use(axios)
                .use(inputmask);
        },
        progress: {
            delay: 250,
            color: "#4B5563",
            includeCSS: true,
            showSpinner: false,
        },
    })
);
