<template>
  <div class="home">
    <h2>Home Feed</h2>

    <div v-if="loading" class="info">Loading posts...</div>
    <div v-else-if="error" class="error">{{ error }}</div>

    <div v-else>
      <div
        v-for="post in posts"
        :key="post.id"
        class="post"
      >
        <strong>{{ post.user.name }}</strong>

        <img
          v-if="post.image"
          :src="imageUrl(post.image)"
          class="post-image"
        />

        <p>{{ post.content }}</p>

        <div class="actions">
            <button class="like-btn" @click="toggleLike(post)">
                {{ post.is_liked ? '💖' : '🤍' }}
                <span>{{ post.likes_count }}</span>
            </button>

            <router-link
                class="comment-btn"
                :to="`/posts/${post.id}`"
            >
                💬 <span>{{ post.comments_count }}</span>
            </router-link>
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
    await this.fetchPosts()
  },

  methods: {
    async fetchPosts() {
      try {
        const res = await this.$axios.get('/api/posts')
        this.posts = res.data
      } catch (e) {
        this.error = 'Gagal memuat post'
      } finally {
        this.loading = false
      }
    },

    async toggleLike(post) {
      try {
        await this.$axios.post(`/api/posts/${post.id}/like`)

        if (post.is_liked) {
          post.likes_count--
          post.is_liked = false
        } else {
          post.likes_count++
          post.is_liked = true
        }
      } catch (err) {
        console.error(err)
      }
    },

    imageUrl(path) {
      return `http://127.0.0.1:8000/storage/${path}`
    }
  }
}
</script>

<style scoped>
.home {
  max-width: 600px;
  margin: 30px auto;
  font-family: Arial, sans-serif;
}

.post {
  background: #fff;
  padding: 15px;
  border-radius: 8px;
  margin-bottom: 20px;
}

.post-image {
  width: 100%;
  border-radius: 6px;
  margin: 10px 0;
}

.actions {
  display: flex;
  align-items: center;
  gap: 14px;
  margin-top: 8px;
}

button {
  border: none;
  background: none;
  cursor: pointer;
  font-size: 16px;
}

button.liked {
  color: red;
  font-weight: bold;
}

.comment-link {
  text-decoration: none;
  color: #555;
}

.info {
  text-align: center;
  color: #777;
}

.error {
  text-align: center;
  color: red;
}

.like-btn,
.comment-btn {
  background: none;
  border: none;
  cursor: pointer;
  font-size: 14px;
  padding: 4px 6px;
  display: flex;
  align-items: center;
  gap: 4px;
  color: #333;
  text-decoration: none;
}

.like-btn:hover,
.comment-btn:hover {
  opacity: 0.7;
}

</style>
