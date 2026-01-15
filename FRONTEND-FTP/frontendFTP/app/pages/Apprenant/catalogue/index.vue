<script setup>
definePageMeta({ 
  layout: 'apprenant',
  middleware: 'auth'
})

// 1. Récupération des infos
const user = useCookie('user') 
const token = useCookie('token')
const API_URL = 'http://127.0.0.1:8000'

// 2. Récupération des formations
const { data: courses, pending, error } = await useFetch(`${API_URL}/api/formations`, {
    headers: {
        'Authorization': `Bearer ${token.value}`,
        'Accept': 'application/json'
    },
    lazy: true 
})

// 3. Logique de Recherche
const searchQuery = ref('')

const filteredCourses = computed(() => {
    if (!courses.value) return []
    if (!searchQuery.value) return courses.value

    const query = searchQuery.value.toLowerCase()
    return courses.value.filter(course => 
        course.titre.toLowerCase().includes(query) || 
        course.description.toLowerCase().includes(query)
    )
})

// 4. Utilitaires d'affichage
const formatPrice = (price) => new Intl.NumberFormat('fr-FR').format(price) + ' FCFA'

const formatDate = (dateStr) => {
  if(!dateStr) return 'Bientôt disponible'
  return new Date(dateStr).toLocaleDateString('fr-FR', { day: 'numeric', month: 'short', year: 'numeric' })
}

// 5. LOGIQUE DU MODAL
const selectedCourseId = ref(null)
const isModalOpen = ref(false)

const openDetails = (id) => {
    selectedCourseId.value = id
    isModalOpen.value = true
}

// === GESTION DU SUCCÈS PAIEMENT ===
const handlePaymentSuccess = (courseId) => {
    // Option A : On redirige immédiatement après le paiement
    isModalOpen.value = false
    navigateTo('/apprenant/formation')
    
    // Note : Si tu préfères rester sur la page et cliquer manuellement, 
    // commente la ligne 'navigateTo' ci-dessus et décommente le code ci-dessous :
    /*
    const course = courses.value.find(c => c.id === courseId)
    if (course) {
        course.est_paye = true 
    }
    isModalOpen.value = false
    */
}

