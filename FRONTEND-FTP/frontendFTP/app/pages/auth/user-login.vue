<template>
  <div class="flex items-center justify-center min-h-screen p-4 bg-gray-50">
    <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-lg sm:p-8">
      
      <div class="flex items-center gap-3 mb-6 sm:mb-8">
        <div class="flex items-center justify-center w-10 h-10 bg-indigo-700 rounded-lg shrink-0 sm:w-12 sm:h-12">
          <svg class="w-6 h-6 text-white sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
          </svg>
        </div>
        <h1 class="text-xl font-bold text-gray-800 sm:text-2xl">EDULAB AFRIK</h1>
      </div>

      <h2 class="mb-4 text-xl font-semibold text-gray-700 sm:mb-6">Connexion</h2>
      <p class="mb-6 text-sm text-gray-600">Connectez-vous à votre compte pour continuer</p>

      <form @submit.prevent="handleLogin" class="space-y-5">
        <div>
          <label for="email" class="block mb-2 text-sm font-medium text-gray-700">Email</label>
          <input
            id="email"
            v-model="form.email"
            type="email"
            placeholder="votre@email.com"
            class="w-full px-4 py-3 transition bg-gray-100 border-0 rounded-lg focus:ring-2 focus:ring-indigo-700 focus:bg-white"
            required
          />
        </div>

        <div>
          <label for="password" class="block mb-2 text-sm font-medium text-gray-700">Mot de passe</label>
          <div class="relative">
            <input
              id="password"
              v-model="form.password"
              :type="showPassword ? 'text' : 'password'"
              placeholder="••••••••"
              class="w-full px-4 py-3 pr-10 transition bg-gray-100 border-0 rounded-lg focus:ring-2 focus:ring-indigo-700 focus:bg-white"
              required
            />
            <button 
              type="button" 
              @click="showPassword = !showPassword"
              class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 hover:text-indigo-700 focus:outline-none"
            >
              <svg v-if="showPassword" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
              </svg>
              <svg v-else class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 011.574-2.59M7 9l5.5 5.5m0 0l4 4m-4-4l-5-5m0 0l-5-5m19.5 19.5L5 5" />
              </svg>
            </button>
          </div>
        </div>

        <div class="flex flex-col gap-3 text-sm sm:flex-row sm:items-center sm:justify-between sm:gap-0">
          <div class="flex items-center">
            <input 
              id="remember-me" 
              type="checkbox" 
              v-model="form.rememberMe"
              class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
            >
            <label for="remember-me" class="ml-2 text-gray-600 cursor-pointer select-none hover:text-indigo-700">
              Se souvenir de moi
            </label>
          </div>
          <a href="#" class="font-medium text-indigo-700 hover:text-indigo-900">Mot de passe oublié ?</a>
        </div>

        <div v-if="error" class="flex items-start gap-2 p-3 text-sm text-red-700 border border-red-200 rounded-lg bg-red-50">
           <svg class="w-5 h-5 text-red-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
           </svg>
           <span>{{ error }}</span>
        </div>

        <button
          type="submit"
          :disabled="loading"
          class="flex items-center justify-center w-full py-3 font-semibold text-white transition duration-200 bg-indigo-700 rounded-lg hover:bg-indigo-800 disabled:bg-indigo-400 disabled:cursor-not-allowed"
        >
          <span v-if="loading" class="flex items-center gap-2">
            <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Connexion...
          </span>
          <span v-else>Se connecter</span>
        </button>
      </form>

      <p class="mt-6 text-sm text-center text-gray-600">
        Vous n'avez pas de compte ? 
        <NuxtLink to="/auth/register-step1" class="font-medium text-indigo-700 hover:text-indigo-900">S'inscrire</NuxtLink>
      </p>
    </div>
  </div>
</template>

<script setup>
import { reactive, ref } from 'vue'

const form = reactive({
  email: '',
  password: '',
  rememberMe: false
})

const showPassword = ref(false)
const loading = ref(false)
const error = ref('')

// Configuration des cookies (On garde ça pour les bonnes pratiques Nuxt)
const tokenCookie = useCookie('token', { maxAge: 60 * 60 * 24 * 7 }) 
const userCookie = useCookie('user', { maxAge: 60 * 60 * 24 * 7 })

const handleLogin = async () => {
  error.value = ''
  
  if (!form.email || !form.password) {
    error.value = 'Veuillez remplir tous les champs'
    return
  }

  loading.value = true

  try {
    const response = await $fetch('http://127.0.0.1:8000/api/auth/login', {
      method: 'POST',
      headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json'
      },
      body: { 
        email: form.email.trim().toLowerCase(),
        password: form.password
      }
    })

    // --- CORRECTION CRUCIALE ICI ---
    
    // 1. On sécurise le nom du token (Laravel renvoie souvent 'access_token' ou 'token')
    const token = response.access_token || response.token

    if (!token) {
        throw new Error("Token non reçu du serveur")
    }

    // 2. On sauvegarde dans le COOKIE (pour Nuxt)
    tokenCookie.value = token
    userCookie.value = response.user

    // 3. On sauvegarde AUSSI dans le LOCALSTORAGE (Pour que ta page Formation fonctionne)
    if (process.client) {
        localStorage.setItem('token', token)
        localStorage.setItem('user', JSON.stringify(response.user))
    }

    // --- GESTION REDIRECTION ---
    const role = response.role || (response.user ? response.user.role : 'apprenant')
    
    let redirectPath = '/apprenant/catalogue'
    
    if (role === 'formateur') {
        // Correction : pas besoin de '/index' à la fin
        redirectPath = '/formateur/formations' 
    } else if (role === 'admin') {
        redirectPath = '/admin/dashboard'
    }

    console.log("Login réussi ! Token sauvegardé. Redirection vers :", redirectPath)
    await navigateTo(redirectPath)

  } catch (err) {
    console.error('Erreur login:', err)
    if (err.response && err.response._data) {
        // Affiche le message précis envoyé par Laravel
        error.value = err.response._data.message || 'Identifiants incorrects.'
    } else {
        error.value = "Impossible de contacter le serveur."
    }
  } finally {
    loading.value = false
  }
}
</script>