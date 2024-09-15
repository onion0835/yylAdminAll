<template>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
  <AppHeader />
  <main class="py-12">
    <h1 class="text-4xl font-bold text-center mb-4">yylAdmin</h1>
    <img src="@/assets/main-logo.png" alt="yylAdmin Logo" class="w-48 mx-auto mb-6">
    
    <p class="text-center text-xl mb-8">基于ThinkPHP8和Vue3的极简后台管理系统</p>
    
    <div class="flex justify-center space-x-4 mb-12">
      <button class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">演示</button>
      <button class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">文档</button>
      <button class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">Gitee</button>
      <button class="bg-gray-800 hover:bg-gray-900 text-white font-bold py-2 px-4 rounded">Github</button>
    </div>
    
    <!-- Version table -->
    <!-- ... (保持原来的表格内容) ... -->
    
    <!-- Feature cards -->
    <!-- ... (保持原来的特性卡片内容) ... -->
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