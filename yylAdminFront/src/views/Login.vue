<template>
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <AppHeader />
    <main class="py-12">
      <div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-center mb-6">登录</h2>
        <form @submit.prevent="handleLogin" ref="loginRef">
          <div class="mb-4">
            <label for="username" class="block text-sm font-medium text-gray-700">用户名:</label>
            <input type="text" v-model="loginForm.username" 
            id="username" required 
            @blur="validateField('username')"
            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" />
            <p v-if="errors.username" class="mt-1 text-sm text-red-600">{{ errors.username }}</p>
          </div>
          <div class="mb-6">
            <label for="password"  class="block text-sm font-medium text-gray-700">密码:</label>
            <input type="password" v-model="loginForm.password" id="password"
             @blur="validateField('password')"  required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" />
             <p v-if="errors.password" class="mt-1 text-sm text-red-600">{{ errors.password }}</p>
          </div>
          <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Login</button>
        </form>
      </div>
    </main>
    <AppFooter />
  </div>
</template>

<script setup>
import {ref , reactive, getCurrentInstance,watch} from 'vue';
import { useRouter, useRoute } from 'vue-router';
import { useSettingsStoreHook } from '@/store/modules/settings'
import { useUserStoreHook } from '@/store/modules/user'


import AppHeader from '@/layout/AppHeader.vue';
import AppFooter from '@/layout/AppFooter.vue';
const { proxy } = getCurrentInstance();
const errors = reactive({});

// 改成 组合API模式
const loginForm=ref({
        username: '',
        password: '',
        captcha_id: '',
        captcha_code: '',
        ajcaptcha: {}
      });

const loginRules = {
  username: [{ required: true, trigger: 'blur', message: '请输入您的账号' }],
  password: [{ required: true, trigger: 'blur', message: '请输入您的密码' }]
};

const validateField = (field) => {
  const rule = loginRules[field][0];
  if (rule.required && !loginForm.value[field]) {
    errors[field] = rule.message;
  } else {
    errors[field] = '';
  }
};

const validateForm = () => {
  let isValid = true;
  for (const field in loginRules) {
    validateField(field);
    if (errors[field]&& errors[field].trim() !== '') {
      isValid = false;
    }
  }
  console.log(errors);
  return isValid;
};

const codeUrl = ref('');
const loading = ref(false);
// 验证码开关
const isCaptchaOn = ref(true);
// 注册开关
const register = ref(false);
const redirect = ref('');
const otherQuery = ref({});
const route = useRoute();
const router = useRouter();

/*
function handleLogin(){

  proxy.$refs.loginRef.validate((valid) => {
    if (valid) {
      console.log('表单数据有效');
    } else {
      console.log('表单数据无效');
    }
  });
}*/
watch(route, (newQuery) => { 
  const query = newQuery.query;
  if(query){  
    console.log(query);
    redirect.value = query.redirect;
    otherQuery.value = getOtherQuery(query);
  }
}, { immediate: true });





function getOtherQuery(query)
{
  console.log(query);
  return Object.keys(query).reduce((acc, key) => {
    if (key !== 'redirect') {
      acc[key] = query[key];
    }
    return acc;
  }, {});
}



function handleLogin() {
console.log('redirect.value',redirect.value);
console.log('otherQuery.value',otherQuery.value);


  if (validateForm()) {

    console.log('表单数据有效');
    loading.value = true;
    const useUserStore = useUserStoreHook()
        useUserStore
            .login(loginForm.value)
            .then(() => {
              proxy.$router
                .push({
                  path: redirect.value || '/',
                  query: otherQuery.value
                })

                .catch(() => {
                  loading.value = false
                })
            })
            .catch((error) => {
              loading.value = false
              console.log('登录失败');
              //这里把捕获得异常console出来
              console.log(error);
              /*
              if (this.captcha_switch && this.captcha_mode === 2) {
                this.$refs.ajcaptcha.refresh()
              } else {
                this.captcha()
              }
                */
            })

    //
  }else{
    console.log('表单数据无效');
  }
  /*
      this.$refs['ref'].validate((valid) => {
        if (valid) {
          this.loading = true
          const userStore = useUserStoreHook()
          userStore
            .login(submitData)
            .then(() => {
              this.$router
                .push({
                  path: this.redirect || '/',
                  query: this.otherQuery
                })
                .catch(() => {
                  this.loading = false
                })
            })
            .catch(() => {
              this.loading = false
              if (this.captcha_switch && this.captcha_mode === 2) {
                this.$refs.ajcaptcha.refresh()
              } else {
                this.captcha()
              }
            })
        } else {
          return false
        }
      })*/
    }
    
/*
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
*/


</script>

<style scoped>
/* Tailwind CSS classes are used directly in the template */
</style>