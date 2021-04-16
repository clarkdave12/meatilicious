import axios from 'axios';

export default {

    namespaced: true,

    state: {
        categories: [],
        category: {}
    },

    getters: {
        getCategories: state => state.categories,

        getCategory: state => state.category
    },

    mutations: {
        setCategories: (state, categories) => state.categories = categories,

        setCategory: (state, category) => state.category = category,
    },

    actions: {
        getCategories({commit}) {
            return new Promise((resolve, reject) => {
                axios({
                    method: 'GET',
                    url: '/api/categories',
                    headers: {
                        Accept: 'application/json'
                    }
                })
                .then(response => {
                    commit('setCategories', response.data.categories);
                    resolve(response);
                })
                .catch(error => {
                    reject(error);
                });
            });
        },

        getCategory({commit}, id) {
            return new Promise((resolve, reject) => {
                axios({
                    method: 'GET',
                    url: '/api/categories/' + id,
                    headers: {
                        Accept: 'application/json'
                    }
                })
                .then(response => {
                    commit('setCategory', response.data.category);
                    resolve(response);
                })
                .catch(error => {
                    reject(error);
                })
            });
        },

        addCategory({}, payload) {
            return new Promise((resolve, reject) => {
                axios({
                    method: 'POST',
                    url: '/api/categories',
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

        updateCategory({}, payload) {
            return new Promise((resolve, reject) => {
                axios({
                    method: 'PUT',
                    url: '/api/categories/' + payload.id,
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
                })
            });
        },

        deleteCategory({}, payload) {
            return new Promise((resolve, reject) => {
                axios({
                    method: 'DELETE',
                    url: '/api/categories/' + payload,
                    headers: {
                        Accept: 'application/json'
                    }
                })
                .then(response => {
                    resolve(response);
                })
                .catch(error => {
                    console.log(error.response);
                })
            });
        }
    }

}
