<template>
  <div class="profile">
    <div class="profile-header">
      <img :src="avatar" class="avatar" />
      <h2>{{ user.name }}</h2>
    </div>

    <h3 class="section-title">Postingan Saya</h3>

    <div v-if="loading" class="info">Loading...</div>

    <div v-else-if="posts.length === 0" class="info">
      Belum ada postingan
    </div>

    <div v-else class="grid">
      <div v-for="post in posts" :key="post.id" class="post-card">
        
        <router-link :to="`/posts/${post.id}`">
          <img
            v-if="post.image"
            :src="imageUrl(post.image)"
            class="post-image"
          />
        </router-link>

        <div class="post-body">
          <p>{{ post.content }}</p>

          <button
            class="delete"
            @click="openDelete(post.id)"
          >
            🗑️ Hapus
          </button>
        </div>
      </div>
    </div>

    <div v-if="showConfirmDelete" class="popup-overlay">
      <div class="popup">
        <h3>Hapus Postingan?</h3>
        <p>Postingan ini akan dihapus permanen</p>

        <div class="popup-actions">
          <button class="cancel" @click="showConfirmDelete = false">
            Batal
          </button>
          <button class="danger" @click="confirmDelete">
            Hapus
          </button>
        </div>
      </div>
    </div>

    <div v-if="showSuccessPopup" class="popup-overlay">
      <div class="popup">
        <h3>Sukses!</h3>
        <p>Postingan berhasil dihapus!</p>

        <button class="ok" @click="showSuccessPopup = false">
          OK
        </button>
      </div>
    </div>
  </div>
</template>


<script>
export default {
  data() {
    return {
      user: {},
      posts: [],
      loading: true,

      showConfirmDelete: false,
      showSuccessPopup: false,
      deleteId: null
    }
  },

  computed: {
    avatar() {
      return `https://ui-avatars.com/api/?name=${this.user.name}`
    }
  },

  async mounted() {
    try {
      const userRes = await this.$axios.get('/api/me')
      this.user = userRes.data

      const postsRes = await this.$axios.get('/api/my-posts')
      this.posts = postsRes.data
    } finally {
      this.loading = false
    }
  },

  methods: {
    imageUrl(path) {
      return `http://127.0.0.1:8000/storage/${path}`
    },

    openDelete(id) {
      this.deleteId = id
      this.showConfirmDelete = true
    },

    async confirmDelete() {
      try {
        await this.$axios.delete(`/api/posts/${this.deleteId}`)
        this.posts = this.posts.filter(p => p.id !== this.deleteId)

        this.showConfirmDelete = false
        this.showSuccessPopup = true
      } catch (e) {
        alert('Gagal menghapus postingan')
      }
    }
  }
}

</script>

<style scoped>
.profile {
  max-width: 800px;
  margin: 40px auto;
  padding: 0 16px;
}

.profile-header {
  display: flex;
  align-items: center;
  gap: 16px;
  margin-bottom: 24px;
}

.avatar {
  width: 70px;
  height: 70px;
  border-radius: 50%;
}

.section-title {
  margin-bottom: 12px;
}

.info {
  text-align: center;
  color: #666;
  margin-top: 40px;
}

.grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
  gap: 16px;
}

.post-card {
  border: 1px solid #ddd;
  border-radius: 10px;
  overflow: hidden;
  background: white;
}

.post-image {
  width: 100%;
  height: 200px;
  object-fit: cover;
}

.post-body {
  padding: 10px;
}

.delete {
  margin-top: 8px;
  background: none;
  border: none;
  color: #e11d48;
  cursor: pointer;
}

.popup-overlay {
  position: fixed;
  inset: 0;
  background: rgba(0,0,0,0.5);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 999;
}

.popup {
  background: white;
  padding: 24px;
  border-radius: 12px;
  width: 300px;
  text-align: center;
}

.popup-actions {
  display: flex;
  justify-content: center; 
  gap: 12px;               
  margin-top: 16px;
}

.cancel {
  background: #e5e7eb;
  border: none;
  padding: 8px 16px;
  border-radius: 6px;
  cursor: pointer;
}

.danger {
  background: #e11d48;
  color: white;
  border: none;
  padding: 8px 16px;
  border-radius: 6px;
  cursor: pointer;
}

.ok {
  margin-top: 16px;
  background: #4f46e5;
  color: white;
  border: none;
  padding: 8px 20px;
  border-radius: 6px;
  cursor: pointer;
}

</style>
