/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from "axios";
import Lang from "lang.js";
import Inputmask from "inputmask";
import locales from "./locales";
import Swal from "sweetalert2";

// Inputmask().mask(document.querySelectorAll("input"));

axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

const lang = new Lang({
    messages: locales,
    locale,
    fallback: localeFallback,
});

window.lang = lang;

const t = (key, arg1 = 0, arg2 = {}) => {
    if (typeof arg1 === "object") return window.lang.get(key, arg1);
    else if (typeof arg1 === "number" && typeof arg2 === "object")
        return window.lang.choice(key, arg1, arg2);
    else return window.lang.get(key);
};

const element = (selector) => document.querySelector(selector);

const getData = async (url, params = {}) =>
    await axios({
        url,
        method: "get",
        params,
    });

const postData = async (url, data = {}) => {
    const csrf = element('meta[name="csrf-token"]');
    return await axios({
        url,
        method: "post",
        headers: { "X-CSRF-TOKEN": csrf.content },
        data,
    });
};

const putData = async (url, data = {}) => {
    const csrf = element('meta[name="csrf-token"]');
    return await axios({
        url,
        method: "post",
        headers: { "X-CSRF-TOKEN": csrf.content },
        data: {
            ...data,
            _method: "PUT",
        },
    });
};

const deleteData = async (url, data = {}) => {
    const csrf = element('meta[name="csrf-token"]');
    return await axios({
        url,
        method: "post",
        headers: { "X-CSRF-TOKEN": csrf.content },
        data: {
            ...data,
            _method: "DELETE",
        },
    });
};

window.t = t;
window.Swal = Swal;
window.axios = axios;
window.getData = getData;
window.postData = postData;
window.putData = putData;
window.deleteData = deleteData;
window.inputMask = Inputmask;

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// import Pusher from 'pusher-js';
// window.Pusher = Pusher;

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: import.meta.env.VITE_PUSHER_APP_KEY,
//     cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1',
//     wsHost: import.meta.env.VITE_PUSHER_HOST ? import.meta.env.VITE_PUSHER_HOST : `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher.com`,
//     wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
//     wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
//     forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
//     enabledTransports: ['ws', 'wss'],
// });
