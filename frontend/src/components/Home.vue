<template>
  <div class="home">

    <div v-if="loading" class="info">Loading posts...</div>
    <div v-else-if="error" class="error">{{ error }}</div>

    <div v-else>
      <div
        v-for="post in posts"
        :key="post.id"
        class="post"
      >
        <div class="post-header">
            <img
            :src="avatarUrl(post.user.name)"
            class="avatar"
            />
            <strong>{{ post.user.name }}</strong>
        </div>

        <div class="image-wrapper">
            <img
                v-if="post.image"
                :src="imageUrl(post.image)"
                class="post-image"
            />
        </div>

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
    },

    avatarUrl(name) {
        return `https://ui-avatars.com/api/?name=${encodeURIComponent(name)}&background=random&color=fff`
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

.image-wrapper {
  width: 100%;
  height: 500px; 
  background: black;
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
}

.post-image {
  max-width: 100%;
  max-height: 100%;
  object-fit: contain;
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

.post-header {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 10px;
}

.avatar {
  width: 36px;
  height: 36px;
  border-radius: 50%;
}

.content {
  margin: 10px 0;
}

</style>
