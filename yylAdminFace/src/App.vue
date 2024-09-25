<template>
    <div id="app">
      <NavBar /> <!-- 导航栏组件 -->
      <router-view /> <!-- 用于加载 layout/index.vue 布局组件 -->
    </div>
  </template>
  
  <script>
  import NavBar from './components/NavBar.vue';
  
  export default {
    components: {
      NavBar
    }
  };
  </script>
  
  <style>
  /* 可选样式 */
  #app {
    font-family: Avenir, Helvetica, Arial, sans-serif;
    text-align: center;
    margin-top: 60px;
  }
  </style>
  