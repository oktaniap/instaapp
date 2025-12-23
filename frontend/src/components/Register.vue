<template>
  <div class="register-wrapper">
    <div class="register-form">
      <h2>InstaApp</h2>
      <p>Buat akun baru</p>

      <form @submit.prevent="register">
        <input type="text" v-model="name" placeholder="Name" required />
        <input type="email" v-model="email" placeholder="Email" required />
        <input type="password" v-model="password" placeholder="Password" required />
        <input type="password" v-model="password_confirmation" placeholder="Confirm Password" required />

        <button type="submit">Register</button>
      </form>

      <p v-if="error" class="error">{{ error }}</p>

      <div class="divider"></div>

      <p class="login-text">
        Sudah punya akun?
        <router-link to="/login">Login</router-link>
      </p>
    </div>

    <div v-if="showPopup" class="popup-overlay">
      <div class="popup">
        <h3>Sukses!</h3>
        <p>Akun berhasil dibuat!</p>
        <button @click="goLogin">OK</button>
      </div>
    </div>
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
      showPopup: false
    }
  },
  methods: {
    async register() {
      this.error = ''
      try {
        await this.$axios.get('/sanctum/csrf-cookie') // CSRF

        await this.$axios.post('/api/register', {
          name: this.name,
          email: this.email,
          password: this.password,
          password_confirmation: this.password_confirmation
        })

        this.showPopup = true

      } catch (err) {
        this.error = 'Register gagal. Cek kembali data yang dimasukkan.'
        console.error(err)
      }
    },
    goLogin() {
      this.showPopup = false
      this.$router.push('/login')
    }
  }
}
</script>

<style scoped>
.register-wrapper {
  position: relative;
  font-family: Arial, sans-serif;
}

.register-form {
  max-width: 400px;
  margin: 100px auto;
  background: #fff;
  padding: 2rem;
  border-radius: 8px;
  box-shadow: 0 4px 6px rgba(0,0,0,0.1);
  text-align: center;
}

.register-form h2 {
  margin-bottom: 0.5rem;
}

.register-form p {
  margin-bottom: 1.5rem;
  color: #555;
}

.register-form input {
  width: 100%;
  padding: 12px;
  margin-bottom: 1rem;
  border: 1px solid #ccc;
  border-radius: 6px;
  box-sizing: border-box;
}

.register-form button {
  width: 100%;
  padding: 12px;
  background-color: #28a745;
  color: white;
  border: none;
  border-radius: 6px;
  cursor: pointer;
}

.register-form button:hover {
  background-color: #218838;
}

.register-form .error {
  color: red;
  margin-top: 1rem;
}

.register-form .divider {
  height: 1px;
  background: #ddd;
  margin: 1.5rem 0;
}

.register-form .login-text {
  color: #555;
}

.register-form .login-text a {
  color: #007bff;
  text-decoration: none;
}

.register-form .login-text a:hover {
  text-decoration: underline;
}

.popup-overlay {
  position: fixed;
  inset: 0;
  background: rgba(0,0,0,0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 999;
}

.popup {
  background: white;
  padding: 24px;
  border-radius: 12px;
  width: 300px;
  text-align: center;
}

.popup h3 {
  margin-bottom: 12px;
}

.popup button {
  margin-top: 12px;
  padding: 8px 20px;
  border: none;
  background: #28a745;
  color: white;
  border-radius: 6px;
  cursor: pointer;
}

.popup button:hover {
  opacity: 0.9;
}
</style>
