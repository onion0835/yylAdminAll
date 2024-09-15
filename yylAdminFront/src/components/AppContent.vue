<template>
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
    
    <!-- 版本表格 -->
    <table class="w-full mb-8">
      <!-- ... 版本表格内容 ... -->
    </table>

    <!-- 特性卡片 -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <!-- ... 特性卡片内容 ... -->
    </div>
  </main>
</template>

<script>
export default {
  name: 'AppContent'
}
</script>