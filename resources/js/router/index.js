import Vue from 'vue';
import Router from 'vue-router';
import store from '../store';

import UserLogin from '../pages/user/UserLogin';
import UserRegister from '../pages/user/UserRegister';

import AdminLogin from '../pages/admin/AdminLogin';
import AdminMainPage from '../pages/admin/AdminMain';
import Dashboard from '../pages/admin/subs/Dashboard';

import Categories from '../pages/admin/subs/Categories';
import AddCategory from '../pages/admin/actions/AddCategory';
import UpdateCategory from '../pages/admin/actions/UpdateCategory';

import SubCategories from '../pages/admin/subs/SubCategories';
import AddSubCategory from '../pages/admin/actions/AddSubCategory';
import UpdateSubCategory from '../pages/admin/actions/UpdateSubCategory';

import Units from '../pages/admin/subs/Units';
import AddUnit from '../pages/admin/actions/AddUnit';
import UpdateUnit from '../pages/admin/actions/UpdateUnit';

import Products from '../pages/admin/subs/Products';
import AddProduct from '../pages/admin/actions/AddProduct';
import UpdateProduct from '../pages/admin/actions/UpdateProduct';

import NotFound from '../components/404';

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
            meta: { requireAdmin: true },
            children: [
                {
                    path: 'dashboard',
                    name: 'dashboard',
                    component: Dashboard
                },
                {
                    path: 'categories',
                    name: 'categories',
                    component: Categories
                },
                {
                    path: 'categories/create',
                    name: 'add_category',
                    component: AddCategory
                },
                {
                    path: 'categories/edit/:categoryId',
                    name: 'update_category',
                    component: UpdateCategory
                },
                {
                    path: 'sub_categories',
                    name: 'sub_categories',
                    component: SubCategories
                },
                {
                    path: 'sub_categories/create',
                    name: 'add_sub_category',
                    component: AddSubCategory
                },
                {
                    path: 'sub_categories/edit/:subCategoryId',
                    name: 'update_sub_category',
                    component: UpdateSubCategory
                },
                {
                    path: 'units',
                    name: 'units',
                    component: Units
                },
                {
                    path: 'units/create',
                    name: 'add_unit',
                    component: AddUnit
                },
                {
                    path: 'units/edit/:unitId',
                    name: 'update_unit',
                    component: UpdateUnit
                },
                {
                    path: 'products',
                    name: 'products',
                    component: Products
                },
                {
                    path: 'products/create',
                    name: 'add_product',
                    component: AddProduct
                },
                {
                    path: 'products/edit/:productId',
                    name: 'update_product',
                    component: UpdateProduct
                }
            ]
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
        },









        {
            path: '*',
            component: NotFound
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
