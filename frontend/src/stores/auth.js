import { defineStore } from 'pinia'
import api, { getCsrfCookie } from '../api/axios'

export const useAuthStore = defineStore('auth', {
    state: () => ({
        user: null,
    }),

    getters: {
        isLoggedIn: (state) => !!state.user,
        isAdmin: (state) => state.user?.role === 'admin',
    },

    actions: {
        async initAuth() {
            try {
                const response = await api.get('/me')
                this.user = response.data
            } catch {
                this.user = null
            }
        },

        async register(name, email, password, password_confirmation) {
            await getCsrfCookie()
            const response = await api.post('/register', {
                name, email, password, password_confirmation,
            })
            this.user = response.data.user
        },

        async login(email, password) {
            await getCsrfCookie()
            const response = await api.post('/login', { email, password })
            this.user = response.data.user
        },

        async logout() {
            try {
                await api.post('/logout')
            } catch {
                // ignore
            }
            this.user = null
        },
    },
})
