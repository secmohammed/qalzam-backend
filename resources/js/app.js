/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

window.Vue = require("vue").default;

Vue.component(
    "reservation-form",
    require("./components/ReservationProduct.vue").default
);
Vue.component("order-form", require("./components/OrderProduct.vue").default);
Vue.component(
    "template-products",
    require("./components/TemplateProducts.vue").default
);
Vue.component("discount", require("./components/Discount.vue").default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: "#app"
});
