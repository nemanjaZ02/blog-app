<script setup>
import { ref, onMounted } from 'vue'
import { usePostsStore } from '../stores/posts'
import { useRouter, useRoute } from 'vue-router'

const postsStore = usePostsStore()
const router = useRouter()
const route = useRoute()

const title = ref('')
const content = ref('')
const error = ref('')

onMounted(async () => {
  await postsStore.fetchPost(route.params.id)
  title.value = postsStore.post.title
  content.value = postsStore.post.content
})

async function handleSubmit() {
  try {
    await postsStore.updatePost(route.params.id, title.value, content.value)
    router.push('/posts/' + route.params.id)
  } catch (e) {
    error.value = 'Failed to update post.'
  }
}
</script>

<template>
  <div class="max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Post</h1>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
      <p v-if="error" class="text-red-500 text-sm mb-4">{{ error }}</p>
      <form @submit.prevent="handleSubmit">
        <div class="mb-5">
          <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
          <input v-model="title" type="text" required
            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-300" />
        </div>
        <div class="mb-6">
          <label class="block text-sm font-medium text-gray-700 mb-1">Content</label>
          <textarea v-model="content" rows="10" required
            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-300"></textarea>
        </div>
        <div class="flex gap-3">
          <button type="submit" class="bg-indigo-600 text-white px-6 py-2.5 rounded-lg hover:bg-indigo-700 font-medium">
            Save Changes
          </button>
          <button type="button" @click="router.back()"
            class="border border-gray-300 text-gray-600 px-6 py-2.5 rounded-lg hover:bg-gray-50">
            Cancel
          </button>
        </div>
      </form>
    </div>
  </div>
</template>