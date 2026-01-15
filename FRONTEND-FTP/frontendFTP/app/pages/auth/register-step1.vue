<template>
  <div class="flex items-center justify-center min-h-screen p-4 bg-gray-50">
    <div class="w-full max-w-md p-8 bg-white rounded-lg shadow-lg">
      <div class="flex items-center gap-3 mb-6">
        <div class="flex items-center justify-center w-12 h-12 bg-indigo-700 rounded-lg">
          <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
          </svg>
        </div>
        <h1 class="text-2xl font-bold text-gray-800">EDULAB AFRIK</h1>
      </div>

      <h2 class="mb-4 text-lg font-semibold text-gray-700">Créer un compte</h2>

      <div class="flex gap-2 mb-6">
        <button 
          class="flex-1 px-4 py-2 font-medium text-white bg-indigo-700 rounded-lg shadow-sm cursor-default"
        >
          APPRENANT
        </button>

        <button 
          @click="navigateTo('/auth/register-formateur-step1')"
          class="flex-1 px-4 py-2 font-medium text-gray-700 transition bg-gray-100 rounded-lg hover:bg-gray-200 hover:text-indigo-700"
        >
          FORMATEUR
        </button>
      </div>
      
      <p class="mb-6 text-xs text-gray-500">
        Remplir les coordonnées pour commencer l'inscription en tant qu'apprenant
      </p>

      <form @submit.prevent="handleRegister" class="space-y-4">
        <div>
          <label class="block mb-1 text-sm font-medium text-gray-700">Nom</label>
          <input v-model="form.nom" type="text" placeholder="Nom de famille" class="w-full px-4 py-2.5 bg-gray-100 border-0 rounded-lg focus:ring-2 focus:ring-indigo-700 focus:bg-white transition text-sm" required />
        </div>
        <div>
          <label class="block mb-1 text-sm font-medium text-gray-700">Prénom</label>
          <input v-model="form.prenom" type="text" placeholder="Prénom" class="w-full px-4 py-2.5 bg-gray-100 border-0 rounded-lg focus:ring-2 focus:ring-indigo-700 focus:bg-white transition text-sm" required />
        </div>
        <div>
          <label class="block mb-1 text-sm font-medium text-gray-700">Email</label>
          <input v-model="form.email" type="email" placeholder="exemple@email.com" class="w-full px-4 py-2.5 bg-gray-100 border-0 rounded-lg focus:ring-2 focus:ring-indigo-700 focus:bg-white transition text-sm" required />
        </div>
        <div>
          <label class="block mb-1 text-sm font-medium text-gray-700">Mot de passe</label>
          <input v-model="form.password" type="password" placeholder="Minimum 8 caractères" class="w-full px-4 py-2.5 bg-gray-100 border-0 rounded-lg focus:ring-2 focus:ring-indigo-700 focus:bg-white transition text-sm" required minlength="8" />
        </div>
        <div>
          <label class="block mb-1 text-sm font-medium text-gray-700">Confirmer le mot de passe</label>
          <input v-model="form.confirmPassword" type="password" placeholder="Répétez le mot de passe" class="w-full px-4 py-2.5 bg-gray-100 border-0 rounded-lg focus:ring-2 focus:ring-indigo-700 focus:bg-white transition text-sm" required />
        </div>
        
        <div v-if="error" class="p-3 text-sm text-red-700 whitespace-pre-line border border-red-200 rounded-lg bg-red-50">
          {{ error }}
        </div>
        
        <button type="submit" :disabled="loading" class="w-full py-3 mt-6 font-semibold text-white transition duration-200 bg-indigo-700 rounded-lg hover:bg-indigo-800 disabled:opacity-50 disabled:cursor-not-allowed">
          {{ loading ? 'Création en cours...' : 'Créer mon compte' }}
        </button>
      </form>

      <p class="mt-6 text-sm text-center text-gray-600">
        Vous avez déjà un compte? 
        <NuxtLink to="/auth/user-login" class="font-medium text-indigo-700 hover:text-indigo-900">Se connecter</NuxtLink>
      </p>
    </div>
  </div>
</template>

<script setup>
const loading = ref(false)
const error = ref('')

const form = ref({
  nom: '',
  prenom: '',
  email: '',
  password: '',
  confirmPassword: ''
})

const handleRegister = async () => {
  error.value = ''

  if (!form.value.nom || !form.value.prenom || !form.value.email || !form.value.password) {
    error.value = 'Veuillez remplir tous les champs'
    return
  }

  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
  if (!emailRegex.test(form.value.email)) {
    error.value = 'Veuillez entrer une adresse email valide'
    return
  }

  if (form.value.password !== form.value.confirmPassword) {
    error.value = 'Les mots de passe ne correspondent pas'
    return
  }

  if (form.value.password.length < 8) {
    error.value = 'Le mot de passe doit contenir au moins 8 caractères'
    return
  }

  loading.value = true

  try {
    const response = await $fetch('http://localhost:8000/api/auth/register/apprenant', {
        method: 'POST',
        body: {
            nom: form.value.nom,
            prenom: form.value.prenom,
            email: form.value.email,
            password: form.value.password
        }
    })

    const token = useCookie('token')
    const user = useCookie('user')
    
    token.value = response.access_token
    user.value = response.user

    await navigateTo('/Apprenant/catalogue')

  } catch (err) {
    console.error('Erreur inscription:', err)
    
    if (err.response?._data?.errors) {
        const errors = Object.values(err.response._data.errors).flat().join('\n')
        error.value = errors
    } else if (err.response?._data?.message) {
        error.value = err.response._data.message
    } else {
        error.value = "Une erreur est survenue lors de la connexion au serveur."
    }
  } finally {
    loading.value = false
  }
}
</script>