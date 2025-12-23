<template>
  <Navbar v-if="isLogin" />
  <router-view />
</template>

<script>
import Navbar from './components/Navbar.vue'

export default {
  components: { Navbar },
  computed: {
    isLogin() {
      return !!localStorage.getItem('token')
    }
  }
}
</script>
