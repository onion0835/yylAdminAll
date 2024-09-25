import { createRouter, createWebHistory } from  'vue-router'
import AppLayout from '../layout/index.vue';  // 引入布局组件
import Home from '../views/Home.vue' // 导入组件
//导入views/Login.vue
import Login from '../views/Login.vue' // 导入组件
import Content from '../views/Content.vue' // 导入组件


/*
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
*/

const routes = [
    {
        path: '/',
        component: AppLayout, // 顶级路由渲染布局组件
        children: [
          {
            path: '', // 默认子路由
            component: Home, // 在布局组件中的 <router-view> 渲染 Home 组件
          },
          {
            path: 'content',
            component: Content, // 在布局组件中的 <router-view> 渲染 Dashboard 组件
          },
          {
            path: 'login',
            component: Login, // 在布局组件中的 <router-view> 渲染 Dashboard 组件
          }

        ]
      }
]
const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router