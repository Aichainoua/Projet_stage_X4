<script setup>
definePageMeta({ 
  layout: 'apprenant',
  middleware: 'auth'
})

const route = useRoute()
const router = useRouter() // ✅ On récupère le routeur pour faire "Précédent"
const token = useCookie('token')
const API_URL = 'http://127.0.0.1:8000/api'

const showPayment = ref(false)
const processingPayment = ref(false)

// 1. Récupération des détails
const { data: course, pending } = await useFetch(`${API_URL}/formations/${route.params.id}`, {
    headers: { 'Authorization': `Bearer ${token.value}` }
})

const formatPrice = (price) => new Intl.NumberFormat('fr-FR').format(price) + ' FCFA'

// 2. Logique de Paiement
const handlePayment = async (method) => {
    processingPayment.value = true
    try {
        await $fetch(`${API_URL}/inscriptions`, {
            method: 'POST',
            headers: { 
                'Authorization': `Bearer ${token.value}`,
                'Accept': 'application/json'
            },
            body: {
                formation_id: course.value.id,
                moyen_paiement: method
            }
        })
        alert('Paiement réussi ! Vous avez accès au cours.')
        showPayment.value = false
        location.reload() 
    } catch (e) {
        alert("Erreur lors du paiement")
    } finally {
        processingPayment.value = false
    }
}
</script>

<template>
  <div class="flex flex-col items-center justify-center p-4">
    
    <div class="w-full max-w-md mb-4">
        <button @click="router.back()" class="flex items-center gap-2 text-sm font-medium text-gray-500 transition hover:text-indigo-900">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Retour au catalogue
        </button>
    </div>

    <div v-if="pending" class="py-20 text-indigo-900">Chargement...</div>

    <div v-else-if="course" class="relative w-full max-w-md overflow-hidden bg-white border border-gray-100 shadow-lg rounded-2xl">
    
      <div class="flex items-center justify-center p-8 bg-indigo-900">
         <svg class="w-24 h-24 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
      </div>

      <div class="p-6">
        <div class="flex items-start justify-between mb-2">
          <span class="px-3 py-1 text-xs font-bold text-gray-600 uppercase bg-gray-100 rounded-full">{{ course.niveau }}</span>
          <span class="text-xl font-bold text-gray-900">{{ formatPrice(course.prix) }}</span>
        </div>

        <h1 class="mb-2 text-xl font-bold text-gray-900">{{ course.titre }}</h1>
        <p class="pb-4 mb-6 text-sm text-gray-500 border-b border-gray-100 line-clamp-3">{{ course.description }}</p>

        <div class="flex items-center gap-3 mb-6">
           <div class="flex items-center justify-center w-8 h-8 text-xs font-bold text-white bg-gray-400 rounded-full">
              {{ course.user?.prenom?.charAt(0) }}{{ course.user?.nom?.charAt(0) }}
           </div>
           <div>
              <p class="text-xs font-bold text-gray-500">Formateur</p>
              <p class="text-sm font-medium text-gray-900 capitalize">{{ course.user?.prenom }} {{ course.user?.nom }}</p>
           </div>
        </div>

        <div class="flex items-start justify-between px-4 mb-8">
          <div class="flex flex-col items-center justify-center gap-2">
            <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            <span class="text-xs font-bold text-gray-600">{{ course.cours?.length || 0 }} cours</span>
          </div>
          <div class="flex flex-col items-center justify-center gap-2">
            <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span class="text-xs font-bold text-gray-600">Illimité</span>
          </div>

          <div v-if="course.est_mentore" class="relative flex flex-col items-center justify-center gap-2 cursor-help group">
             <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" /></svg>
             <span class="text-xs font-bold text-indigo-600">Mentoré</span>
             <div class="absolute z-20 hidden w-40 p-2 mb-2 text-xs text-center text-white -translate-x-1/2 bg-indigo-900 rounded shadow-lg bottom-full group-hover:block left-1/2">
                Inclus une session avec un expert
                <div class="absolute w-2 h-2 rotate-45 -translate-x-1/2 bg-indigo-900 -bottom-1 left-1/2"></div>
             </div>
          </div>
        </div>

        <button @click="showPayment = true" class="w-full py-3 font-bold text-white transition bg-indigo-900 rounded-lg shadow-lg hover:bg-indigo-800">
          S'inscrire et payer
        </button>
      </div>

      <div v-if="showPayment" class="absolute inset-0 z-50 flex flex-col p-6 bg-white/95 backdrop-blur-sm animate-fade-in">
        <h3 class="mb-6 text-lg font-bold text-gray-900">Finaliser l'inscription</h3>
        
        <div class="flex items-center gap-4 p-3 mb-8 border border-gray-100 rounded-lg bg-gray-50">
           <div class="flex items-center justify-center w-10 h-10 text-xs text-white bg-indigo-700 rounded-full">{{ course.titre.charAt(0) }}</div>
           <div class="flex-1">
             <p class="text-sm font-bold text-gray-900 line-clamp-1">{{ course.titre }}</p>
             <p class="text-xs text-gray-500 uppercase">{{ course.user?.prenom }} {{ course.user?.nom }}</p>
           </div>
           <span class="px-2 py-1 text-xs font-bold text-white bg-indigo-600 rounded-full">{{ formatPrice(course.prix) }}</span>
        </div>

        <p class="mb-4 text-sm font-bold text-gray-600">Moyen de paiement :</p>
        <div class="mb-8 space-y-3">
          <button @click="handlePayment('Orange Money')" :disabled="processingPayment" class="flex items-center justify-between w-full px-4 py-3 font-bold text-gray-700 border rounded-lg hover:bg-orange-50 hover:border-orange-500">
            <span>Orange Money</span><div class="w-4 h-4 bg-orange-500 rounded-sm"></div>
          </button>
          <button @click="handlePayment('MTN Money')" :disabled="processingPayment" class="flex items-center justify-between w-full px-4 py-3 font-bold text-gray-700 border rounded-lg hover:bg-yellow-50 hover:border-yellow-500">
            <span>MTN Money</span><div class="w-4 h-4 bg-yellow-400 rounded-sm"></div>
          </button>
        </div>

        <div class="mt-auto">
          <button @click="showPayment = false" class="w-full px-6 py-3 font-bold text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">Annuler</button>
        </div>
      </div>
      
    </div>
    <div v-else class="py-20 text-red-500">Formation introuvable.</div>
  </div>
</template>