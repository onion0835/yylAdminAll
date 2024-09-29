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
                    <li v-for="item in menuItems" :key="item.category_id" class="mb-2">
                      <div
                        @click="updateContentList(item.category_id)"
                        class="block px-4 py-2 text-sm font-semibold text-gray-900 cursor-pointer hover:bg-gray-100">
                        {{ item.category_name }}
                      </div>
                      <ul v-if="item.children && item.children.length" class="ml-4">
                        <li v-for="subItem in item.children" :key="subItem.category_id" class="mt-1">
                          <a href="#"
                          @click.prevent="updateContentList(subItem.category_id)"
                          class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-200 rounded">{{ subItem.category_name }}</a>
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
                  <div v-for="item in contentItems" :key="item.unique" class="bg-white rounded-lg shadow-md overflow-hidden flex">
                    <div class="w-1/3 bg-gray-300 flex items-center justify-center">
                      <img v-if="item.image" :src="item.image" :alt="item.title" class="w-full h-full object-cover" />
                      <svg v-else class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <div class="w-2/3 p-4">
                      <h3 class="text-lg font-semibold text-gray-900">{{ item.name }}</h3>
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
                   <!-- 分页信息 -->
                  <div class="mt-4 text-sm text-gray-600">
                    当前页: {{ page }} / {{ pages }} 页
                    总记录数: {{ count }}
                  </div>
                  <!-- 其他内容 -->
                  <!--<Pagination :totalPages="{pages}" initialPage="1" @pageChanged="handlePageChange" />-->
                  <Pagination 
                    :totalPages="totalPages"
                    :initialPage="currentPage"
                    @pageChanged="handlePageChange"
                  />

                </div> 
                <!-- 分页结束， 按照数字展示每页  -->
            </div>
  
            <!-- 右侧热门文章列表 -->
            <div class="w-1/4 px-4 overflow-y-auto">
              <h2 class="text-xl font-bold mb-4">置顶文章</h2>
              <!-- 在这里添加热门文章列表 -->
              <div v-for="item in topsItems" :key="item.unique" class="bg-white rounded-lg shadow-md overflow-hidden flex">
                
                <div class="w-2/3 p-4">
                  <h3 class="text-lg font-semibold text-gray-900">{{ item.name }}</h3>
                </div>
              </div>

              <div class="section-spacer"></div>

              <h2 class="text-xl font-bold mb-4">热门文章</h2>
              <div v-for="item in hotsItems" :key="item.unique" class="bg-white rounded-lg shadow-md overflow-hidden flex">
                <div class="w-2/3 p-4">
                  <h3 class="text-lg font-semibold text-gray-900">{{ item.name }}</h3>
                </div>
              </div>
              <div class="section-spacer"></div>

              <h2 class="text-xl font-bold mb-4">推荐文章</h2>
              <div v-for="item in recsItems" :key="item.unique" class="bg-white rounded-lg shadow-md overflow-hidden flex">
                <div class="w-2/3 p-4">
                  <h3 class="text-lg font-semibold text-gray-900">{{ item.name }}</h3>
                </div>
              </div>
            </div>
          </div>
        </div>

  </template>
  
  <script setup>
import { ref , onMounted } from 'vue';
import Pagination from '../components/Pagination/Pagination.vue';
import { useContentStoreHook } from '@/store/modules/content';
import { storeToRefs } from 'pinia';


const query= { search_field: 'category_name', search_exp: 'like', date_field: 'create_time' };

const contentStore = useContentStoreHook();
const { contentItems,topsItems,hotsItems,recsItems, menuItems , currentCategory,count,page,pages,hot,tops} = storeToRefs(contentStore);

const currentPage = ref(1);
const pageSize = ref(10);
const totalItems = ref(0);
const totalPages = ref(0);

//分页处理
const handlePageChange = (page) => {
  console.log('Current page:', page);
  currentPage.value = page;
  // 在这里处理页面变化，例如加载新的数据
  contentStore.getContentList(currentCategory.value,currentPage.value,pageSize.value);
};


const updateContentList = async (category_id) => {
  console.log('updateContentList', category_id);
  try {
     const res = await contentStore.getContentList(category_id,currentPage.value,pageSize.value);
    console.log('topItems',topsItems)
    console.log('contentItems',contentItems)

    totalItems.value = res.data.count;
    totalPages.value = res.data.pages;
    currentPage.value = res.data.page;

  } catch (error) {
    console.error('获取文章列表失败:', error); 
  }
}

//更新列表
updateContentList();

  // 其他组件逻辑
  </script>

<style scoped>


.section-spacer {
  height: 2rem; /* 或其他你想要的间隔大小 */
  margin: 1rem 0;
  border-bottom: 1px solid #eee; /* 可选：添加一个分隔线 */
}


</style>