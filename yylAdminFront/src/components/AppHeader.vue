<template>
  <header class="flex justify-between items-center py-6">
    <img src="../assets/logo.png" alt="Logo" class="w-24">
    <nav class="space-x-4">
      <router-link to="/" class="text-gray-600 hover:text-gray-900">首页</router-link>
      <router-link to="/content" class="text-gray-600 hover:text-gray-900">内容</router-link>
      <router-link to="/files" class="text-gray-600 hover:text-gray-900">文件</router-link>
      <router-link to="/feedback" class="text-gray-600 hover:text-gray-900">反馈</router-link>
      <a @click="logout" class="text-gray-600 hover:text-gray-900 cursor-pointer">退出</a>
      <router-link to="/profile" class="text-gray-600 hover:text-gray-900">个人中心</router-link>
    </nav>
  </header>
</template>

<script>
export default {
  name: 'AppHeader',
  methods: {
    logout() {
      // 实现退出逻辑
      // this.$store.dispatch('logout');
      // this.$router.push('/login');
    }
  }
}
</script>