import Inputmask from "inputmask";

export default {
    install: (app, options) => {
        app.config.globalProperties.$inputMask = (selector) =>
            Inputmask().mask(selector);
    },
};
