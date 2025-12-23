<template>
  <div class="container" v-if="post">
    <!-- KIRI : POST -->
    <div class="post-section">
      <img
        v-if="post.image"
        :src="imageUrl(post.image)"
        class="post-image"
      />

      <div class="post-content">
        <h3>{{ post.user.name }}</h3>
        <p class="caption">{{ post.content }}</p>

        <button class="like-btn" @click="toggleLike">
          {{ post.liked_by_me ? '💖' : '🤍' }} {{ post.likes_count }}
        </button>
      </div>
    </div>

    <!-- KANAN : KOMENTAR -->
    <div class="comment-section">
      <div class="comment-header">
        Komentar ({{ comments_count }})
      </div>

      <div class="comments">
        <div v-for="c in comments" :key="c.id" class="comment">
          <strong>{{ c.user.name }}</strong>
          <p>{{ c.content }}</p>
        </div>
      </div>

      <!-- FORM KOMEN -->
      <form @submit.prevent="submitComment" class="comment-form">
        <input
          v-model="newComment"
          placeholder="Tulis komentar..."
        />
        <button type="submit">Kirim</button>
      </form>
    </div>
  </div>

  <p v-else class="loading">Loading...</p>
</template>
<script>
export default {
  data() {
    return {
      post: null,
      comments: [],
      comments_count: 0,
      newComment: ''
    }
  },

  async mounted() {
    await this.fetchPost()
    await this.fetchComments()
  },

  methods: {
    imageUrl(path) {
      return `http://127.0.0.1:8000/storage/${path}`
    },

    async fetchPost() {
      const res = await this.$axios.get(`/api/posts/${this.$route.params.id}`)
      this.post = res.data
    },

    async fetchComments() {
      const res = await this.$axios.get(
        `/api/posts/${this.$route.params.id}/comments`
      )
      this.comments = res.data.comments
      this.comments_count = res.data.comments_count
    },

    async submitComment() {
      if (!this.newComment.trim()) return

      await this.$axios.post(
        `/api/posts/${this.$route.params.id}/comments`,
        { content: this.newComment }
      )

      this.newComment = ''
      await this.fetchComments()
    },

    async toggleLike() {
        try {
            const res = await this.$axios.post(
                `/api/posts/${this.$route.params.id}/like`
            )

            this.post.likes_count = res.data.likes_count
            this.post.liked_by_me = res.data.liked
        } catch (err) {
            console.error(err)
        }
    }

  }
}
</script>
<style scoped>
.container {
  display: flex;
  max-width: 1100px;
  margin: 40px auto;
  border: 1px solid #ddd;
  border-radius: 10px;
  overflow: hidden;
  background: #fff;
}

/* POST */
.post-section {
  width: 55%;
  border-right: 1px solid #eee;
}

.post-image {
  width: 100%;
  height: 500px;
  object-fit: contain;
  background: #000;
}

.post-content {
  padding: 16px;
}

.post-content h3 {
  margin-bottom: 6px;
}

.caption {
  margin-bottom: 12px;
}

.like-btn {
  background: none;
  border: none;
  cursor: pointer;
  font-size: 18px;
}

/* KOMENTAR */
.comment-section {
  width: 45%;
  display: flex;
  flex-direction: column;
}

.comment-header {
  padding: 14px;
  border-bottom: 1px solid #eee;
  font-weight: bold;
}

.comments {
  flex: 1;
  padding: 16px;
  overflow-y: auto;
}

.comment {
  margin-bottom: 14px;
}

.comment p {
  margin: 4px 0 0;
  font-size: 14px;
}

/* FORM KOMEN */
.comment-form {
  display: flex;
  padding: 12px;
  border-top: 1px solid #eee;
}

.comment-form input {
  flex: 1;
  padding: 10px;
  border-radius: 20px;
  border: 1px solid #ccc;
  outline: none;
}

.comment-form button {
  margin-left: 10px;
  padding: 0 18px;
  border-radius: 20px;
  border: none;
  background: #3897f0;
  color: #fff;
  cursor: pointer;
}

.loading {
  text-align: center;
  margin-top: 40px;
}
</style>
