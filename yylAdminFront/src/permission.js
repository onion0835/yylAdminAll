import router from './router/index'
import { useUserStore } from '@/store/modules/user'
import NProgress from 'nprogress'
//import 'nprogress/nprogress.css'

NProgress.configure({ showSpinner: false })

const whiteList = ['/login', '/'] // 不登陆也能访问的页面

router.beforeEach(async(to, from, next) => {
  NProgress.start()

  const userStore = useUserStore()
  console.log('userStore:', userStore.isLoggedIn);

  if (userStore.isLoggedIn) {
    if (to.path === '/login') {
      next({ path: '/' })
      NProgress.done()
    } else {
      /*
      const hasRoles = store.getters.roles && store.getters.roles.length > 0
      if (hasRoles) {
        next()
      } else {
        try {
          const { roles } = await store.dispatch('user/getInfo')
          const accessRoutes = await store.dispatch('permission/generateRoutes', roles)
          router.addRoutes(accessRoutes)
          next({ ...to, replace: true })
        } catch (error) {
          await store.dispatch('user/resetToken')
          Message.error(error || 'Has Error')
          next(`/login?redirect=${to.path}`)
          NProgress.done()
        }
      }
        */
       //先不动态生成路由，使用静态路由
       next()
    }
  } else {
    if (whiteList.indexOf(to.path) !== -1) {
      next()
    } else {
      next(`/login?redirect=${to.path}`)
      NProgress.done()
    }
  }
})

router.afterEach(() => {
  NProgress.done()
})