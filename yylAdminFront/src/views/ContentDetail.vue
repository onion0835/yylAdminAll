<template>
    <div class="min-h-screen flex">
    <!-- 左侧：文章主要内容，包括导航和免责声明 -->
    <div class="flex-grow p-6">
      <div v-if="loading" class="flex items-center justify-center h-64">
        <p class="text-xl">加载中...</p>
      </div>
      <div v-else-if="error" class="flex items-center justify-center h-64">
        <p class="text-xl text-red-500">{{ error }}</p>
      </div>
      <div v-else class="max-w-3xl mx-auto">
        <h1 class="text-4xl font-bold text-center mb-8 text-gray-900">{{ article.name }}</h1>
        <div class="prose prose-lg mx-auto mb-8" v-html="article.content"></div>
        
        <!-- 导航 -->
        <div class="my-8 flex justify-between items-center">
          <button 
            @click="navigateToContent(previous_id)" 
            :disabled="!previous_id"
            class="px-4 py-2 bg-blue-500 text-white rounded disabled:bg-gray-400 disabled:cursor-not-allowed"
          >
            上一页
          </button>
          <button 
            @click="navigateToContent(next_id)" 
            :disabled="!next_id"
            class="px-4 py-2 bg-blue-500 text-white rounded disabled:bg-gray-400 disabled:cursor-not-allowed"
          >
            下一页
          </button>
        </div>
        
        <!-- 免责声明 -->
        <div class="mt-8 p-4 bg-gray-100 text-sm text-gray-600 rounded">
          <p>免责声明：本文内容仅供参考，不构成任何法律或其他专业建议。</p>
        </div>
      </div>
    </div>
    
    <!-- 右侧：置顶列表 -->
    <div class="w-64  p-6 flex-shrink-0">
      <h2 class="text-xl font-semibold mb-4">置顶文章</h2>
      <ul class="space-y-2">
        <li v-for="topArticle in topsItems" :key="topArticle.content_id">
          <a 
          :href="`/content/${topArticle.content_id}`"
                  target="_blank"
                 rel="noopener noreferrer"
            class="bg-white rounded-lg  overflow-hidden flex"
          >
            {{ topArticle.name }}
          </a>
        </li>
      </ul>
    </div>
  </div>
  </template>

<script setup>
import { useRoute } from 'vue-router';
import {info} from '@/api/front/content'
import { ref,onMounted } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();

const article = ref({})
const topsItems =ref([])
const loading = ref(false)
const error = ref(null)
const previous_id = ref(null)
const next_id = ref(null)
const id = ref(null)

const route = useRoute();
 id.value = route.params.id;

// 使用 id 获取详细内容的逻辑
const getContentInfo = async (id) => {
  const res = await info({content_id: id})
  console.log(res);
  article.value = res.data
  loading.value = false
  error.value = res.message
  topsItems.value = res.data.list
  previous_id.value = res.data.prev_info.content_id
  next_id.value = res.data.next_info.content_id
}

onMounted(() => {
  getContentInfo(id.value)
})

//页面跳转
const navigateToContent = (contentId) => {
    console.log("navigateToContent",contentId)
    try{
         router.push({ name: 'ContentDetail', params: { id: contentId } });
         getContentInfo(contentId);  
         id.value = contentId
    }catch(err){
        console.log(err)
    }
  
};
</script>

<style scoped>
</style>
