<template>
  <div class="profile">
    <h2>{{ user.name }}</h2>
    <p>{{ user.email }}</p>
  </div>
</template>

<script>
export default {
  data() {
    return {
      user: {}
    }
  },
  async mounted() {
    const res = await this.$axios.get('/api/me')
    this.user = res.data
  }
}
</script>

<style scoped>
.profile {
  max-width: 400px;
  margin: 40px auto;
  text-align: center;
}
</style>
