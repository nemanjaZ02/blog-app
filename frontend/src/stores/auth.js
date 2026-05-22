import { defineStore } from 'pinia'
import api from '../api/axios'

export const useAuthStore = defineStore('auth', {
    state: () => ({
        user: JSON.parse(localStorage.getItem('user')) || null,
        token: localStorage.getItem('token') || null,
    }),

    getters: {
        isLoggedIn: (state) => !!state.token,
        isAdmin: (state) => state.user?.role === 'admin',
    },

    actions: {
        async register(name, email, password, password_confirmation) {
            const response = await api.post('/register', {
                name, email, password, password_confirmation
            })
            this.token = response.data.token
            this.user = response.data.user
            localStorage.setItem('token', this.token)
            localStorage.setItem('user', JSON.stringify(this.user))
        },

        async login(email, password) {
            const response = await api.post('/login', { email, password })
            this.token = response.data.token
            this.user = response.data.user
            localStorage.setItem('token', this.token)
            localStorage.setItem('user', JSON.stringify(this.user))
        },

        async logout() {
			try {
				await api.post('/logout')
			} catch (e) {
				// ignore
			}
			this.token = null
			this.user = null
			localStorage.removeItem('token')
			localStorage.removeItem('user')
		},
    },
})