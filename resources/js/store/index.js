import Vue from 'vue';
import Vuex from 'vuex';

import interfaces from './modules/interface';
import users from './modules/users';

Vue.use(Vuex);

const store = new Vuex.Store({

    modules: {
        interfaces,
        users,
    }

});

export default store;
