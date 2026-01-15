<script setup>
definePageMeta({ 
  layout: 'apprenant',
  middleware: 'auth'
})

const router = useRouter()
const token = useCookie('token')
const API_URL = 'http://127.0.0.1:8000/api'

// On récupère les formations
const { data: formations, pending, error } = await useFetch(`${API_URL}/mes-formations`, {
  headers: { Authorization: `Bearer ${token.value}` },
  // Extraction propre des données
  transform: (response) => response.data || response
})

const formatPrice = (price) => new Intl.NumberFormat('fr-FR').format(price) + ' FCFA'
const goBack = () => router.back()
</script>

<template>
  <div>
    <div class="flex items-center gap-4 mb-6">
        <button @click="goBack" class="p-2 text-gray-500 transition bg-white border border-gray-200 rounded-full hover:bg-gray-50 hover:text-indigo-700">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </button>
        <h2 class="text-xl font-bold text-gray-900">Mes formations</h2>
    </div>

    <div v-if="pending" class="flex justify-center py-10">
        <div class="w-8 h-8 border-4 border-indigo-900 rounded-full animate-spin border-t-transparent"></div>
    </div>

    <div v-else-if="!formations || formations.length === 0" class="p-8 text-center bg-white border border-dashed rounded-lg">
        <p class="text-gray-500">Vous n'avez pas encore de formations.</p>
        <NuxtLink to="/apprenant/catalogue" class="inline-block mt-4 text-indigo-700 hover:underline">Aller au catalogue</NuxtLink>
    </div>

    <div v-else class="overflow-hidden bg-white border border-gray-200 rounded-lg shadow-sm">
      <table class="w-full text-left border-collapse">
        <thead class="text-xs font-bold text-gray-500 uppercase border-b border-gray-200 bg-gray-50">
          <tr>
            <th class="px-6 py-4">Formation</th>
            <th class="px-6 py-4">Formateur</th>
            <th class="px-6 py-4">Prix</th>
            <th class="px-6 py-4 text-center">Action</th>
          </tr>
        </thead>
        <tbody class="text-sm divide-y divide-gray-100">
          <tr v-for="formation in formations" :key="formation.id" class="transition hover:bg-gray-50">
            
            <td class="px-6 py-4 font-bold text-gray-800 uppercase">
                {{ formation.titre }}
            </td>

            <td class="px-6 py-4 font-medium text-gray-600 capitalize">
                <div class="flex items-center gap-2">
                    <div class="flex items-center justify-center w-6 h-6 text-xs text-white bg-indigo-300 rounded-full">
                        {{ formation.user?.prenom?.charAt(0) || 'F' }}
                    </div>
                    {{ formation.user ? formation.user.prenom + ' ' + formation.user.nom : 'Inconnu' }}
                </div>
            </td>
            
            <td class="px-6 py-4 font-mono text-gray-600">
                {{ formatPrice(formation.prix) }}
            </td>
            
            <td class="px-6 py-4 text-center">
              <NuxtLink 
                :to="`/apprenant/formation/${formation.id}`" 
                class="inline-flex items-center justify-center p-2 text-indigo-900 transition rounded-full bg-indigo-50 hover:bg-indigo-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
              </NuxtLink>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>