// Fonction pour accéder au cours (Click bouton vert)
const goToCourse = (id) => {
    // Redirection vers la page "Mes formations" (Liste des achats)
    navigateTo('/apprenant/formation')
}
</script>
<template>
  <div>
    <div class="mb-8">
      <h1 class="text-3xl font-bold text-gray-900">
        Bonjour, <span class="text-indigo-700 capitalize">{{ user?.prenom || 'Apprenant' }}</span> ! 👋
      </h1>
      <p class="text-sm text-gray-500">Bienvenue sur votre catalogue de formations</p>
    </div>

    <div class="flex flex-col justify-between gap-4 mb-6 md:flex-row md:items-center">
       <div>
         <h2 class="text-2xl font-bold text-gray-900">Catalogue complet</h2>
         <p class="text-gray-500">Découvrez nos parcours tutorés et en autonomie</p>
       </div>
       
       <div class="relative w-full md:w-72">
        <input 
          v-model="searchQuery" 
          type="text" 
          placeholder="Rechercher..." 
          class="w-full py-2 pl-10 pr-4 bg-white border border-gray-200 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
        >
        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
       </div>
    </div>

    <div v-if="pending" class="flex justify-center py-20">
        <div class="w-12 h-12 border-b-2 border-indigo-900 rounded-full animate-spin"></div>
    </div>

    <div v-else-if="error" class="p-4 text-center text-red-600 rounded-lg bg-red-50">
        Impossible de charger les formations. Vérifiez votre connexion.
    </div>

    <div v-else class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-2">
      
      <div v-for="course in filteredCourses" :key="course.id" class="relative flex flex-col p-6 overflow-hidden transition-all bg-white border border-gray-100 shadow-sm rounded-xl group hover:shadow-md">
          
          <div v-if="course.est_mentore" class="absolute top-0 right-0 p-4">
              <span class="flex items-center gap-1.5 px-3 py-1 text-xs font-bold text-indigo-700 bg-indigo-50 border border-indigo-100 rounded-full shadow-sm">
                  <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                  Mentorée
              </span>
          </div>

          <div class="pr-20 mt-2 mb-1"> 
              <h3 class="text-lg font-bold leading-tight text-gray-900">
                  {{ course.titre }}
              </h3>
          </div>
          
          <div class="flex items-center gap-2 mb-3">
           <div class="flex items-center justify-center w-8 h-8 text-xs font-bold text-white bg-gray-400 rounded-full">
               {{ course.user?.prenom?.charAt(0).toUpperCase() }}{{ course.user?.nom?.charAt(0).toUpperCase() }}
           </div>
            <p class="text-xs font-medium text-gray-500">
                Par : <span class="text-gray-700">{{ course.user?.prenom }} {{ course.user?.nom }}</span>
            </p>
          </div>

          <p class="flex items-center gap-1 mb-3 text-xs font-medium text-gray-400">
             <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
             Début : {{ formatDate(course.date_ouverture) }}
          </p>

          <p class="mb-4 text-sm text-gray-500 line-clamp-2">{{ course.description }}</p>

          <div v-if="course.prerequis" class="p-3 mb-2 bg-white border border-blue-100 rounded-lg">
             <h4 class="flex items-center gap-1 mb-1 text-xs font-bold text-orange-800 uppercase">
                 <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                 Pré-requis
             </h4>
             <p class="text-xs text-gray-700 line-clamp-2">{{ course.prerequis }}</p>
          </div>

          <div v-if="course.competences" class="p-3 mb-4 border border-blue-100 rounded-lg bg-blue-50">
             <h4 class="flex items-center gap-1 mb-1 text-xs font-bold text-blue-800 uppercase">
                 <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                 Compétences
             </h4>
             <p class="text-xs text-gray-700 line-clamp-2">{{ course.competences }}</p>
          </div>
          
          <div class="flex items-center justify-between pt-4 mt-auto border-t border-gray-100">
              <div>
                   <span v-if="course.est_paye" class="flex items-center gap-1 text-lg font-bold text-green-600">
                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                      Payée
                   </span>
                   <span v-else class="block text-lg font-bold text-indigo-900">
                      {{ formatPrice(course.prix) }}
                   </span>

                   <span class="text-xs font-medium text-gray-500">{{ course.cours ? course.cours.length : 0 }} Cours</span>
              </div>
              <span class="px-3 py-1 text-xs font-bold text-gray-600 bg-gray-100 rounded-lg">{{ course.niveau }}</span>
          </div>
          
          <button 
            v-if="course.est_paye"
            @click="goToCourse(course.id)"
            class="flex items-center justify-center w-full gap-2 py-3 mt-4 font-bold text-white transition bg-green-600 rounded-lg shadow-md hover:bg-green-700 hover:shadow-lg">
            Accéder au cours
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
          </button>

          <button 
            v-else
            @click="openDetails(course.id)" 
            class="w-full py-3 mt-4 font-bold text-center text-white transition bg-indigo-900 rounded-lg shadow-md hover:bg-indigo-800 hover:shadow-lg">
            Voir les détails
          </button>

      </div>

      <div v-if="filteredCourses.length === 0 && !pending" class="py-10 text-center text-gray-500 col-span-full">
        Aucune formation ne correspond à votre recherche.
      </div>

    </div>

    <Teleport to="body">
        <div v-if="isModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4">
            
            <div class="absolute inset-0 transition-opacity bg-black/60 backdrop-blur-sm" @click="isModalOpen = false"></div>
            
            <div class="relative z-10 w-full max-w-md max-h-[90vh] overflow-y-auto">
                 <FormationDetails 
                    :courseId="selectedCourseId" 
                    @close="isModalOpen = false" 
                    @payment-success="handlePaymentSuccess"
                />
            </div>

        </div>
    </Teleport>

  </div>
</template>