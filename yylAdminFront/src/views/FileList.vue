<template>
  <div class="container mx-auto px-4 py-3">
    <!-- 上部分：标签和分类 -->
    <div class="mb-8">
      <div class="flex flex-wrap gap-4">
        
        <div class="w-full md:w-1/2">
          <h2 class="text-sm font-semibold mb-2">分类</h2>
          <div class="flex flex-wrap gap-2">
            <button v-for="category in groups" :key="category"
            @click="selectGroup(category.group_id)"
            class="px-3 py-1 rounded-full text-sm"
            :class="selectedGroup === category.group_id ? 'bg-green-200 text-green-800' : 'bg-green-100 text-green-800'">
            {{ category.group_name }}
            </button>
          </div>
        </div>

        <div class="w-full md:w-1/2">
          <h2 class="text-sm font-semibold mb-2">标签</h2>
          <div class="flex flex-wrap gap-2">
            <button v-for="tag in tags" :key="tag"
            @click="selectTag(tag.tag_id)"
            class="px-3 py-1 rounded-full text-sm"
            :class="selectedTag === tag.tag_id ? 'bg-blue-200 text-blue-800' : 'bg-blue-100 text-blue-800'">
              {{ tag.tag_name }}
            </button>
          </div>
        </div>

      </div>
    </div>

    <!-- 中间部分：图片展示 -->
    <div class="mb-8">
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        <a :href="`/file/${image.file_id}`"  target="_blank" v-for="image in images" :key="image.id" class="bg-white rounded-lg shadow-md overflow-hidden">
          <img :src="image.file_url" :alt="image.title" class="w-full h-48 object-cover">
          <div class="p-4">
            <h3 class="text-lg font-semibold mb-2">{{ image.title }}</h3>
            <p class="text-sm text-gray-600">{{ image.description }}</p>
          </div>
        </a>
      </div>
    </div>

    <!-- 下部分：分页 -->
    <div class="flex justify-center items-center">
      <button @click="prevPage" :disabled="currentPage === 1" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-l-lg disabled:opacity-50">
        上一页
      </button>
      <span class="px-4 py-2 bg-gray-100">{{ currentPage }} / {{ totalPages }}</span>
      <button @click="nextPage" :disabled="currentPage === totalPages" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-r-lg disabled:opacity-50">
        下一页
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { list } from '@/api/front/file';
import { useRoute } from 'vue-router';

const router = useRoute()

const selectedGroup = ref(null);
const selectedTag = ref(null);
const groups = ref(['壁纸']);
const tags = ref(['风景', '人物']);

const images = ref([]);
const currentPage = ref(1);
const totalPages = ref(10);

const selectGroup = (category) => {
  if(selectedGroup.value === category){
    selectedGroup.value = null;
  }else{
    selectedGroup.value = category;
  }
  getFileList();
};

const selectTag = (tag) => {
  if(selectedTag.value === tag){
    selectedTag.value = null;
  }else{
    selectedTag.value = tag;
  }
  getFileList();
};


const getFileList = async () => {
 // const res = await list({ page: currentPage.value, limit: 12,tag_id:tags.value,group_id:groups.value });
 const res = await list({ page: currentPage.value, limit: 12,tag_id:selectedTag.value,group_id:selectedGroup.value });
  console.log(res);
  images.value = res.data.list
  groups.value = res.data.group
  tags.value = res.data.tag
  totalPages.value = res.data.pages
};

// 模拟获取图片数据
const fetchImages = (page) => {
  // 这里应该是从API获取数据的逻辑
  // 现在我们只是模拟一些数据
  const mockImages = Array(12).fill().map((_, index) => ({
    id: index + 1 + (page - 1) * 12,
    url: `https://picsum.photos/seed/${index + 1 + (page - 1) * 12}/300/200`,
    title: `图片 ${index + 1 + (page - 1) * 12}`,
    description: '这是一张随机生成的图片'
  }));
  images.value = mockImages;
};

const prevPage = async () => {
  if (currentPage.value > 1) {
    currentPage.value--;
   // fetchImages(currentPage.value);
   const res = await list({ page: currentPage.value, limit: 12,tag_id:selectedTag.value,group_id:selectedGroup.value });
  console.log(res);
  images.value = res.data.list
  groups.value = res.data.group
  tags.value = res.data.tag
  totalPages.value = res.data.pages
  }
};

const nextPage = async () => {
  if (currentPage.value < totalPages.value) {
    currentPage.value++;
   // fetchImages(currentPage.value);
   const res = await list({ page: currentPage.value, limit: 12,tag_id:selectedTag.value,group_id:selectedGroup.value });
  console.log(res);
  images.value = res.data.list
  groups.value = res.data.group
  tags.value = res.data.tag
  totalPages.value = res.data.pages
  }
};

// 跳转到文件详情
const navigateToFile = (fileId) => {
  //navigateTo(`/file/${fileId}`)
  console.log(fileId);
  const fileUrl = router.resolve({
    name: 'File',
    params: { fileid: fileId }
  })
  console.log(fileUrl);
  window.open(fileUrl, '_blank');
}

onMounted(() => {
    getFileList()
  // fetchImages(currentPage.value);
});
</script>
