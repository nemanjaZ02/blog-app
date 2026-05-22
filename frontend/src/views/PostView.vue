<script setup>
import { onMounted, ref } from 'vue'
import { usePostsStore } from '../stores/posts'
import { useAuthStore } from '../stores/auth'
import { useRouter, useRoute } from 'vue-router'

const postsStore = usePostsStore()
const authStore = useAuthStore()
const router = useRouter()
const route = useRoute()

const comment = ref('')
const guestName = ref('')
const loading = ref(true)

onMounted(async () => {
  loading.value = true
  postsStore.post = null
  await postsStore.fetchPost(route.params.id)
  loading.value = false
})

async function handleEdit() {
  router.push('/posts/' + postsStore.post.id + '/edit')
}

async function handleDelete() {
  if (confirm('Delete this post?')) {
    await postsStore.deletePost(route.params.id)
    router.push('/')
  }
}

async function handleComment() {
  try {
    await postsStore.addComment(route.params.id, comment.value, guestName.value || null)
    comment.value = ''
    guestName.value = ''
    await postsStore.fetchPost(route.params.id)
  } catch (e) {
    if (e.response?.data?.errors) {
      alert(Object.values(e.response.data.errors).flat().join(', '))
    } else {
      alert('Failed to add comment.')
    }
  }
}

async function handleDeleteComment(commentId) {
  if (confirm('Delete this comment?')) {
    await postsStore.deleteComment(commentId)
    await postsStore.fetchPost(route.params.id)
  }
}

function canEditPost() {
  if (!authStore.isLoggedIn) return false
  if (authStore.isAdmin) return true
  return Number(authStore.user.id) === Number(postsStore.post.user_id)
}

function canDeleteComment(c) {
  if (!authStore.isLoggedIn) return false
  if (authStore.isAdmin) return true
  if (Number(authStore.user.id) === Number(c.user_id)) return true
  if (Number(authStore.user.id) === Number(postsStore.post.user_id)) return true
  return false
}
</script>

<template>
  <div v-if="loading" class="text-center py-16 text-gray-400">
    <p class="text-4xl mb-3">⏳</p>
    <p class="text-lg">Loading...</p>
  </div>

  <div v-else-if="postsStore.post">
    <article class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 mb-8">
      <div class="flex items-start justify-between mb-4">
        <div>
          <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ postsStore.post.title }}</h1>
          <p class="text-gray-500 text-sm">
            By {{ postsStore.post.user.name }} · {{ new Date(postsStore.post.created_at).toLocaleDateString() }}
          </p>
        </div>
        <div v-if="canEditPost()" class="flex gap-2">
          <button @click="handleEdit"
            class="text-sm border border-indigo-300 text-indigo-600 px-3 py-1.5 rounded-lg hover:bg-indigo-50">
            Edit
          </button>
          <button @click="handleDelete"
            class="text-sm border border-red-300 text-red-600 px-3 py-1.5 rounded-lg hover:bg-red-50">
            Delete
          </button>
        </div>
      </div>
      <p class="text-gray-700 leading-relaxed whitespace-pre-wrap">{{ postsStore.post.content }}</p>
    </article>

    <section>
      <h2 class="text-xl font-bold text-gray-800 mb-4">💬 Comments ({{ postsStore.post.comments.length }})</h2>

      <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
        <h3 class="font-semibold text-gray-700 mb-4">Leave a Comment</h3>
        <form @submit.prevent="handleComment">
          <div v-if="!authStore.isLoggedIn" class="mb-3">
            <input v-model="guestName" type="text" placeholder="Your name (optional)"
              class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300" />
          </div>
          <div class="mb-3">
            <textarea v-model="comment" rows="3" placeholder="Write a comment..." required
              class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300"></textarea>
          </div>
          <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-indigo-700">
            Post Comment
          </button>
        </form>
      </div>

      <div v-for="c in postsStore.post.comments" :key="c.id"
        class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 mb-3">
        <div class="flex items-start justify-between">
          <div>
            <span class="font-medium text-gray-800 text-sm">{{ c.user ? c.user.name : (c.guest_name || 'Anonymous') }}</span>
            <span class="text-gray-400 text-xs ml-2">· {{ new Date(c.created_at).toLocaleDateString() }}</span>
            <p class="text-gray-700 text-sm mt-1">{{ c.comment }}</p>
          </div>
          <button v-if="canDeleteComment(c)"
            @click="handleDeleteComment(c.id)"
            class="text-xs text-red-400 hover:text-red-600 ml-3">
            Delete
          </button>
        </div>
      </div>
    </section>

    <div class="mt-6">
      <RouterLink to="/" class="text-sm text-indigo-600 hover:underline">← Back to all posts</RouterLink>
    </div>
  </div>
</template>