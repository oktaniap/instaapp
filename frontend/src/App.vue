<template>
  <Navbar v-if="auth.loggedIn" />
  <router-view />
</template>

<script>
import Navbar from './components/Navbar.vue'
import { auth } from './auth'

export default {
  components: { Navbar },
  setup() {
    return { auth }
  }
}
</script>
