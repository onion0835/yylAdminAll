<template>
    <transition
      enter-active-class="transition ease-out duration-300"
      enter-from-class="transform opacity-0 scale-95"
      enter-to-class="transform opacity-100 scale-100"
      leave-active-class="transition ease-in duration-200"
      leave-from-class="transform opacity-100 scale-100"
      leave-to-class="transform opacity-0 scale-95"
    >
      <div v-if="show" class="fixed top-4 right-4 z-50">
        <div :class="[
          'px-4 py-2 rounded shadow-lg',
          type === 'success' ? 'bg-green-500 text-white' : '',
          type === 'error' ? 'bg-red-500 text-white' : '',
          type === 'info' ? 'bg-blue-500 text-white' : ''
        ]">
          {{ message }}
        </div>
      </div>
    </transition>
  </template>
  
  <script setup>
  import { ref } from 'vue'
  
  const show = ref(false)
  const message = ref('')
  const type = ref('info')
  
  const showToast = (msg, toastType = 'info', duration = 3000) => {
    console.log('In Toast.vue showToast', msg, toastType, duration)
    message.value = msg
    type.value = toastType
    show.value = true
    setTimeout(() => {
      show.value = false
    }, duration)
  }
  
  defineExpose({ showToast })
  </script>