
require('./bootstrap');

import Vue from 'vue';
import vuetify from './plugins/vuetify';

import router from './router';

Vue.use(vuetify);

// window.Vue = require('vue').default;

Vue.component('main-app', require('./components/MainApp.vue').default);

const app = new Vue({
    vuetify,
    router: router,
    el: '#app',
});
