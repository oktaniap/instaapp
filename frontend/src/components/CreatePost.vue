<template>
  <div class="wrapper">
    <form class="card" @submit.prevent="submit">
      <h3>Buat Postingan</h3>

      <textarea
        v-model="content"
        placeholder="Apa yang kamu pikirkan?"
        @input="autoResize"
        ref="textarea"
      ></textarea>

      <!-- PREVIEW GAMBAR -->
      <div v-if="preview" class="preview">
        <img :src="preview" />
      </div>

      <div class="actions">
        <label class="upload">
          📷
          <input type="file" hidden accept="image/*" @change="handleFile" />
        </label>

        <button
          type="submit"
          :disabled="loading || (!content && !image)"
        >
          {{ loading ? 'Posting...' : 'Posting' }}
        </button>
      </div>
    </form>
  </div>

  <!-- POPUP -->
  <div v-if="showPopup" class="popup-overlay">
    <div class="popup">
      <h3>Sukses!</h3>
      <p>Postingan berhasil diupload!</p>
      <button @click="closePopup">OK</button>
    </div>
  </div>
</template>



<script>
export default {
  data() {
    return {
      content: '',
      image: null,
      preview: null, 
      loading: false,
      showPopup: false
    }
  },
  methods: {
    handleFile(e) {
      const file = e.target.files[0]
      if (!file) return

      this.image = file
      this.preview = URL.createObjectURL(file)
    },

    autoResize() {
      const el = this.$refs.textarea
      el.style.height = 'auto'
      el.style.height = el.scrollHeight + 'px'
    },

    async submit() {
      this.loading = true
      try {
        const form = new FormData()
        form.append('content', this.content)
        if (this.image) form.append('image', this.image)

        await this.$axios.post('/api/posts', form)

        this.showPopup = true

        this.content = ''
        this.image = null
        this.preview = null

      } catch (err) {
        alert('Gagal upload postingan!')
        console.error(err)
      } finally {
        this.loading = false
      }
    },

    closePopup() {
      this.showPopup = false
      this.$router.push('/home')
    }
  }
}

</script>

<style scoped>
.wrapper {
  display: flex;
  justify-content: center;
  margin-top: 40px;
}

.card {
  width: 420px;
  background: #fff;
  border: 1px solid #ddd;
  border-radius: 10px;
  padding: 16px;
}

h3 {
  margin-bottom: 12px;
  text-align: center;
}

textarea {
  width: 100%;
  resize: none;
  border: none;
  outline: none;
  font-size: 16px;
  min-height: 80px;
}

.preview {
  margin-top: 12px;
}

.preview img {
  width: 100%;
  border-radius: 8px;
  object-fit: cover;
}

.actions {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-top: 12px;
}

.upload {
  cursor: pointer;
  font-size: 20px;
}

button {
  background: #0095f6;
  color: white;
  border: none;
  padding: 6px 16px;
  border-radius: 6px;
  cursor: pointer;
}

button:disabled {
  background: #b2dffc;
  cursor: not-allowed;
}

.popup-overlay {
  position: fixed;
  inset: 0;
  background: rgba(0,0,0,0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 999;
}

.popup {
  background: #fff;
  padding: 24px;
  border-radius: 10px;
  width: 300px;
  text-align: center;
}

.popup h3 {
  margin-bottom: 8px;
}

.popup button {
  margin-top: 16px;
  padding: 8px 20px;
  border: none;
  background: #4f46e5;
  color: white;
  border-radius: 6px;
  cursor: pointer;
}

</style>
