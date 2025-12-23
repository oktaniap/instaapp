import { createRouter, createWebHistory } from 'vue-router'
import Login from '../components/Login.vue'
import Home from '../components/Home.vue'
import Register from '../components/Register.vue'
import PostDetail from '../components/PostDetail.vue'
import CreatePost from '../components/CreatePost.vue'
import Profile from '../components/Profile.vue'

const routes = [
  { path: '/', redirect: '/login' },
  { path: '/login', component: Login },
  { path: '/home', component: Home, meta: { requiresAuth: true } },
  { path: '/register', component: Register },
  { path: '/posts/:id', component: PostDetail, meta: { requiresAuth: true } },
  { path: '/create-post', component: CreatePost, meta: { requiresAuth: true } },
  { path: '/profile', component: Profile, meta: { requiresAuth: true } }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

router.beforeEach((to, from, next) => {
  const isLogin = !!localStorage.getItem('token')

  if (to.meta.requiresAuth && !isLogin) {
    next('/login')
  } else if (to.path === '/login' && isLogin) {
    next('/home')
  } else {
    next()
  }
})

export default router
