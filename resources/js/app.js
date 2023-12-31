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
import { OhVueIcon, addIcons } from "oh-vue-icons";
import {
    HiLightningBolt,
    HiTrash,
    HiPencilAlt,
    CoSave,
} from "oh-vue-icons/icons";
import Vue3Toastify, { toast } from "vue3-toastify";

const appName = import.meta.env.VITE_APP_NAME || "Laravel";

addIcons(HiLightningBolt, HiTrash, HiPencilAlt, CoSave);

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
            .component("VIcon", OhVueIcon)
            .use(Vue3Toastify, {
                autoClose: 3000,
                newestOnTop: true,
                pauseOnHover: true,
                limit: 3,
                position: toast.POSITION.TOP_RIGHT,
            })
            .mount(el);
    },
    progress: {
        delay: 250,
        color: "#4B5563",
        includeCSS: true,
        showSpinner: false,
    },
});
