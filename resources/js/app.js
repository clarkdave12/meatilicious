
require('./bootstrap');

import Vue from 'vue';
import vuetify from './plugins/vuetify';
import VueSweetalert2 from 'vue-sweetalert2';

import 'material-design-icons-iconfont/dist/material-design-icons.css';
import 'sweetalert2/dist/sweetalert2.min.css';

import router from './router';
import store from './store';

Vue.use(vuetify);
Vue.use(VueSweetalert2);

// window.Vue = require('vue').default;

Vue.component('main-app', require('./components/MainApp.vue').default);

const app = new Vue({
    vuetify,
    router: router,
    store: store,
    el: '#app',
});
