<template>
  <div class="home">
    <div v-if="loading" class="info">Loading posts...</div>
    <div v-else-if="error" class="error">{{ error }}</div>

    <div v-else>
      <div
        v-for="post in posts"
        :key="post.id"
        class="post-card"
      >
        <div class="post-header">
          <div class="avatar">{{ initials(post.user.name) }}</div>
          <strong>{{ post.user.name }}</strong>
        </div>

        <div class="image-wrapper" v-if="post.image">
          <img :src="imageUrl(post.image)" />
        </div>

        <p class="post-content">{{ post.content }}</p>

        <div class="actions">
          <button class="like-btn" @click="toggleLike(post)">
            {{ post.is_liked ? '💖' : '🤍' }} {{ post.likes_count }}
          </button>
          <router-link class="comment-btn" :to="`/posts/${post.id}`">
            💬 {{ post.comments_count }}
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

    initials(name) {
      return name
        .split(' ')
        .map(n => n[0])
        .join('')
        .toUpperCase()
    }
  }
}
</script>

<style scoped>
.home {
  max-width: 600px;
  margin: 30px auto;
  font-family: 'Inter', sans-serif;
}

.post-card {
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 2px 6px rgba(0,0,0,0.08);
  padding: 14px;
  margin-bottom: 20px;
  transition: transform 0.2s, box-shadow 0.2s;
}
.post-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 10px rgba(0,0,0,0.12);
}

.post-header {
  display: flex;
  align-items: center;
  gap: 12px;
  margin-bottom: 10px;
}

.avatar {
  width: 36px;
  height: 36px;
  border-radius: 50%;
  background: #ddd;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 600;
  color: #555;
  font-size: 14px;
}

.image-wrapper img {
  width: 100%;
  height: 500px; 
  max-width: 100%;
  max-height: 100%;
  object-fit: contain;
  border-radius: 8px;
  margin-bottom: 10px;
}

.post-content {
  font-size: 15px;
  margin-bottom: 10px;
}

.actions {
  display: flex;
  align-items: center;
  gap: 14px;
}

button.like-btn,
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
button.like-btn:hover,
.comment-btn:hover {
  opacity: 0.7;
}

.info {
  text-align: center;
  color: #777;
}

.error {
  text-align: center;
  color: red;
}
</style>
