<template>
  <header class="flex justify-between items-center py-3 px-4 sm:px-6 lg:px-8 bg-white shadow-sm">
    <img src="../assets/logo.png" alt="Logo" class="h-8 w-auto">
    <nav class="space-x-4">
      <router-link to="/" class="text-sm text-gray-600 hover:text-gray-900">首页</router-link>
      <router-link to="/content" class="text-sm text-gray-600 hover:text-gray-900">内容</router-link>
      <router-link to="/files" class="text-sm text-gray-600 hover:text-gray-900">文件</router-link>
      <router-link to="/feedback" class="text-sm text-gray-600 hover:text-gray-900">反馈</router-link>
      <a v-if="!userStore.isLoggedIn" @click="login" class="text-sm text-gray-600 hover:text-gray-900 cursor-pointer">登录</a>
      <a v-else @click="logout" class="text-sm text-gray-600 hover:text-gray-900 cursor-pointer">退出</a>
    
      <router-link v-if="userStore.isLoggedIn" to="/profile" class="text-sm text-gray-600 hover:text-gray-900">
       您好 {{ userStore.user.nickname || userStore.user.username }}
      </router-link>

    </nav>
  </header>
</template>

<script setup>
import { useRouter } from 'vue-router';
import { onMounted, watch } from 'vue'

import { useUserStore } from '@/store/modules/user'
const router = useRouter();
const userStore = useUserStore();
onMounted(() => {
  console.log('Initial isLoggedIn value:', userStore.isLoggedIn)
})

watch(() => userStore.isLoggedIn, (newValue) => {
  console.log('isLoggedIn changed:', newValue)
})
const logout = () => {
  // 实现退出逻辑
  userStore.logout();
  router.push('/login');
};

const login = () => {
  // 打开登录页面views 下面的 Login.vue
  router.push('/login');
};
</script>