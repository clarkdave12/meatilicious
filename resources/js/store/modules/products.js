import axios from "axios";

export default {
    namespaced: true,
    state: {
        products: [],
        product: {}
    },
    getters: {
        getProducts: state => state.products,

        getProduct: state => state.product
    },
    mutations: {
        setProducts: (state, products) => state.products = products,

        setProduct: (state, product) => state.product = product
    },
    actions: {

        getProducts({commit}) {
            return new Promise((resolve, reject) => {
                axios({
                    method: 'GET',
                    url: '/api/products',
                    headers: {
                        Accept: 'application/json'
                    }
                })
                .then(response => {
                    commit('setProducts', response.data.products);
                    console.log(response.data.products);
                    resolve(response);
                })
                .catch(error => {
                    reject(error);
                });
            });
        },

        getProduct({commit}, payload) {
            return new Promise((resolve, reject) => {
                axios({
                    method: 'GET',
                    url: '/api/products/' + payload,
                    headers: {
                        Accept: 'application/json'
                    }
                })
                .then(response => {
                    commit('setProduct', response.data.product);
                    console.log(response.data.product);
                    resolve(response);
                })
                .catch(error => {
                    reject(error);
                });
            });
        },

        addProduct({}, payload) {
            return new Promise((resolve, reject) => {
                axios({
                    method: 'POST',
                    url: '/api/products',
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
                })
            });
        },

        updateProduct({}, payload) {
            return new Promise((resolve, reject) => {
                axios({
                    method: 'PUT',
                    url: '/api/products/' + payload.id,
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

        deleteProduct({}, payload) {
            return new Promise((resolve, reject) => {
                axios({
                    method: 'DELETE',
                    url: '/api/products/' + payload,
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

        removeImage({}, payload) {
            return new Promise((resolve, reject) => {
                axios({
                    method: 'DELETE',
                    url: '/api/remove_image',
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
        }

    }
}
