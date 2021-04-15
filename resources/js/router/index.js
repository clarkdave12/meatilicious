import Vue from 'vue';
import Router from 'vue-router';
import store from '../store';

import UserLogin from '../pages/user/UserLogin';
import UserRegister from '../pages/user/UserRegister';

import AdminLogin from '../pages/admin/AdminLogin';
import AdminMainPage from '../pages/admin/AdminMain';

Vue.use(Router);

const router = new Router({
    mode: 'history',

    routes: [

        // Admin side
        {
            path: '/admin/login',
            name: 'adminLogin',
            component: AdminLogin
        },
        {
            path: '/admin',
            name: 'adminMain',
            component: AdminMainPage,
            meta: { requireAdmin: true }
        },











        // Rommel routes
        {
            path: '/login',
            name: 'userLogin',
            component: UserLogin
        },
        {
            path: '/register',
            name: 'userRegister',
            component: UserRegister
        }











    ]
});



router.beforeEach((to, from, next) => {
    if(to.matched.some(record => record.meta.requireAdmin)) {
        let token = store.getters['users/getToken'];
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
                    store.commit('users/setToken', token);
                    // console.log(response.data);
                    store.commit('users/setUser', response.data);
                    next();
                })
                .catch(error => {
                    console.log(error);
                    router.replace({name: 'adminLogin'});
                });

            }
            else {
                router.replace({name: 'adminLogin'});
            }
        }
        else {
            next();
        }
    }
    else {
        next();
    }
});


export default router;
