import axios from "axios";

export default {
    namespaced: true,

    state: {
        subCategories: [],
        subCategory: {}
    },
    getters: {
        getSubCategories: state => state.subCategories,

        getSubCategory: state => state.subCategory
    },
    mutations: {
        setSubCategories: (state, subCategories) => state.subCategories = subCategories,

        setSubCategory: (state, subCategory) => state.subCategory = subCategory
    },
    actions: {

        getSubCategories({commit}) {
            return new Promise((resolve, reject) => {
                axios({
                    method: 'GET',
                    url: '/api/subcategories',
                    headers: {
                        Accept: 'application/json'
                    }
                })
                .then(response => {
                    commit('setSubCategories', response.data.sub_categories);
                    resolve(response);
                })
                .catch(error => {
                    reject(error);
                });
            });
        },

        getSubCategory({commit}, id) {
            return new Promise((resolve, reject) => {
                axios({
                    method: 'GET',
                    url: '/api/subcategories/' + id,
                    headers: {
                        Accept: 'application/json'
                    }
                })
                .then(response => {
                    commit('setSubCategory', response.data.sub_category);
                    resolve(response);
                })
                .catch(error => {
                    reject(error);
                })
            });
        },

        addSubCategory({}, payload) {
            return new Promise((resolve, reject) => {
                axios({
                    method: 'POST',
                    url: '/api/subcategories',
                    data: payload,
                    headers: {
                        Accept: 'application/json'
                    }
                })
                .then(response => {
                    resolve(response);
                })
                .catch(error => {
                    reject(error);
                });
            });
        },

        updateSubCategory({}, payload) {
            return new Promise((resolve, reject) => {
                axios({
                    method: 'PUT',
                    url: '/api/subcategories/' + payload.id,
                    data: payload.data,
                    headers: {
                        Accept: 'application/json'
                    }
                })
                .then(response => {
                    resolve(response);
                })
                .catch(error => {
                    reject(error);
                });
            });
        }

    }

}
