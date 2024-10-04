<template>
  <router-view />
  <Toast ref="toast" />
</template>

<script setup>
import { ref, provide } from 'vue'
import Toast from '@/components/Toast.vue'

const toast = ref(null)

const showToast = (msg, toastType = 'info', duration = 3000) => {
  console.log('In App.vue showToast', msg, toastType, duration)
  toast.value.showToast(msg, toastType, duration)
}
provide('showToast', showToast)
</script>
