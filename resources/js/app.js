require("./bootstrap");

import VueRouter from "vue-router";
import router from "./router";
import { ValidationProvider, ValidationObserver, extend } from "vee-validate";

window.Vue = require("vue");

Vue.use(VueRouter);

Vue.use(VeeValidate);

Vue.component("ValidationProvider", ValidationProvider);
Vue.component("ValidationObserver", ValidationObserver);

Vue.config.productionTip = false;

Vue.component("SideBar", require("./components/layout/SideBar").default);
Vue.component("Navigation", require("./components/layout/Navigation").default);
Vue.component("Board", require("./components/task/Board").default);

const app = new Vue({
    router: new VueRouter(router)
}).$mount("#app");
