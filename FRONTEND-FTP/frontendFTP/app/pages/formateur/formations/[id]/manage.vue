<script setup>
definePageMeta({ layout: 'formateur', middleware: 'auth' })

const route = useRoute()
const formationId = route.params.id
const API_URL = 'http://127.0.0.1:8000/api'
const token = useCookie('token')

const activeTab = ref('Cours')
const showCreateModal = ref(false)
const isSubmitting = ref(false)
const formation = ref(null) 
const pending = ref(true)

// Objet simple, plus de fichier
const newCours = ref({
    titre: '',
    description: '',
    duree: '' 
})

// 1. CHARGER LA FORMATION
const fetchFormation = async () => {
    if (!formationId || formationId === 'undefined') return 

    pending.value = true
    try {
        const data = await $fetch(`${API_URL}/formations/${formationId}`, {
            headers: { 
                'Authorization': `Bearer ${token.value}`,
                'Accept': 'application/json'
            }
        })
        formation.value = data
        if (!formation.value.cours) formation.value.cours = []
    } catch (e) {
        console.error("Erreur chargement API", e)
    } finally {
        pending.value = false
    }
}

// 2. CRÉER UN COURS (En JSON simple)
const createCours = async () => {
    isSubmitting.value = true
    try {
        const response = await $fetch(`${API_URL}/cours`, {
            method: 'POST',
            headers: { 
                'Authorization': `Bearer ${token.value}`,
                'Accept': 'application/json',
                'Content-Type': 'application/json' // Retour du JSON
            },
            body: {
                ...newCours.value,
                formation_id: formationId
            }
        })

        
        if (formation.value) {
            if (!formation.value.cours) formation.value.cours = []
            
            const coursAjoute = response.data || response
            formation.value.cours.push(coursAjoute)
        }
        
    
        newCours.value = { titre: '', description: '', duree: '' }
        showCreateModal.value = false
        
    } catch (e) {
        console.error(e)
        alert("Erreur lors de la création du cours.")
    } finally {
        isSubmitting.value = false
    }
}


const updateFormation = async () => {
    try {
        await $fetch(`${API_URL}/formations/${formationId}`, {
            method: 'PUT',
            headers: { 'Authorization': `Bearer ${token.value}` },
            body: { 
                titre: formation.value.titre, 
                description: formation.value.description 
            }
        })
        alert("Modifications enregistrées !")
    } catch (e) { console.error(e) }
}

onMounted(() => {
    fetchFormation()
})
</script>

