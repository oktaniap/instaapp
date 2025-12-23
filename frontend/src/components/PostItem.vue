<template>
  <div class="post-item">
    <h4>{{ post.user.name }}</h4>
    <p>{{ post.content }}</p>
    <img v-if="post.image" :src="`http://127.0.0.1:8000/storage/${post.image}`" alt="" />
    <div>
      <button @click="toggleLike">{{ liked ? 'Unlike' : 'Like' }} ({{ post.likes_count }})</button>
    </div>
  </div>
</template>

<script>
export default {
  props: ['post'],
  data() {
    return { liked: false }
  },
  methods: {
    async toggleLike() {
      try {
        await this.$axios.post(`/posts/${this.post.id}/like`)
        this.liked = !this.liked
        this.$emit('liked') 
      } catch (err) {
        console.error(err)
      }
    }
  }
}
</script>
