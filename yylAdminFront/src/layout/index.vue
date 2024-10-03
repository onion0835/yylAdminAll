<template>
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 min-h-screen flex flex-col">
    <AppHeader />
    <main class="mt-0">
      <router-view></router-view>
    </main>
    <AppFooter />
  </div>
</template>

<script setup>
import AppHeader from './AppHeader.vue'
import AppFooter from './AppFooter.vue'

</script>

<style scoped>

</style>
