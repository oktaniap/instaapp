<template>
  <div class="create-post">
    <form @submit.prevent="submitPost">
      <textarea v-model="content" placeholder="Write something..."></textarea>
      <input type="file" @change="handleFile" />
      <button type="submit">Post</button>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return { content: '', file: null }
  },
  methods: {
    handleFile(e) {
      this.file = e.target.files[0]
    },
    async submitPost() {
      try {
        const formData = new FormData()
        formData.append('content', this.content)
        if (this.file) formData.append('image', this.file)
        await this.$axios.post('/posts', formData, {
          headers: { 'Content-Type': 'multipart/form-data' }
        })
        this.content = ''
        this.file = null
        this.$emit('posted')
      } catch (err) {
        console.error(err)
      }
    }
  }
}
</script>
