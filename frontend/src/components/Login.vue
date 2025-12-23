<template>
  <div class="login-form">
    <h2>Login</h2>
    <form @submit.prevent="login">
        <input type="email" v-model="email" placeholder="Email" required />
        <input type="password" v-model="password" placeholder="Password" required />
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
        await this.$axios.get('/sanctum/csrf-cookie')
        await this.$axios.post('/api/login', {
          email: this.email,
          password: this.password
        })
        this.$router.push('/home')
      } catch (err) {
        this.error = 'Login gagal'
        console.error(err)
      }
    }
  }
}
</script>
