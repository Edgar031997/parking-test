/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;
import store from './store';

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('clients-component', require('./components/ClientsComponent.vue').default);
Vue.component('client-component', require('./components/ClientComponent.vue').default);
Vue.component('parking-places-component', require('./components/ParkingPlacesComponent.vue').default);
Vue.component('parking-component', require('./components/ParkingPlaceComponent.vue').default);
Vue.component('pick-up-component', require('./components/PickUpParkingComponent.vue').default);
Vue.component('report-component', require('./components/ReportComponent.vue').default);
Vue.component('pagination', require('laravel-vue-pagination'));
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    store,
    el: '#app',
});
