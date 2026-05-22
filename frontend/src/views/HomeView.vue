<script setup>
import { onMounted, ref } from 'vue'
import { usePostsStore } from '../stores/posts'
import { useRouter } from 'vue-router'

const postsStore = usePostsStore()
const router = useRouter()
const loading = ref(true)

onMounted(async () => {
  loading.value = true
  await postsStore.fetchPosts()
  loading.value = false
})

async function changePage(page) {
  loading.value = true
  await postsStore.fetchPosts(page)
  loading.value = false
  window.scrollTo(0, 0)
}
</script>

<template>
  <div>
    <h1 class="text-2xl font-bold text-gray-800 mb-6">All Posts</h1>

    <div v-if="loading" class="text-center py-16 text-gray-400">
      <p class="text-4xl mb-3">⏳</p>
      <p class="text-lg">Loading posts...</p>
    </div>

    <template v-else>
      <div v-if="postsStore.posts.length === 0" class="text-center py-16 text-gray-400">
        <p class="text-4xl mb-3">📄</p>
        <p class="text-lg">No posts yet.</p>
      </div>

      <article v-for="post in postsStore.posts" :key="post.id"
        class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-4 cursor-pointer hover:shadow-md transition"
        @click="router.push(`/posts/${post.id}`)">
        <h2 class="text-xl font-semibold text-gray-900 mb-1">{{ post.title }}</h2>
        <p class="text-gray-500 text-sm mb-3">
          By {{ post.user.name }} · {{ new Date(post.created_at).toLocaleDateString() }} · 💬 {{ post.comments_count }} comments
        </p>
        <p class="text-gray-600 text-sm">{{ post.content.substring(0, 150) }}...</p>
      </article>

      <div v-if="postsStore.pagination && postsStore.pagination.last_page > 1"
        class="flex justify-center gap-2 mt-6">
        <button
          v-for="page in postsStore.pagination.last_page" :key="page"
          @click="changePage(page)"
          :class="page === postsStore.pagination.current_page
            ? 'bg-indigo-600 text-white'
            : 'bg-white text-gray-600 hover:bg-gray-50 border border-gray-200'"
          class="px-4 py-2 rounded-lg text-sm font-medium">
          {{ page }}
        </button>
      </div>
    </template>
  </div>
</template>