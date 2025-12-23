<template>
  <div class="register-form">
    <h2>Register</h2>
    <form @submit.prevent="register">
      <input type="text" v-model="name" placeholder="Name" required />
      <input type="email" v-model="email" placeholder="Email" required />
      <input type="password" v-model="password" placeholder="Password" required />
      <input type="password" v-model="password_confirmation" placeholder="Confirm Password" required />
      <button type="submit">Register</button>
    </form>
    <p v-if="error">{{ error }}</p>
    <p v-if="success" class="success">{{ success }}</p>
  </div>
</template>

<script>
export default {
  data() {
    return {
      name: '',
      email: '',
      password: '',
      password_confirmation: '',
      error: '',
      success: ''
    }
  },
  methods: {
    async register() {
      this.error = ''
      this.success = ''
      try {
        
        await this.$axios.get('/sanctum/csrf-cookie')

        
        await this.$axios.post('/api/register', {
          name: this.name,
          email: this.email,
          password: this.password,
          password_confirmation: this.password_confirmation
        })

        this.success = 'Register berhasil! Silakan login.'
        
        
        this.$router.push('/login')

      } catch (err) {
        this.error = 'Register gagal. Cek kembali data yang dimasukkan.'
        console.error(err)
      }
    }
  }
}
</script>

<style>
.register-form {
  max-width: 400px;
  margin: 100px auto;
  background: #fff;
  padding: 2rem;
  border-radius: 8px;
  box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.register-form h2 {
  text-align: center;
  margin-bottom: 1.5rem;
}

.register-form input {
  width: 100%;
  padding: 0.75rem;
  margin-bottom: 1rem;
  border: 1px solid #ccc;
  border-radius: 6px;
}

.register-form button {
  width: 100%;
  padding: 0.75rem;
  background-color: #28a745;
  color: white;
  border: none;
  border-radius: 6px;
  cursor: pointer;
}

.register-form button:hover {
  background-color: #218838;
}

.register-form p {
  text-align: center;
  margin-top: 1rem;
  color: red;
}

.register-form .success {
  color: green;
}
</style>
