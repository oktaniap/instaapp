<template>
  <div class="max-w-2xl mx-auto mt-10">
    <h1 class="text-3xl font-bold mb-6">Home Feed</h1>

    <div v-if="loading" class="text-center text-gray-500">Loading posts...</div>
    <div v-else-if="error" class="text-center text-red-500">{{ error }}</div>

    <div v-else class="space-y-6">
      <div v-for="post in posts" :key="post.id" class="bg-white p-4 rounded shadow">
        <img v-if="post.image" :src="post.image" class="w-full h-64 object-cover rounded mb-4" />
        <p>{{ post.content }}</p>
        <div class="mt-2 flex space-x-4 text-gray-600">
          <span>❤️ {{ post.likes || 0 }}</span>
          <span>💬 {{ post.comments || 0 }}</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      posts: [],
      loading: true,
      error: ''
    }
  },
  async mounted() {
    try {
      const response = await this.$axios.get('/api/posts')
      console.log('response', response)
      
      
      this.posts = response.data.map(post => ({
        ...post,
        image: post.image ? `http://127.0.0.1:8000/storage/${post.image}` : null
      }))
    } catch (err) {
      this.error = 'Gagal memuat postingan'
      console.error(err)
    } finally {
      this.loading = false
    }
  }
}
</script>


