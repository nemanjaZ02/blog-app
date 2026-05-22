<script setup>
import { ref } from 'vue'
import { useAuthStore } from '../stores/auth'
import { useRouter } from 'vue-router'

const authStore = useAuthStore()
const router = useRouter()

const name = ref('')
const email = ref('')
const password = ref('')
const passwordConfirmation = ref('')
const error = ref('')

async function handleRegister() {
  try {
    await authStore.register(name.value, email.value, password.value, passwordConfirmation.value)
    router.push('/')
  } catch (e) {
    if (e.response?.data?.errors) {
      const errors = e.response.data.errors
      error.value = Object.values(errors).flat().join(', ')
    } else {
      error.value = 'Registration failed. Please try again.'
    }
  }
}
</script>

<template>
  <div class="max-w-md mx-auto mt-16">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
      <h1 class="text-2xl font-bold text-gray-800 mb-6 text-center">Create Account</h1>
      <p v-if="error" class="text-red-500 text-sm mb-4">{{ error }}</p>
      <form @submit.prevent="handleRegister">
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
          <input v-model="name" type="text" required
            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-300" />
        </div>
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
          <input v-model="email" type="email" required
            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-300" />
        </div>
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
          <input v-model="password" type="password" required
            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-300" />
        </div>
        <div class="mb-6">
          <label class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
          <input v-model="passwordConfirmation" type="password" required
            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-300" />
        </div>
        <button type="submit" class="w-full bg-indigo-600 text-white py-2.5 rounded-lg hover:bg-indigo-700 font-medium">
          Create Account
        </button>
      </form>
      <p class="text-center text-sm text-gray-500 mt-6">
        Already have an account?
        <RouterLink to="/login" class="text-indigo-600 hover:underline">Login here</RouterLink>
      </p>
    </div>
  </div>
</template>