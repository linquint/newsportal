import { createWebHistory, createRouter } from 'vue-router'
import Main from '../views/Home.vue'
import NotFound from "../views/NotFound.vue"
import Search from "../views/Search.vue";
import Account from "../views/Account.vue";
import Login from "../views/Login.vue";
import Register from "../views/Register.vue";

const routes = [
    {
        path: '/',
        name: 'Home',
        component: Main,
        meta: { title: '16 Minučių - Naujienos' },
    },
    {
        path: '/category/:category',
        name: 'ByCategory',
        component: Main,
        props: true,
        meta: { title: '16 Minučių - Naujienos' },
    },
    {
        path: '/account',
        name: 'Account',
        component: Account,
        meta: { title: '16 Minučių - Paskyra' },
    },
    {
        path: '/login',
        name: 'Login',
        component: Login,
        meta: { title: '16 Minučių - Prisijungti' },
    },
    {
        path: '/register',
        name: 'Register',
        component: Register,
        meta: { title: '16 Minučių - Registracija' }
    },
    {
        path: '/search',
        name: 'Search',
        component: Search,
        meta: { title: '16 Minučių - Paieška' },
    },
    {
        path: '/:catchAll(.*)',
        component: NotFound,
        meta: { title: '404 - Nerastas puslapis' },
    }
]

const Router = createRouter({
    history: createWebHistory(),
    routes
})

export default Router