/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// import {
//     Datetime
// } from 'vue-datetime';

// Vue.component('datetime', Datetime);

import Calendar from 'v-calendar/lib/components/calendar.umd'
import DatePicker from 'v-calendar/lib/components/date-picker.umd'
import vSelect from 'vue-select'

// Register components in your 'main.js'
Vue.component('calendar', Calendar)
Vue.component('date-picker', DatePicker)


Vue.component('v-select', vSelect)
Vue.component('kasir-purchase-component', require('./components/kasir/KasirWorkComponent.vue').default);
Vue.component('kasir-payment-component', require('./components/kasir/PaymentKasirComponent.vue').default);
Vue.component('manager-transaction-edit-component', require('./components/manager/TransactionEditComponent.vue').default);
Vue.component('manager-transactions-component', require('./components/manager/TransactionsComponent.vue').default);
Vue.component('manager-products-create-component', require('./components/manager/ProductCreateComponent.vue').default);
Vue.component('kasir-reports-component', require('./components/kasir/ReportsComponent.vue').default);
Vue.component('manager-reports-payment-component', require('./components/manager/report/PaymentComponent.vue').default);
Vue.component('manager-center-payment-component', require('./components/manager_center/PaymentComponent.vue').default);
Vue.component('manager-center-transaction-edit-component', require('./components/manager_center/TransactionEditComponent.vue').default);
// Vue.component('kasir-refund-component', require('./components/kasir/RefundComponent.vue').default);

// Vue.component(
//     'passport-clients',
//     require('./components/passport/Clients.vue').default
// );

// Vue.component(
//     'passport-authorized-clients',
//     require('./components/passport/AuthorizedClients.vue').default
// );

// Vue.component(
//     'passport-personal-access-tokens',
//     require('./components/passport/PersonalAccessTokens.vue').default
// );
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
