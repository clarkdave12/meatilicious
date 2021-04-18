import axios from "axios";

export default {
    namespaced: true,
    state: {
        units: [],
        unit: {}
    },
    getters: {
        getUnits: state => state.units,

        getUnit: state => state.unit,
    },
    mutations: {
        setUnits: (state, units) => state.units = units,

        setUnit: (state, unit) => state.unit = unit
    },
    actions: {

        getUnits({commit}) {
            return new Promise((resolve, reject) => {
                axios({
                    method: 'GET',
                    url: '/api/units',
                    headers: {
                        Accept: 'application/json'
                    }
                })
                .then(response => {
                    commit('setUnits', response.data.units);
                    resolve(response);
                })
                .catch(error => {
                    reject(error);
                })
            });
        },

        getUnit({commit}, id) {
            return new Promise((resolve, reject) => {
                axios({
                    method: 'GET',
                    url: '/api/units/' + id,
                    headers: {
                        Accept: 'application/json'
                    }
                })
                .then(response => {
                    commit('setUnit', response.data.unit);
                    resolve(response);
                })
                .catch(error => {
                    reject(error);
                })
            });
        },

        addUnit({}, payload) {
            return new Promise((resolve, reject) => {
                axios({
                    method: 'POST',
                    url: '/api/units',
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

        updateUnit({}, payload) {
            return new Promise((resolve, reject) => {
                axios({
                    method: 'PUT',
                    url: '/api/units/' + payload.id,
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

        deleteUnit({}, payload) {
            return new Promise((resolve, reject) => {
                axios({
                    method: 'DELETE',
                    url: '/api/units/' + payload,
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
        }

    }
}
