<script setup>
import { useAuthStore } from '../stores/auth'
import { useRouter } from 'vue-router'

const authStore = useAuthStore()
const router = useRouter()

async function handleLogout() {
  await authStore.logout()
  router.push('/login')
}
</script>

<template>
  <nav class="bg-white shadow-sm border-b border-gray-200">
    <div class="max-w-4xl mx-auto px-4 py-3 flex items-center justify-between">
      <RouterLink to="/" class="text-xl font-bold text-indigo-600">📝 Blog App</RouterLink>

      <div class="flex items-center gap-4">
        <template v-if="authStore.isLoggedIn">
          <span class="text-sm text-gray-500">Hello, {{ authStore.user?.name }}</span>
          <RouterLink to="/posts/create" class="text-sm bg-indigo-600 text-white px-3 py-1.5 rounded-lg hover:bg-indigo-700">
            + New Post
          </RouterLink>
          <button @click="handleLogout" class="text-sm text-gray-600 hover:text-red-600">
            Logout
          </button>
        </template>
        <template v-else>
          <RouterLink to="/login" class="text-sm text-gray-600 hover:text-indigo-600">Login</RouterLink>
          <RouterLink to="/register" class="text-sm bg-indigo-600 text-white px-3 py-1.5 rounded-lg hover:bg-indigo-700">
            Register
          </RouterLink>
        </template>
      </div>
    </div>
  </nav>
</template>