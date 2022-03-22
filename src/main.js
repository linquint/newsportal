import { createApp } from 'vue'
import App from './App.vue'
import Router from './router/index.js'

const Vue = createApp(App)
Vue.use(Router)
Vue.mount('#app')
