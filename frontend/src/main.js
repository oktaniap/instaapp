import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import axios from 'axios'
import './style.css'

const app = createApp(App)

app.config.globalProperties.$axios = axios
axios.defaults.baseURL = 'http://127.0.0.1:8000'
axios.defaults.withCredentials = true

app.use(router)
app.mount('#app')
