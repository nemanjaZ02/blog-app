import { defineStore } from 'pinia'
import api from '../api/axios'

export const usePostsStore = defineStore('posts', {
    state: () => ({
        posts: [],
        post: null,
        pagination: null,
    }),

    actions: {
        async fetchPosts(page = 1) {
            const response = await api.get(`/posts?page=${page}`)
            this.posts = response.data.data
            this.pagination = response.data
        },

        async fetchPost(id) {
            const response = await api.get(`/posts/${id}`)
            this.post = response.data
        },

        async createPost(title, content) {
            const response = await api.post('/posts', { title, content })
            return response.data
        },

        async updatePost(id, title, content) {
            const response = await api.put(`/posts/${id}`, { title, content })
            return response.data
        },

        async deletePost(id) {
            await api.delete(`/posts/${id}`)
        },

        async addComment(postId, comment, guestName = null) {
            const response = await api.post(`/posts/${postId}/comments`, {
                comment,
                guest_name: guestName,
            })
            return response.data
        },

        async deleteComment(commentId) {
            await api.delete(`/comments/${commentId}`)
        },
    },
})