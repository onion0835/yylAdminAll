<template>
  <header class="flex justify-between items-center py-3 px-4 sm:px-6 lg:px-8 bg-green-500 shadow-sm">
    <img src="../assets/logo.png" alt="Logo" class="h-8 w-auto">
    <nav class="space-x-4">
      <router-link to="/" class="text-sm text-gray-600 hover:text-gray-900">首页</router-link>
      <router-link to="/content" class="text-sm text-gray-600 hover:text-gray-900">内容</router-link>
      <router-link to="/files" class="text-sm text-gray-600 hover:text-gray-900">文件</router-link>
      <router-link to="/feedback" class="text-sm text-gray-600 hover:text-gray-900">反馈</router-link>
      <a @click="login" class="text-sm text-gray-600 hover:text-gray-900 cursor-pointer">登录</a>
      <router-link to="/profile" class="text-sm text-gray-600 hover:text-gray-900">个人中心</router-link>
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
    },
    login(){
      //打开登录页面views 下面的  Login.vue
      this.$router.push('/login');
    }
  }
}
</script>