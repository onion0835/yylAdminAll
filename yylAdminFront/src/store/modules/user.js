import { defineStore } from 'pinia';
import { reactive, computed  } from 'vue'  // 添加这行
import { store } from '@/store'
import { useStorage } from '@vueuse/core'
import { useSettingsStore } from '@/store/modules/settings'
import { login as loginApi, logout as logoutApi } from '@/api/system/login'

import defaultSettings from '@/settings'

export const useUserStore = defineStore('user',()=>{
    const settingsStore = useSettingsStore()
    const storePrefix = defaultSettings.storePrefix
    const tokenName = settingsStore.tokenName
    const token = useStorage(storePrefix + tokenName, '')
    const user = reactive({
        username: '',
        nickname: '',
        avatar_url: '',
        roles: [],
        menus: []
      })
    // 添加 isLoggedIn 计算属性
    const isLoggedIn = computed(() => !!token.value)
      // 登录
      function login (data)  {
        console.log('登录调用开始');
        return new Promise((resolve, reject) => {
          loginApi(data)
            .then((res) => {
              console.log('登录调用结束');
              const data = res.data
              const tokenName = settingsStore.tokenName
              console.log('tokenName:', tokenName);
              token.value = data[tokenName]
              console.log('token:', token.value);
              resolve()
            })
            .catch((err) => {
              console.log('登录调用异常'+err);
              reject(err)
            })
        })
      }

      // 退出
      function logout () {
        console.log('退出调用开始');
        //删除本地token
        token.value = ''
        
        return new Promise((resolve, reject) => {
          logoutApi()
            .then(() => {
              resolve()
            })
            .catch((err) => {
              reject(err)
            })
        })
      }


      // 返回包含状态和操作的对象
    return {
      token,
      user,
      login,
      logout,
      isLoggedIn
  }

})

//定义返回userStore状态的钩子方法，就不用在store下的index.js 一个一个初始化了
export function useUserStoreHook(){
    return useUserStore();
}
