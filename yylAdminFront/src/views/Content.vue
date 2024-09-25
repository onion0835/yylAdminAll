<template>

    <!-- Header -->

      <!-- Main content area -->
      
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
          <div class="flex -mx-4">
            <!-- 左侧目录 -->
            <div class="w-1/4 px-4 overflow-y-auto">
              <h2 class="text-xl font-bold mb-4">目录</h2>
              <aside class="w-64 bg-white shadow-md">
                <nav class="mt-5 px-2">
                  <ul>
                    <li v-for="item in menuItems" :key="item.id" class="mb-2">
                      <span class="block px-4 py-2 text-sm font-semibold text-gray-900">{{ item.name }}</span>
                      <ul v-if="item.items" class="ml-4">
                        <li v-for="subItem in item.items" :key="subItem" class="mt-1">
                          <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-200 rounded">{{ subItem }}</a>
                        </li>
                      </ul>
                    </li>
                  </ul>
                </nav>
              </aside>
            </div>
  
            <!-- 中间文章列表 -->
            <div class="w-1/2 px-4 overflow-y-auto">
              <h2 class="text-xl font-bold mb-4">文章列表</h2>
              <!-- 在这里添加文章列表 start-->
                <div class="space-y-6">
                  <div v-for="item in contentItems" :key="item.id" class="bg-white rounded-lg shadow-md overflow-hidden flex">
                    <div class="w-1/3 bg-gray-300 flex items-center justify-center">
                      <img v-if="item.image" :src="item.image" :alt="item.title" class="w-full h-full object-cover" />
                      <svg v-else class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <div class="w-2/3 p-4">
                      <h3 class="text-lg font-semibold text-gray-900">{{ item.title }}</h3>
                      <div class="mt-2 flex items-center text-sm text-gray-600">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        <span>{{ item.views }}</span>
                        <span class="mx-2">•</span>
                        <span>{{ item.date }}</span>
                      </div>
                      <div v-if="item.tags" class="mt-2">
                        <span v-for="tag in item.tags" :key="tag" class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">{{ tag }}</span>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- 在这里添加文章列表 end-->
                <!-- 分页开始， 按照数字展示每页  -->
                <div>
                  <!-- 其他内容 -->
                  <Pagination :totalPages="9" :initialPage="1" @pageChanged="handlePageChange" />
                </div> 
                <!-- 分页结束， 按照数字展示每页  -->
            </div>
  
            <!-- 右侧热门文章列表 -->
            <div class="w-1/4 px-4 overflow-y-auto">
              <h2 class="text-xl font-bold mb-4">热门文章</h2>
              <!-- 在这里添加热门文章列表 -->
            </div>
          </div>
        </div>

  </template>
  
  <script setup>
import { ref } from 'vue';
import Pagination from '../components/Pagination/Pagination.vue';

const handlePageChange = (page) => {
  console.log('Current page:', page);
  // 在这里处理页面变化，例如加载新的数据
};

const menuItems = ref([
  { id: 1, name: '产品中心', items: ['后端代码', '前端模板', '后台系统', 'sdfsdf'] },
  { id: 2, name: '新闻资讯', items: ['行业动态', '软件更新', '公司新闻'] },
  { id: 3, name: '案例展示', items: ['企业官网', '品牌官网', '电商系统'] },
  { id: 4, name: '下载中心', items: ['开发文档', '使用手册'] },
  { id: 5, name: '在线视频', items: ['演示', '宣传'] },
  { id: 6, name: '关于我们', items: ['荣誉资质', '企业风采', '大事历程', '联系我们'] },
]);

const contentItems = ref([
  {
    id: 1,
    title: '顺丰沪',
    views: 21,
    date: '2024-09-13 00:00:00',
    image: '',
    tags: ['测试', '配民快色部分新量']
  },
  {
    id: 2,
    title: '55',
    views: 7,
    date: '2024-09-08 11:50:26',
    image: '',
    tags: ['地球坏事', '小冰河来了？2024年再']
  },
  // ... 添加更多项目
]);
  
  // 其他组件逻辑
  </script>