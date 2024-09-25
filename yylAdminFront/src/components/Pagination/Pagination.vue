<template>
    <nav class="flex items-center justify-center mt-8" aria-label="Pagination">
      <button
        @click="prevPage"
        class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0"
        :disabled="currentPage === 1"
      >
        <span class="sr-only">Previous</span>
        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
          <path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z" clip-rule="evenodd" />
        </svg>
      </button>
      <template v-for="(page, index) in visiblePages" :key="index">
        <button
          v-if="page !== '...'"
          @click="goToPage(page)"
          :class="['relative inline-flex items-center px-4 py-2 text-sm font-semibold', 
                   currentPage === page ? 'z-10 bg-indigo-600 text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600' : 'text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0']"
        >
          {{ page }}
        </button>
        <span
          v-else
          class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-700 ring-1 ring-inset ring-gray-300 focus:outline-offset-0"
        >
          ...
        </span>
      </template>
      <button
        @click="nextPage"
        class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0"
        :disabled="currentPage === totalPages"
      >
        <span class="sr-only">Next</span>
        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
          <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
        </svg>
      </button>
    </nav>
  </template>
  
  <script setup>
  import { ref, computed } from 'vue';
  
  const props = defineProps({
    totalPages: {
      type: Number,
      required: true
    },
    initialPage: {
      type: Number,
      default: 1
    }
  });
  
  const emit = defineEmits(['pageChanged']);
  
  const currentPage = ref(props.initialPage);
  
  const visiblePages = computed(() => {
    const totalVisible = 7; // Total number of visible page buttons
    const pages = [];
    
    if (props.totalPages <= totalVisible) {
      for (let i = 1; i <= props.totalPages; i++) {
        pages.push(i);
      }
    } else {
      pages.push(1);
      
      if (currentPage.value > 3) {
        pages.push('...');
      }
      
      let start = Math.max(2, currentPage.value - 1);
      let end = Math.min(props.totalPages - 1, currentPage.value + 1);
      
      for (let i = start; i <= end; i++) {
        pages.push(i);
      }
      
      if (currentPage.value < props.totalPages - 2) {
        pages.push('...');
      }
      
      pages.push(props.totalPages);
    }
    
    return pages;
  });
  
  const goToPage = (page) => {
    if (page !== currentPage.value && page >= 1 && page <= props.totalPages) {
      currentPage.value = page;
      emit('pageChanged', page);
    }
  };
  
  const prevPage = () => {
    if (currentPage.value > 1) {
      goToPage(currentPage.value - 1);
    }
  };
  
  const nextPage = () => {
    if (currentPage.value < props.totalPages) {
      goToPage(currentPage.value + 1);
    }
  };
  </script>
  