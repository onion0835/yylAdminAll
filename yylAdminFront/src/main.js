import { createApp } from 'vue'
import './index.css'
import App from './App.vue'
import router from './router'
import { setupStore } from './store'

createApp(App).use(router).use(setupStore).mount('#app')
