import Vue from 'vue';
import Vuex from 'vuex';

import interfaces from './modules/interface';
import users from './modules/users';
import categories from './modules/categories';
import subCategories from './modules/subCategories';
import units from './modules/units';
import products from './modules/products';

Vue.use(Vuex);

const store = new Vuex.Store({

    modules: {
        interfaces,
        users,
        categories,
        subCategories,
        units,
        products
    }

});

export default store;
