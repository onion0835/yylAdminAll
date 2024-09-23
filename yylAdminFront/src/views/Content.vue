<template>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 min-h-screen flex flex-col">
    <!-- Header -->
    <div class="w-full bg-white shadow-sm">
      <AppHeader />
    </div>
    <main class="py-12">
      <!-- Main content area -->
      
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
          <div class="flex -mx-4">
            <!-- 左侧目录 -->
            <div class="w-1/4 px-4 overflow-y-auto">
              <h2 class="text-xl font-bold mb-4">目录</h2>
              <!-- 在这里添加目录内容 -->
            </div>
  
            <!-- 中间文章列表 -->
            <div class="w-1/2 px-4 overflow-y-auto">
              <h2 class="text-xl font-bold mb-4">文章列表</h2>
              <!-- 在这里添加文章列表 -->
            </div>
  
            <!-- 右侧热门文章列表 -->
            <div class="w-1/4 px-4 overflow-y-auto">
              <h2 class="text-xl font-bold mb-4">热门文章</h2>
              <!-- 在这里添加热门文章列表 -->
            </div>
          </div>
        </div>
      
    </main>
      <!-- Footer -->
      <!-- Footer -->
    <div class="w-full bg-white shadow-sm">
      <AppFooter />
    </div>
    </div>
  </template>
  
  <script setup>
  import AppHeader from '@/layout/AppHeader.vue';
  import AppFooter from '@/layout/AppFooter.vue';
  
  // 其他组件逻辑
  </script>