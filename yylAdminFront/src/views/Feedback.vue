<template>
  <div class="max-w-2xl mx-auto p-6">
    <form @submit.prevent="submitFeedback" class="space-y-6">
      <div>
        <label for="type" class="block text-sm font-medium text-gray-700">问题类型</label>
        <select
          id="type"
          v-model="feedbackForm.type"
          class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
        >
          <option value="" disabled>请选择问题类型</option>
          <option v-for="(name, type) in typeNames" :key="type" :value="Number(type)">
            {{ name }}
          </option>
        </select>
      </div>

      <div>
        <label for="title" class="block text-sm font-medium text-gray-700">标题</label>
        <input
          type="text"
          id="title"
          v-model="feedbackForm.title"
          class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
          placeholder="请输入标题"
        />
      </div>

      <div>
        <label for="content" class="block text-sm font-medium text-gray-700">内容</label>
        <textarea
          id="content"
          v-model="feedbackForm.content"
          rows="4"
          class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
          placeholder="请输入内容"
        ></textarea>
      </div>

      <div>
        <label for="phone" class="block text-sm font-medium text-gray-700">电话</label>
        <input
          type="tel"
          id="phone"
          v-model="feedbackForm.phone"
          class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
          placeholder="请输入电话号码"
        />
      </div>

      <div>
        <label for="email" class="block text-sm font-medium text-gray-700">邮箱</label>
        <input
          type="email"
          id="email"
          v-model="feedbackForm.email"
          class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
          placeholder="请输入邮箱地址"
        />
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">上传图片</label>
        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
          <div class="space-y-1 text-center">
            <svg
              class="mx-auto h-12 w-12 text-gray-400"
              stroke="currentColor"
              fill="none"
              viewBox="0 0 48 48"
              aria-hidden="true"
            >
              <path
                d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
              />
            </svg>
            <div class="flex text-sm text-gray-600">
              <label
                for="file-upload"
                class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500"
              >
                <span>上传文件</span>
                <input id="file-upload" name="file-upload" type="file" class="sr-only" @change="handleFileUpload" multiple accept="image/*" />
              </label>
              <p class="pl-1">或拖放文件</p>
            </div>
            <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
          </div>
        </div>
      </div>

      <div class="flex justify-end">
        <button
          type="submit"
          class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
        >
          提交反馈
        </button>
      </div>
    </form>
  </div>
</template>

<script setup>
import { ref, reactive } from 'vue'
import { add } from '@/api/front/feedback'
import { inject } from 'vue'

const showToast = inject('showToast')

const feedbackForm = reactive({
  type: '',
  title: '',
  content: '',
  phone: '',
  email: '',
  images: []
})

const typeNames = {
  0: '功能异常',
  1: '产品建议',
  2: '其它'
}

const handleFileUpload = (event) => {
  console.log(event)
  const files = Array.from(event.target.files)
  files.forEach(file => {
    if (file.type.startsWith('image/') && file.size <= 2 * 1024 * 1024) {
      const reader = new FileReader()
      reader.onload = (e) => {
        feedbackForm.images.push(e.target.result)
      }
      reader.readAsDataURL(file)
      console.log('上传成功')
      showToast('上传成功', 'success')
    } else {
      console.log('请上传2MB以内的图片文件')
      showToast('请上传2MB以内的图片文件', 'error')
    }
  })
}

const submitFeedback = async () => {
  if (!validateForm()) {
    return
  }

  try {
    const response = await addFeedback(feedbackForm)
    if (response.code === 200) {
     
      showToast('反馈提交成功', 'success')
      resetForm()
    } else {
      showToast(response.msg || '反馈提交失败', 'error')
    }
  } catch (error) {
    console.error('提交反馈时出错:', error)
    showToast('提交反馈时出错', 'error')
  }
}

const validateForm = () => {
  if (!feedbackForm.type) {
    showToast('请选择问题类型', 'error')
    return false
  }
  if (!feedbackForm.title.trim()) {
    showToast('请输入标题', 'error')
    return false
  }
  if (!feedbackForm.content.trim()) {
    showToast('请输入内容', 'error')
    return false
  }
  if (feedbackForm.phone && !/^1[3-9]\d{9}$/.test(feedbackForm.phone)) {
    showToast('请输入正确的手机号码', 'error')
    return false
  }
  if (feedbackForm.email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(feedbackForm.email)) {
    showToast('请输入正确的邮箱地址', 'error')
    return false
  }
  return true
}

const resetForm = () => {
  Object.keys(feedbackForm).forEach(key => {
    feedbackForm[key] = key === 'images' ? [] : ''
  })
}
</script>

<style scoped>
.feedback-container {
  max-width: 600px;
  margin: 0 auto;
  padding: 20px;
}
</style>