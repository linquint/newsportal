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
import Author from "../views/Author.vue";
import Popular from "../views/Popular.vue";

const routes = [
    {
        path: '/',
        name: 'Home',
        component: Main,
        meta: { title: 'Latest News - 16min' },
        children: [
            {
                path: '/article/:slug',
                name: 'Article',
                component: ReadArticle,
                props: true,
                meta: { title: 'Reading article - 16min' }
            }
        ]
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
                component: edit,
                meta: { title: 'Edit profile - 16min' },
            },
            {
                path: 'login',
                name: 'Login',
                component: Login,
                meta: { title: 'Log in - 16min' },
            },
            {
                path: 'register',
                name: 'Register',
                component: Register,
                meta: { title: 'Register - 16min' }
            },
        ]
    },
    {
        path: '/search',
        name: 'Search',
        component: Search,
        meta: { title: 'Search - 16min' },
        children: [
            {
                path: '/search/article/:slug',
                name: 'SearchArticle',
                component: ReadArticle,
                props: true,
                meta: { title: 'Reading article - 16min' }
            }
        ]
    },
    {
        path: '/panel',
        name: 'Panel',
        component: AdminPanel,
        meta: { title: 'Admin panel - 16min' },
        children: [
            {
                path: 'authors',
                component: ManageAuthors,
                meta: { title: 'Manage authors - 16min' },
            },
            {
                path: 'create',
                component: CreateAuthor,
                meta: { title: 'Create author - 16min' },
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
                component: ArticleList,
                meta: { title: 'My written articles - 16min' },
            },
            {
                path: 'write',
                component: WriteArticle,
                meta: { title: 'Write a new article - 16min' },
            }
        ]
    },
    {
        path: '/:catchAll(.*)',
        component: NotFound,
        meta: { title: 'Page not found - 16min' },
    },
    {
        path: '/author/:author',
        name: 'Author',
        component: Author,
        props: true,
        meta: { title: 'Author profile - 16min' }
    },
    {
        path: '/region/:region',
        name: 'Region',
        component: Main,
        props: true,
        meta: { title: 'Regional News - 16min' }
    },
    {
        path: '/trending',
        name: 'Popular',
        component: Popular,
        meta: { title: 'Trending News - 16min' },
        children: [
            {
                path: '/trending/article/:slug',
                name: 'PopularArticle',
                component: ReadArticle,
                props: true,
                meta: { title: 'Reading article - 16min' }
            }
        ]
    }
]

const Router = createRouter({
    history: createWebHistory(),
    routes
})

export default Router