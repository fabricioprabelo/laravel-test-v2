export default {
    install: (app, options) => {
        app.config.globalProperties.$capitalize = (str) =>
            str.toLowerCase().replace(/^\w/, (c) => c.toUpperCase());
    },
};
