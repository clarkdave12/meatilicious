import Vue from 'vue';
import Vuex from 'vuex';

import interfaces from './modules/interface';
import users from './modules/users';
import categories from './modules/categories';

Vue.use(Vuex);

const store = new Vuex.Store({

    modules: {
        interfaces,
        users,
        categories,
    }

});

export default store;
