export default {
    install: (app, options) => {
        app.config.globalProperties.$t = (key, arg1 = 0, arg2 = {}) => {
            if (typeof arg1 === "object") return window.lang.get(key, arg1);
            else if (typeof arg1 === "number" && typeof arg2 === "object")
                return window.lang.choice(key, arg1, arg2);
            else return window.lang.get(key);
        };
    },
};
