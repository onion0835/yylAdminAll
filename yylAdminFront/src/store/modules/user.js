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

              // 保存用户信息到 store
              console.log('data_member_id:', data['member_id ']);
              console.log('data_avatar_url:', data['avatar_url']);
              console.log('data_nickname:', data['nickname']);
              console.log('data_username:', data['username']);
              console.log('data_roles:', data['roles']);
              console.log('data_menus:', data['menus']);

              user.member_id  = data['member_id ']
              user.avatar_url = data['avatar_url']
              user.nickname = data['nickname']
              user.username = data['username']
              user.roles.value = data['roles']
              user.menus.value = data['menus']
              console.log('user_member_id:', user.member_id);
              console.log('user_avatar_url:', user.avatar_url);
              console.log('user_nickname:', user.nickname);
              console.log('user_username:', user.username);
              console.log('user_roles:', user.roles);
              console.log('user_menus:', user.menus);


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
