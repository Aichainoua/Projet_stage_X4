<script setup>
definePageMeta({ 
  layout: 'apprenant',
  middleware: 'auth'
})

const route = useRoute()
const token = useCookie('token')
const API_URL = 'http://127.0.0.1:8000/api'

// 1. On récupère l'ID de la formation depuis l'URL
const formationId = route.params.id

// 2. On récupère les détails de la formation (y compris la liste des cours/leçons)
const { data: formation, pending, error } = await useFetch(`${API_URL}/formations/${formationId}`, {
  headers: {
    Authorization: `Bearer ${token.value}`
  }
})

// Fonction pour retourner à la liste "Mes formations"
const goBack = () => {
  return navigateTo('/apprenant/formation')
}
</script>

<template>
  <div class="min-h-screen bg-gray-50">
    
    <div v-if="formation" class="mb-8">
        <div class="mb-4">
             <button @click="goBack" class="flex items-center gap-2 text-gray-600 transition hover:text-indigo-700">
                <div class="p-2 bg-white border border-gray-200 rounded-full shadow-sm hover:bg-gray-50">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                </div>
                <span class="text-sm font-medium">Retour à mes formations</span>
            </button>
        </div>

        <h2 class="text-2xl font-bold text-gray-900">{{ formation.titre }}</h2>
        <p class="mt-2 text-gray-500">{{ formation.description }}</p>
    </div>

    <div v-if="pending" class="flex justify-center py-20">
        <div class="w-10 h-10 border-4 border-indigo-900 rounded-full animate-spin border-t-transparent"></div>
    </div>

    <div v-else-if="error || !formation" class="p-6 text-center text-red-600 bg-white border border-red-100 rounded-lg">
        <p>Impossible de charger le contenu de la formation.</p>
    </div>

    <div v-else class="overflow-hidden bg-white border border-gray-200 rounded-lg shadow-sm">
      <table class="w-full text-left border-collapse">
        <thead class="text-xs font-bold text-gray-500 uppercase border-b border-gray-200 bg-gray-50">
          <tr>
            <th class="w-3/4 px-6 py-4">COURS</th>
            
            <th class="w-1/4 px-6 py-4 text-center">Action</th>
          </tr>
        </thead>

        <tbody class="text-sm divide-y divide-gray-100">
            
          <tr v-if="!formation.cours || formation.cours.length === 0">
                <td colspan="2" class="px-6 py-8 italic text-center text-gray-500">
                    Aucune leçon disponible pour cette formation.
                </td>
           </tr>

          <tr v-for="cours in formation.cours" :key="cours.id" class="transition hover:bg-gray-50">
            
            <td class="px-6 py-5 font-medium text-gray-800">
                {{ cours.titre }}
            </td>

            <td class="px-6 py-5 text-center">
              <NuxtLink :to="`/apprenant/lecture/${cours.id}`" title="Accéder au contenu">
                  <svg class="w-6 h-6 mx-auto text-gray-900 transition cursor-pointer hover:text-indigo-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                  </svg>
              </NuxtLink>
            </td>
          </tr>

        </tbody>
      </table>
    </div>

  </div>
</template>