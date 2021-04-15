import axios from 'axios';


export default {

    namespaced: true,

    state: {
        user: {},
        token: ''
    },

    getters: {
        getUser: state => state.user,

        getToken: state => state.token,
    },

    mutations: {
        setUser: (state, user) => state.user = user,

        setToken: (state, token) => state.token = token,
    },

    actions: {
        adminLogin({commit}, payload) {
            return new Promise((resolve, reject) => {

                axios({
                    method: 'POST',
                    url: '/api/admin/login',
                    data: payload,
                    headers: {
                        Accept: 'application/json'
                    }
                })
                .then(response => {
                    commit('setUser', response.data.user);
                    commit('setToken', response.data.token);
                    resolve(response);
                })
                .catch(error => {
                    reject(error);
                });

            });
        }
    }

}

