import axios from "axios";

export default {

    namespaced: true,

    state: {
        variants: [],
        variant: {},
    },

    getters: {
        getVariants: state => state.variants,

        getVariant: state => state.variant,
    },

    mutations: {
        setVariants: (state, variants) => state.variants = variants,

        setVariant: (state, variant) => state.variant = variant,
    },

    actions: {
        getVariants({commit}) {
            return new Promise((resolve, reject) => {
                axios({
                    method: 'GET',
                    url: '/api/variants',
                    headers: {
                        Accept: 'application/json'
                    }
                })
                .then(response => {
                    commit('setVariants', response.data.variants);
                    resolve(response);
                })
                .catch(error => {
                    reject(error);
                })
            });
        },

        getVariant({commit}, payload) {
            return new Promise((resolve, reject) => {
                axios({
                    method: 'GET',
                    url: '/api/variants/' + payload,
                    headers: {
                        Accept: 'application/json'
                    }
                })
                .then(response => {
                    commit('setVariant', response.data.variant);
                    resolve(response);
                })
                .catch(error => {
                    reject(error);
                })
            });
        },

        addVariant({}, payload) {
            return new Promise((resolve, reject) => {
                axios({
                    method: 'POST',
                    url: '/api/variants',
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

        updateVariant({}, payload) {
            return new Promise((resolve, reject) => {
                axios({
                    method: 'PUT',
                    url: '/api/variants/' + payload.id,
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

        deleteVariant({}, payload) {
            return new Promise((resolve, reject) => {
                axios({
                    method: 'DELETE',
                    url: '/api/variants/' + payload,
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
