require("./bootstrap");

import Vue from "vue";
import VueRouter from "vue-router";
import router from "./router";
import { ValidationProvider } from "vee-validate/dist/vee-validate.full.esm";
import { ValidationObserver } from "vee-validate";
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
import Toasted from "vue-toasted";
import VModal from "vue-js-modal";

window.Vue = require("vue");

//Router
Vue.use(VueRouter);

//Global Component
Vue.component("login-form", require("./components/auth/LoginForm").default);
Vue.component("side-bar", require("./components/layout/SideBar").default);
Vue.component("navigation", require("./components/layout/Navigation").default);
Vue.component("board", require("./components/task/Board").default);

//Global Mixin
Vue.mixin({
    methods: {
        showModal(name) {
            this.$modal.show(name);
        },
        closeModal(name) {
            this.$modal.hide(name);
        }
    }
});

//Loading Overlay
Vue.component('loading', Loading)

//Toasted
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
Vue.toasted.register(
    "failNotification",
    payload => {
        if (!payload.message) {
            return "Fail";
        }
        return payload.message;
    },
    {
        icon: {
            name: "fa-times"
        },
        after: true,
        keepOnHover: true,
        duration: 2000,
        position: "top-right",
        type: "error",
        action: {
            text: "CLOSE",
            onClick: (e, toastObject) => {
                toastObject.goAway(0);
            }
        }
    }
)

//Vee Validate
Vue.component("ValidationProvider", ValidationProvider);
Vue.component("ValidationObserver", ValidationObserver);

//VModal
Vue.use(VModal);

Vue.config.productionTip = false;

const app = new Vue({
    router: new VueRouter(router),
}).$mount("#app");
