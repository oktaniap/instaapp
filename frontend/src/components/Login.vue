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
import { login } from '../auth'
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
            const res = await this.$axios.post('/api/login', {
                email: this.email,
                password: this.password
            })

            login(res.data.token)
            this.$router.push('/home')
        } catch (err) {
            this.error = 'Login gagal'
        }
    }
  }
}
</script>
<style>
    body {
  font-family: Arial, sans-serif;
  background-color: #f0f2f5;
  margin: 0;
  padding: 0;
}

.login-form {
  max-width: 400px;
  margin: 100px auto;
  background: #fff;
  padding: 2rem;
  border-radius: 8px;
  box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.login-form h2 {
  text-align: center;
  margin-bottom: 1.5rem;
}

.login-form input {
  width: 100%;
  padding: 0.75rem;
  margin-bottom: 1rem;
  border: 1px solid #ccc;
  border-radius: 6px;
}

.login-form button {
  width: 100%;
  padding: 0.75rem;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 6px;
  cursor: pointer;
}

.login-form button:hover {
  background-color: #0056b3;
}

.login-form p {
  color: red;
  text-align: center;
}

</style>
