<template>
  <nav class="navbar">
    <div class="logo" @click="$router.push('/')">
      InstaApp
    </div>

    <div class="menu">
      <router-link to="/home" class="menu-item">🏠 Home</router-link>
      <router-link to="/create-post" class="menu-item">➕ Post</router-link>
      <router-link to="/profile" class="menu-item">👤 Akun</router-link>
      <button class="menu-item logout" @click="logout">⏻ Logout</button>
    </div>
  </nav>
</template>

<script>
import { logout } from '../auth'
export default {
  methods: {
    logout() {
      logout()
      this.$router.push('/login')
    }
  }
}
</script>

<style scoped>
.navbar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 14px 24px;
  border-bottom: 1px solid #ddd;
  background: #fff;
}

.logo {
  font-weight: bold;
  font-size: 20px;
  cursor: pointer;
}

.menu {
  display: flex;
  gap: 16px;
}

.menu-item {
  text-decoration: none;
  color: #333;
  font-weight: 500;
  cursor: pointer;
}

.menu-item:hover {
  color: #0095f6;
}

.logout {
  background: none;
  border: none;
  color: #e53935;
}
</style>
