import { defineStore } from 'pinia';
import { store } from '@/store'
import { useStorage } from '@vueuse/core'
import { useSettingsStore } from '@/store/modules/settings'
import { login as loginApi, logout as logoutApi } from '@/api/system/login'
import { info as userInfoApi } from '@/api/system/user-center'
import defaultSettings from '@/settings'

export const useUserStore = defineStore('user',()=>{
    const settingsStore = useSettingsStore()
    const storePrefix = defaultSettings.storePrefix
    const tokenName = settingsStore.tokenName
    const token = useStorage(storePrefix + tokenName, '')

})

//定义返回userStore状态的钩子方法，就不用在store下的index.js 一个一个初始化了
export function useUserStoreHook(){
    return useUserStore();
}
