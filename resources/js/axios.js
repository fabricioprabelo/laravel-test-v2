import axios from "axios";

axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

export default {
    install: (app, options) => {
        app.config.globalProperties.$axios = (config = {}) => axios(config);
    },
};