<template>
  <div class="min-h-screen p-6 font-sans bg-gray-50">
    
    <div class="flex items-center justify-between mb-8">
       <div class="flex items-center gap-4">
         <button @click="navigateTo('/formateur/formations')" class="p-2 bg-white border rounded-full hover:bg-gray-100">
           <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5"/><path d="M12 19l-7-7 7-7"/></svg>
         </button>
         <div>
             <h1 class="text-2xl font-bold text-gray-900">{{ formation?.titre || 'Chargement...' }}</h1>
             <p v-if="formation" class="text-sm text-gray-500">
                 {{ formation.cours ? formation.cours.length : 0 }} cours
             </p>
         </div>
       </div>

       <button @click="showCreateModal = true" class="flex items-center gap-2 px-6 py-2.5 font-bold text-white bg-indigo-900 rounded-full hover:bg-indigo-800 shadow-md">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
          Ajouter un cours
       </button>
    </div>

    <div class="mb-8 overflow-x-auto">
        <div class="inline-flex p-1 bg-gray-200/60 rounded-xl">
            <button v-for="tab in ['Cours', 'Étudiants', 'Sessions', 'Informations']" :key="tab"
                @click="activeTab = tab" 
                :class="['px-6 py-2.5 text-sm font-bold rounded-lg transition-all', activeTab === tab ? 'bg-white text-indigo-900 shadow-sm' : 'text-gray-500 hover:text-gray-700']">
                {{ tab }}
            </button>
        </div>
    </div>

    <div v-if="pending" class="py-12 text-center text-gray-500">Chargement...</div>

    <div v-else>
        <div v-if="activeTab === 'Cours'">
            <div v-if="!formation?.cours || formation.cours.length === 0" class="p-16 text-center bg-white border border-dashed rounded-xl">
                <p class="text-lg font-medium text-gray-900">Aucun cours pour l'instant</p>
            </div>

            <div v-else class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                <div v-for="cours in formation.cours" :key="cours.id" class="p-6 bg-white border shadow-sm rounded-2xl hover:shadow-md">
                    <div class="flex items-start justify-between mb-2">
                        <h3 class="text-lg font-bold text-gray-900">{{ cours.titre }}</h3>
                        <span class="px-2 py-1 text-xs font-semibold text-gray-600 bg-gray-100 rounded">{{ cours.duree }}</span>
                    </div>
                    <p class="mb-6 text-sm text-gray-500 line-clamp-3">{{ cours.description }}</p>
                    
                    <NuxtLink :to="`/formateur/formations/${route.params.id}/ressources?cours_id=${cours.id}`"
                        class="block w-full py-3 text-sm font-bold text-center text-gray-700 rounded-lg bg-gray-50 hover:bg-gray-100">
                        Gérer le contenu
                    </NuxtLink>
                </div>
            </div>
        </div>

        <div v-else-if="activeTab === 'Informations'" class="max-w-2xl p-8 bg-white border rounded-xl">
            <form @submit.prevent="updateFormation" class="space-y-6">
                <div><label class="block mb-2 font-bold">Titre</label><input v-model="formation.titre" class="w-full p-3 border rounded-lg"></div>
                <div><label class="block mb-2 font-bold">Description</label><textarea v-model="formation.description" rows="4" class="w-full p-3 border rounded-lg"></textarea></div>
                <button type="submit" class="px-6 py-2 text-white bg-indigo-900 rounded-lg">Enregistrer</button>
            </form>
        </div>
    </div>

    <div v-if="showCreateModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm">
        <div class="w-full max-w-lg p-6 bg-white shadow-2xl rounded-2xl animate-scale-up">
            <div class="flex justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-900">Nouveau cours</h3>
                <button @click="showCreateModal = false" class="text-gray-400 hover:text-gray-600">X</button>
            </div>
            
            <form @submit.prevent="createCours">
                <div class="mb-5">
                    <label class="block mb-2 text-sm font-bold text-gray-700">Titre du cours *</label>
                    <input v-model="newCours.titre" type="text" required placeholder="Ex: Introduction..."
                           class="w-full px-4 py-3 border border-gray-200 rounded-lg bg-gray-50 focus:ring-2 focus:ring-indigo-500">
                </div>
                
                <div class="mb-5">
                    <label class="block mb-2 text-sm font-bold text-gray-700">Durée *</label>
                    <input v-model="newCours.duree" type="text" required placeholder="Ex: 2H 30min"
                           class="w-full px-4 py-3 border border-gray-200 rounded-lg bg-gray-50 focus:ring-2 focus:ring-indigo-500">
                </div>
                
                <div class="mb-8">
                    <label class="block mb-2 text-sm font-bold text-gray-700">Description</label>
                    <textarea v-model="newCours.description" rows="3" placeholder="Contenu du cours..."
                              class="w-full px-4 py-3 border border-gray-200 rounded-lg bg-gray-50 focus:ring-2 focus:ring-indigo-500"></textarea>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t">
                    <button type="button" @click="showCreateModal = false" class="px-5 py-2.5 font-bold text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200">Annuler</button>
                    <button type="submit" :disabled="isSubmitting" class="px-5 py-2.5 font-bold text-white bg-indigo-900 rounded-lg hover:bg-indigo-800 disabled:opacity-50">
                        {{ isSubmitting ? 'Création...' : 'Créer le cours' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

  </div>
</template>

<style scoped>
.animate-scale-up { animation: scaleUp 0.2s ease-out; }
@keyframes scaleUp { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }
</style>