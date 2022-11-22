import { createApp } from 'vue'
import App from './App.vue'
import Router from './router/index.js'
import VueCookies from 'vue-cookies'

const Vue = createApp(App)
Vue.use(Router)
Vue.use(VueCookies)
Vue.mount('#app')
