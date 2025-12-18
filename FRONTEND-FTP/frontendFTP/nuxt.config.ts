import { defineNuxtConfig } from 'nuxt/config'

export default defineNuxtConfig({
  modules: ['@nuxtjs/tailwindcss'],
  css: ['~/assets/css/main.css'],
  
  runtimeConfig: {
    public: {
      apiBase: process.env.API_BASE_URL || 'http://localhost:8000/api'
    }
  },

  devServer: {
    port: 3000
  },

  // Forcer l'auto-import des composables
  imports: {
    dirs: [
      'composables',
      'composables/**'
    ]
  }
})
