
require('./bootstrap');

import Vue from 'vue';
import vuetify from './plugins/vuetify';

import 'material-design-icons-iconfont/dist/material-design-icons.css';

import router from './router';
import store from './store';

Vue.use(vuetify);

// window.Vue = require('vue').default;

Vue.component('main-app', require('./components/MainApp.vue').default);

const app = new Vue({
    vuetify,
    router: router,
    store: store,
    el: '#app',
});
