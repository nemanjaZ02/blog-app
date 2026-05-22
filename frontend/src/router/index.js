import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '../stores/auth'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    { path: '/', component: () => import('../views/HomeView.vue') },
    { path: '/login', component: () => import('../views/LoginView.vue') },
    { path: '/register', component: () => import('../views/RegisterView.vue') },
    { path: '/posts/create', component: () => import('../views/CreatePostView.vue'), meta: { auth: true } },
    { path: '/posts/:id', component: () => import('../views/PostView.vue') },
    { path: '/posts/:id/edit', component: () => import('../views/EditPostView.vue'), meta: { auth: true } },
  ],
})

router.beforeEach((to) => {
  const authStore = useAuthStore()
  if (to.meta.auth && !authStore.isLoggedIn) {
    return '/login'
  }
})

export default router