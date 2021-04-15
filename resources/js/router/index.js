import Vue from 'vue';
import Router from 'vue-router';

import UserLogin from '../pages/user/UserLogin';
import UserRegister from '../pages/user/UserRegister';

Vue.use(Router);

const router = new Router({
    mode: 'history',

    routes: [














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



export default router;
