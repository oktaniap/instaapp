<template>
  <div>
    <h2>Posts</h2>
    <CreatePost @posted="fetchPosts" />
    <div v-for="post in posts" :key="post.id">
      <PostItem :post="post" @liked="fetchPosts" />
    </div>
  </div>
</template>

<script>
import PostItem from './PostItem.vue'
import CreatePost from './CreatePost.vue'

export default {
  components: { PostItem, CreatePost },
  data() {
    return { posts: [] }
  },
  mounted() {
    this.fetchPosts()
  },
  methods: {
    async fetchPosts() {
      try {
        const res = await this.$axios.get('/posts')
        this.posts = res.data
      } catch (err) {
        console.error(err)
      }
    }
  }
}
</script>
