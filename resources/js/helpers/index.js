import store from '../store';
import axios from 'axios';

export const isAdmin = function() {
    const token = store.getters['users/getToken'];
        if(!token) {
            if(localStorage.getItem('token')) {
                token = localStorage.getItem('token');

                axios({
                    method: 'GET',
                    url: '/api/is_admin',
                    headers: {
                        Accept: 'application/json',
                        Authorization: 'Bearer ' + token
                    }
                })
                .then(response => {
                    console.log(response.data);
                    store.commit('setToken', token);
                    return true;
                })
                .catch(error => {
                    console.log(error);
                    return false;
                });

            }
            else {
                return false;
            }
        }
        else {
            return true;
        }
}
