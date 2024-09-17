<template>
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <AppHeader />
    <main class="py-12">
      <div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-center mb-6">登录</h2>
        <form @submit.prevent="handleLogin">
          <div class="mb-4">
            <label for="username" class="block text-sm font-medium text-gray-700">用户名:</label>
            <input type="text" v-model="model.username" id="username" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" />
          </div>
          <div class="mb-6">
            <label for="password" class="block text-sm font-medium text-gray-700">密码:</label>
            <input type="password" v-model="password" id="password" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" />
          </div>
          <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Login</button>
        </form>
      </div>
    </main>
    <AppFooter />
  </div>
</template>

<script setup>
import { useSettingsStoreHook } from '@/store/modules/settings'
import { useUserStoreHook } from '@/store/modules/user'

import AppHeader from '@/layout/AppHeader.vue';
import AppFooter from '@/layout/AppFooter.vue';

export default {
  name: 'Login',
  components: {
    AppHeader,
    AppFooter
  },
  data() {
    return {
      username: '',
      password: ''
    };
  },
  methods: {
    handleLogin() {
      // 这里可以添加登录逻辑，例如调用API
      console.log('Username:', this.username);
      console.log('Password:', this.password);
      // 清空输入框
      this.username = '';
      this.password = '';
    }
  }
};
</script>

<style scoped>
/* Tailwind CSS classes are used directly in the template */
</style>