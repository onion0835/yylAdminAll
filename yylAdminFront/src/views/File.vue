<template>
  <div class="file-detail">
    <h1>图片详情</h1>
    <div v-if="fileData">
      <img :src="fileData.file_url" :alt="fileData.file_url" class="file-image" />
      <div class="file-info">
        <p><strong>文件名：</strong>{{ fileData.name }}</p>
        <p><strong>上传时间：</strong>{{ fileData.create_time }}</p>
        <p><strong>文件大小：</strong>{{ formatFileSize(fileData.file_size) }}</p>
        <!-- 可以根据需要添加更多文件信息 -->
      </div>
    </div>
    <div v-else>
      <p>加载中...</p>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import { info } from '@/api/front/file' // 假设您有一个用于获取文件详情的API
import { watch } from 'vue'
const route = useRoute()
const fileData = ref(null)


const fetchFileDetail = async () => {
  const fileId = route.params.fileid // 假设我们使用路由参数来获取fileId
  try {
    const response = await info({file_id:fileId})
    fileData.value = response.data
  } catch (error) {
    console.error('获取文件详情失败:', error)
    // 这里可以添加错误处理逻辑，比如显示错误消息
  }
}

const formatFileSize = (size) => {
  if (size < 1024) return size + ' B'
  if (size < 1024 * 1024) return (size / 1024).toFixed(2) + ' KB'
  return (size / (1024 * 1024)).toFixed(2) + ' MB'
}

onMounted(() => {
  fetchFileDetail()
})
</script>

<style scoped>
.file-detail {
  max-width: 800px;
  margin: 0 auto;
  padding: 20px;
}

.file-image {
  max-width: 100%;
  height: auto;
  margin-bottom: 20px;
}

.file-info {
  background-color: #f5f5f5;
  padding: 15px;
  border-radius: 5px;
}
</style>
