import Lang from "lang.js";

const lang = new Lang({
    messages,
    locale,
    fallback,
});

export default {
    install: (app, options) => {
        app.config.globalProperties.$t = (key, arg1 = 0, arg2 = {}) => {
            if (typeof arg1 === "object") return lang.get(key, arg1);
            else if (typeof arg1 === "number" && typeof arg2 === "object")
                return lang.choice(key, arg1, arg2);
            else return lang.get(key);
        };
    },
};
