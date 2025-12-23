import { createRouter, createWebHistory } from 'vue-router'
import Login from '../components/Login.vue'
import Home from '../components/Home.vue'
import Register from '../components/Register.vue'
import PostDetail from '../components/PostDetail.vue'

const routes = [
  { path: '/', redirect: '/login' },
  { path: '/login', component: Login },
  { path: '/home', component: Home },
  { path: '/register', component: Register },
  { path: '/posts/:id', component: PostDetail }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
