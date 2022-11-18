import { createWebHistory, createRouter } from 'vue-router'
import Main from '../views/Home.vue'
import NotFound from "../views/NotFound.vue"
import Search from "../views/Search.vue";
import Account from "../views/Account.vue";
import Login from "../views/Login.vue";
import Register from "../views/Register.vue";
import AdminPanel from "../views/Admin-panel.vue";
import ManageAuthors from "../views/AdminPanel/ManageAuthors.vue";
import CreateAuthor from "../views/AdminPanel/CreateAuthor.vue";
import AuthorPanel from "../views/AuthorPanel.vue";
import ArticleList from "../views/AuthorPanelComponents/ArticleList.vue";
import WriteArticle from "../views/AuthorPanelComponents/WriteArticle.vue";
import edit from "../views/Account/edit.vue";
import ReadArticle from "../views/ReadArticle.vue";

const routes = [
    {
        path: '/',
        name: 'Home',
        component: Main,
        meta: { title: 'News - 16min' },
    },
    {
        path: '/category/:category',
        name: 'ByCategory',
        component: Main,
        props: true,
        meta: { title: 'Categories - 16min' },
    },
    {
        path: '/account',
        name: 'Account',
        component: Account,
        meta: { title: 'Account - 16min' },
        children: [
            {
                path: 'edit',
                component: edit
            }
        ]
    },
    {
        path: '/login',
        name: 'Login',
        component: Login,
        meta: { title: 'Log in - 16min' },
    },
    {
        path: '/register',
        name: 'Register',
        component: Register,
        meta: { title: 'Register - 16min' }
    },
    {
        path: '/search',
        name: 'Search',
        component: Search,
        meta: { title: 'Search - 16min' },
    },
    {
        path: '/panel',
        name: 'Panel',
        component: AdminPanel,
        meta: { title: 'Admin panel - 16min' },
        children: [
            {
                path: 'authors',
                component: ManageAuthors
            },
            {
                path: 'create',
                component: CreateAuthor
            }
        ]
    },
    {
        path: '/author-panel',
        name: 'AuthorPanel',
        component: AuthorPanel,
        meta: { title: 'Author panel - 16min' },
        children: [
            {
                path: 'articles',
                component: ArticleList
            },
            {
                path: 'write',
                component: WriteArticle
            }
        ]
    },
    {
        path: '/article/:slug',
        name: 'Article',
        component: ReadArticle,
        props: true,
        meta: { title: 'Article - 16min' }
    },
    {
        path: '/:catchAll(.*)',
        component: NotFound,
        meta: { title: 'Page not found - 16min' },
    }
]

const Router = createRouter({
    history: createWebHistory(),
    routes
})

export default Router