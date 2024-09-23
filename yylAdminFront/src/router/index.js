import { createRouter, createWebHistory } from  'vue-router'
import Home from '../views/Home.vue' // 导入组件
//导入views/Login.vue
import Login from '../views/Login.vue' // 导入组件
import Content from '../views/Content.vue' // 导入组件



const routes = [
    {
        path: '/',
        name:'home',
        component:Home
    },
    {
        path: '/login',
        name: 'login',
        component: Login
    },
    {
        path: '/content',
        name: 'content',
        component: Content
    }
    
]
const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router