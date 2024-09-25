import defaultSettings from '@/settings'
import Cookies from 'js-cookie';


export function getToken() {
    const storePrefix = defaultSettings.storePrefix
    const tokenName = settingsStore.tokenName
    const token = useStorage(storePrefix + tokenName, '')
  return token;
}



export function removeToken() {
    const storePrefix = defaultSettings.storePrefix
    const tokenName = settingsStore.tokenName
    const token = useStorage(storePrefix + tokenName, '')   
  return Cookies.remove(TokenKey);
}