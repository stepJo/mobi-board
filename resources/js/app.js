require("./bootstrap");

import VueRouter from "vue-router";
import router from "./router";
import { ValidationProvider } from "vee-validate/dist/vee-validate.full.esm";
import { ValidationObserver } from "vee-validate";
import VModal from "vue-js-modal";
import Toasted from "vue-toasted";
import Vue from "vue";

window.Vue = require("vue");

Vue.use(VueRouter);
Vue.use(VModal);
Vue.use(Toasted, {
    iconPack: "fontawesome"
});
Vue.toasted.register(
    "successNotification",
    payload => {
        if (!payload.message) {
            return "Success";
        }
        return payload.message;
    },
    {
        icon: {
            name: "check-circle"
        },
        after: true,
        keepOnHover: true,
        duration: 2000,
        position: "top-right",
        type: "success",
        action: {
            text: "CLOSE",
            onClick: (e, toastObject) => {
                toastObject.goAway(0);
            }
        }
    }
);

Vue.component("ValidationProvider", ValidationProvider);
Vue.component("ValidationObserver", ValidationObserver);

Vue.config.productionTip = false;

Vue.component("SideBar", require("./components/layout/SideBar").default);
Vue.component("Navigation", require("./components/layout/Navigation").default);
Vue.component("Board", require("./components/task/Board").default);

const app = new Vue({
    router: new VueRouter(router)
}).$mount("#app");
