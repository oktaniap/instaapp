<template>
  <div class="login-form">
    <h2>Login</h2>
    <form @submit.prevent="login">
      <div>
        <input type="email" v-model="email" placeholder="Email" required />
      </div>
      <div>
        <input type="password" v-model="password" placeholder="Password" required />
      </div>
      <button type="submit">Login</button>
    </form>
    <p v-if="error">{{ error }}</p>
  </div>
</template>

<script>
export default {
  data() {
    return {
      email: '',
      password: '',
      error: ''
    }
  },
  methods: {
    async login() {
      try {
        
        await this.$axios.get('http://127.0.0.1:8000/sanctum/csrf-cookie')
        // Login
        await this.$axios.post('/login', {
          email: this.email,
          password: this.password
        })
        alert('Login berhasil!')
        
      } catch (err) {
        this.error = 'Login gagal'
        console.error(err)
      }
    }
  }
}
</script>
