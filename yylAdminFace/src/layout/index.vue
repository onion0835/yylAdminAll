<template>
    <div class="layout">
      <h1>Layout Page</h1>
      <nav>
        <router-link to="/">Home</router-link> |
        <router-link to="/dashboard">Dashboard</router-link>
      </nav>
      <div class="main-content">
        <router-view /> <!-- 用于加载子路由组件，如 Home 或 Dashboard -->
      </div>
    </div>
  </template>
  
  <script>
  export default {
    name: 'AppLayout',
  };
  </script>
  
  <style scoped>
  .layout {
    display: flex;
    flex-direction: column;
    align-items: center;
  }
  
  nav {
    margin-bottom: 20px;
  }
  
  .main-content {
    padding: 20px;
    background-color: #f0f0f0;
    width: 100%;
    max-width: 800px;
  }
  </style>
  