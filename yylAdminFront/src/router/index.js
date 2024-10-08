import { createRouter, createWebHistory } from  'vue-router'
import AppLayout from '../layout/index.vue';  // 引入布局组件
import Home from '../views/Home.vue' // 导入组件
//导入views/Login.vue
import Login from '../views/Login.vue' // 导入组件
import Content from '../views/Content.vue' // 导入组件
import FileList from '../views/FileList.vue' // 导入组件
import ContentDetail from '../views/ContentDetail.vue' // 导入组件
import File from '../views/File.vue' // 导入组件
import Feedback from '../views/Feedback.vue' // 导入组件
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
            path: 'files',
            component: FileList, // 在布局组件中的 <router-view> 渲染 Dashboard 组件
          },
          {
            path: 'file/:fileid',
            component: File, // 在布局组件中的 <router-view> 渲染 Dashboard 组件
          },
          {
            path: 'login',
            component: Login, // 在布局组件中的 <router-view> 渲染 Dashboard 组件
          },
          {
            path: 'content/:id',
            name: 'ContentDetail',  // 添加这行
            component: ContentDetail, // 在布局组件中的 <router-view> 渲染 Dashboard 组件
            props: true  // 允许将路由参数作为 props 传递给组件
          },
          {
            path: 'feedback',
            name: 'Feedback',
            component: Feedback, // 在布局组件中的 <router-view> 渲染 Dashboard 组件
          }

        ]
      }
]
const router = createRouter({
    history: createWebHistory(),
    routes
})

export default router