<script setup>
definePageMeta({ 
  layout: 'formateur',
  middleware: 'auth'
})

import { ref, onMounted } from 'vue'

const showModal = ref(false)
const loading = ref(true)
const formations = ref([])
const token = useCookie('token') 

const form = ref({
  titre: '',
  description: '',
  prix: '',
  niveau: 'Débutant',
  dateOuverture: '',
  prerequis: '',
  competences: '',
  est_mentore: false 
})

const fetchFormations = async () => {
    try {
        const response = await $fetch('http://127.0.0.1:8000/api/formateur/mes-creations', {
            method: 'GET',
            headers: {
                'Authorization': `Bearer ${token.value}`,
                'Accept': 'application/json'
            }
        })
        formations.value = response
    } catch (error) {
        console.error("Erreur chargement formations", error)
    } finally {
        loading.value = false
    }
}

const openModal = () => {
  form.value = { 
    titre: '', description: '', prix: '', niveau: 'Débutant', 
    dateOuverture: '', prerequis: '', competences: '',
    est_mentore: false 
  }
  showModal.value = true
}

const createFormation = async () => {
  try {
      const payload = {
          ...form.value,
          est_mentore: form.value.est_mentore ? 1 : 0 
      }

      const newFormation = await $fetch('http://127.0.0.1:8000/api/formations', {
          method: 'POST',
          body: payload,
          headers: {
            'Authorization': `Bearer ${token.value}`,
            'Accept': 'application/json'
          }
      })

      formations.value.unshift(newFormation)
      
      showModal.value = false
      
  } catch (error) {
      console.error("Erreur création", error)
      if(error.data && error.data.errors) {
          alert("Erreur : " + Object.values(error.data.errors).flat().join('\n'))
      } else {
          alert("Erreur lors de la création.")
      }
  }
}

const formatPrice = (price) => new Intl.NumberFormat('fr-FR').format(price) + ' FCFA'

const formatDate = (dateStr) => {
  if(!dateStr) return 'Non définie'
  return new Date(dateStr).toLocaleDateString('fr-FR', { day: 'numeric', month: 'short', year: 'numeric' })
}

onMounted(() => {
   fetchFormations()
})
</script>

