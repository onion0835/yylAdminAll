import { createRouter, createWebHistory } from 'vue-router';
import AppLayout from '../layout/index.vue';  // 引入布局组件
import Home from '../views/Home.vue';          // 引入页面组件
import Dashboard from '../views/Dashboard.vue';// 引入页面组件

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
        path: 'dashboard',
        component: Dashboard, // 在布局组件中的 <router-view> 渲染 Dashboard 组件
      }
    ]
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;
