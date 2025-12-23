import { reactive } from 'vue'

export const auth = reactive({
  loggedIn: !!localStorage.getItem('token')
})

export function login(token) {
  localStorage.setItem('token', token)
  auth.loggedIn = true
}

export function logout() {
  localStorage.removeItem('token')
  auth.loggedIn = false
}
