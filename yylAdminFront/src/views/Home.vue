<template>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
  <AppHeader />
  <!-- Main content -->
    <main class="py-12">
      <h1 class="text-4xl font-bold text-center mb-4">yylAdmin</h1>
      <img src="../assets/main-logo.png" alt="yylAdmin Logo" class="w-48 mx-auto mb-6">
      
      <p class="text-center text-xl mb-8">基于ThinkPHP8和Vue3的极简后台管理系统</p>
      
      <div class="flex justify-center space-x-4 mb-12">
        <button class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">演示</button>
        <button class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">文档</button>
        <button class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">Gitee</button>
        <button class="bg-gray-800 hover:bg-gray-900 text-white font-bold py-2 px-4 rounded">Github</button>
      </div>
      
      <!-- Version table -->
      <table class="w-full mb-12">
        <thead>
          <tr class="bg-gray-200">
            <th class="p-2 text-left">版本</th>
            <th class="p-2 text-left">分支</th>
            <th class="p-2 text-left">简介</th>
            <th class="p-2 text-left">环境</th>
          </tr>
        </thead>
        <tbody>
          <tr class="border-b">
            <td class="p-2">v4</td>
            <td class="p-2">master</td>
            <td class="p-2">thinkphp8 vue3 element-plus</td>
            <td class="p-2">php8.0 node18</td>
          </tr>
          <tr>
            <td class="p-2">v3</td>
            <td class="p-2">v3</td>
            <td class="p-2">thinkphp6 vue2 element-ui</td>
            <td class="p-2">php7.3 node12</td>
          </tr>
        </tbody>
      </table>
      
      <!-- Feature cards -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="border rounded-lg p-6 shadow-sm">
          <h3 class="text-xl font-semibold mb-2">前后分离</h3>
          <p>前后分离开发模式，开发更清晰，分工更明确，提升开发效率，API交互，JWT认证。</p>
        </div>
        <div class="border rounded-lg p-6 shadow-sm">
          <h3 class="text-xl font-semibold mb-2">简单轻量</h3>
          <p>快速、简单、轻量，保持出色的性能和至简代码的同时，更注重易用性，上手容易。</p>
        </div>
        <div class="border rounded-lg p-6 shadow-sm">
          <h3 class="text-xl font-semibold mb-2">免费开源</h3>
          <p>遵守开源协议，无需付费即可商业化使用，代码全部免费开放，没有任何加密。</p>
        </div>
        <div class="border rounded-lg p-6 shadow-sm">
          <h3 class="text-xl font-semibold mb-2">开箱即用</h3>
          <p>登录退出，权限管理，日志管理，接口文档等基本功能，前后台基础框架，安装后即可使用。</p>
        </div>
      </div>
    </main>
  <AppFooter />
  </div>
</template>

<script>
import AppHeader from  '@/components/AppHeader.vue'
import AppFooter from '@/components/AppFooter.vue'


export default {
  name: 'Home',
  components: {
    AppHeader,
    AppFooter
  }
}
</script>