<template>
  <div>
    <div class="flex items-center justify-between mb-8">
      <div>
        <h2 class="text-xl font-bold text-gray-900">Mes Formations</h2>
        <p class="text-sm text-gray-500">Gérer le catalogue de formations</p>
      </div>
      <button @click="openModal" class="flex items-center gap-2 px-6 py-3 font-bold text-white transition bg-indigo-800 rounded-lg shadow hover:bg-indigo-900">
        <span class="text-xl leading-none">+</span> Nouvelle Formation
      </button>
    </div>

    <div v-if="loading" class="py-12 text-center text-gray-500">Chargement des formations...</div>

    <div v-else-if="!formations || formations.length === 0" class="py-12 text-center bg-white shadow-sm rounded-xl">
        <p class="text-gray-500">Aucune formation créée pour le moment.</p>
    </div>

    <div v-else class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-2">
      <div v-for="formation in formations" :key="formation.id" class="relative flex flex-col p-6 overflow-hidden transition-all bg-white border border-gray-100 shadow-sm rounded-xl group hover:shadow-md">
         
         <div v-if="formation.est_mentore" class="absolute top-0 right-0 p-4">
             <span class="flex items-center gap-1.5 px-3 py-1 text-xs font-bold text-indigo-700 bg-indigo-50 border border-indigo-100 rounded-full shadow-sm">
                 <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                 Mentorée
             </span>
         </div>

         <div class="pr-20 mt-2 mb-2"> 
             <h3 class="text-lg font-bold leading-tight text-gray-900">{{ formation.titre }}</h3>
         </div>
         
         <p class="flex items-center gap-1 mb-3 text-xs font-medium text-gray-500">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            Début : {{ formatDate(formation.date_ouverture || formation.created_at) }}
         </p>

         <p class="mb-4 text-sm text-gray-500 line-clamp-2">{{ formation.description }}</p>

         <div v-if="formation.prerequis" class="p-3 mb-2 bg-white border border-blue-100 rounded-lg">
            <h4 class="flex items-center gap-1 mb-1 text-xs font-bold text-orange-800 uppercase">
                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                Pré-requis
            </h4>
            <p class="text-xs text-gray-700 line-clamp-2">{{ formation.prerequis }}</p>
         </div>

         <div v-if="formation.competences" class="p-3 mb-4 border border-blue-100 rounded-lg bg-blue-50">
            <h4 class="flex items-center gap-1 mb-1 text-xs font-bold text-blue-800 uppercase">
                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                Compétences
            </h4>
            <p class="text-xs text-gray-700 line-clamp-2">{{ formation.competences }}</p>
         </div>
         
         <div class="flex items-center justify-between pt-4 mt-auto border-t border-gray-100">
            <div>
                 <span class="block text-lg font-bold text-indigo-900">{{ formatPrice(formation.prix) }}</span>
            </div>
            <span class="px-3 py-1 text-xs font-bold text-gray-600 bg-gray-100 rounded-lg">{{ formation.niveau }}</span>
         </div>
         
         <NuxtLink :to="`/formateur/formations/${formation.id}/manage`" class="w-full py-3 mt-4 font-bold text-center text-gray-900 transition border border-gray-200 rounded-lg bg-gray-50 hover:bg-white hover:border-indigo-300 hover:text-indigo-700 hover:shadow-md">
           Gérer le contenu
         </NuxtLink>
      </div>
    </div>

    <div v-if="showModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-indigo-900/60 backdrop-blur-sm">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[95vh] overflow-y-auto transform transition-all">
            
            <div class="flex items-center justify-between p-6 border-b border-gray-100 bg-gray-50/50">
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Nouvelle formation</h3>
                    <p class="text-sm text-gray-500">Remplissez les détails ci-dessous</p>
                </div>
                <button @click="showModal = false" class="p-1 text-gray-400 transition-colors bg-white border border-gray-200 rounded-full hover:text-gray-600 hover:border-gray-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form @submit.prevent="createFormation" class="p-6 space-y-5">
                
                <div>
                    <label class="block mb-1 text-sm font-bold text-gray-900">Titre de la formation</label>
                    <input v-model="form.titre" required type="text" class="w-full p-3 transition-all border border-gray-200 rounded-lg bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white" placeholder="Ex: Masterclass Vue.js">
                </div>

                <div>
                    <label class="block mb-1 text-sm font-bold text-gray-900">Description courte</label>
                    <textarea v-model="form.description" required rows="2" class="w-full p-3 transition-all border border-gray-200 rounded-lg resize-none bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white"></textarea>
                </div>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                    <div>
                        <label class="block mb-1 text-sm font-bold text-gray-900">Prix (FCFA)</label>
                        <input v-model="form.prix" required type="number" class="w-full p-3 transition-all border border-gray-200 rounded-lg bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white">
                    </div>
                    <div>
                        <label class="block mb-1 text-sm font-bold text-gray-900">Niveau</label>
                        <select v-model="form.niveau" class="w-full p-3 transition-all border border-gray-200 rounded-lg cursor-pointer bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white">
                            <option>Débutant</option>
                            <option>Intermédiaire</option>
                            <option>Avancé</option>
                        </select>
                    </div>
                    <div>
                        <label class="block mb-1 text-sm font-bold text-gray-900">Ouverture</label>
                        <input v-model="form.dateOuverture" required type="date" class="w-full p-3 text-gray-600 transition-all border border-gray-200 rounded-lg bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white">
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div>
                        <label class="block mb-1 text-sm font-bold text-gray-900">Pré-requis</label>
                        <textarea v-model="form.prerequis" rows="2" class="w-full p-3 text-sm transition-all border border-gray-200 rounded-lg resize-none bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white" placeholder="HTML, PC portable..."></textarea>
                    </div>
                    <div>
                        <label class="block mb-1 text-sm font-bold text-gray-900">Compétences</label>
                        <textarea v-model="form.competences" rows="2" class="w-full p-3 text-sm transition-all border border-gray-200 rounded-lg resize-none bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white" placeholder="API REST, Déploiement..."></textarea>
                    </div>
                </div>

                <div class="p-4 mt-4 border border-indigo-100 bg-indigo-50 rounded-xl">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input v-model="form.est_mentore" type="checkbox" class="w-5 h-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                        <div>
                            <span class="block text-sm font-bold text-indigo-900">Formation mentorée </span>
                            <span class="block text-xs text-indigo-600">En cochant cette case, la formation sera marquée comme "Mentorée" </span>
                        </div>
                    </label>
                </div>

                <div class="flex justify-end gap-3 pt-6 mt-2 border-t border-gray-100">
                    <button type="button" @click="showModal = false" class="px-5 py-2.5 text-gray-600 font-bold hover:bg-gray-100 rounded-lg transition-colors">Annuler</button>
                    <button type="submit" class="px-6 py-2.5 bg-indigo-900 text-white font-bold rounded-lg hover:bg-indigo-800 shadow-md hover:shadow-lg transition-all transform active:scale-95">Créer la formation</button>
                </div>

            </form>
        </div>
    </div>

  </div>
</template>