<template>
  <div class="h-full p-8">
    
    <div class="flex items-center justify-between mb-6">
      <div class="flex items-center gap-4">
        <button @click="navigateTo(`/formateur/formations/${formationId}/manage`)" class="p-2 transition-colors rounded-full hover:bg-gray-200">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5"/><path d="M12 19l-7-7 7-7"/></svg>
        </button>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Ressources du cours</h1>
            <p class="text-sm text-gray-500">Ajoutez des fichiers PDF ou Vidéos pour ce cours</p>
        </div>
      </div>

      <div>
        <button 
          @click="triggerFileInput" 
          :disabled="isUploading"
          class="flex items-center gap-2 px-6 py-2.5 bg-[#312E81] text-white rounded-lg hover:bg-[#262468] transition-colors shadow-sm font-medium disabled:opacity-50 disabled:cursor-not-allowed"
        >
          <span v-if="isUploading" class="w-5 h-5 border-2 border-white rounded-full animate-spin border-t-transparent"></span>
          <svg v-else xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
          Ajouter une ressource
        </button>
        
        <input 
          type="file" 
          ref="fileInputRef" 
          class="hidden" 
          @change="handleFileUpload"
          accept=".pdf,video/*"
        >
      </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 min-h-[600px] p-6 relative">
      
      <div v-if="loading" class="flex items-center justify-center h-64">
        <div class="w-8 h-8 border-b-2 border-indigo-900 rounded-full animate-spin"></div>
      </div>

      <div v-else-if="resources.length === 0" class="flex flex-col items-center justify-center h-64 text-gray-400">
        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="mb-2 opacity-50"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="12" y1="18" x2="12" y2="12"/><line x1="9" y1="15" x2="15" y2="15"/></svg>
        <p>Aucune ressource pour ce cours.</p>
      </div>

      <div v-else class="space-y-4">
        <div 
          v-for="res in resources" 
          :key="res.id"
          class="flex items-center justify-between p-4 transition-all bg-white border border-gray-200 rounded-lg group hover:shadow-md hover:border-indigo-100"
        >
          <div class="flex items-center gap-4 cursor-pointer" @click="openPreview(res)">
            <div class="p-3 text-gray-600 transition-colors rounded-lg bg-gray-50 group-hover:bg-indigo-50 group-hover:text-indigo-600">
              <svg v-if="res.type === 'pdf'" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
              <svg v-else xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2" ry="2"/></svg>
            </div>
            
            <div>
              <h3 class="text-sm font-semibold text-gray-800 md:text-base">{{ res.titre }}</h3>
              <p class="text-xs text-gray-500 uppercase font-medium mt-0.5">{{ res.type }}</p>
            </div>
          </div>

          <button 
            @click="deleteRessource(res.id)" 
            class="p-2 text-red-500 transition-colors rounded-lg hover:bg-red-50"
            title="Supprimer la ressource"
          >
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
          </button>
        </div>
      </div>
    </div>

    <div v-if="previewItem" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm">
        <div class="relative w-full max-w-5xl h-[80vh] bg-black rounded-lg overflow-hidden flex flex-col">
            <button @click="previewItem = null" class="absolute z-10 p-2 text-white rounded-full top-4 right-4 bg-black/50 hover:bg-white/20">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg>
            </button>
            
            <iframe 
                v-if="previewItem.type === 'pdf'" 
                :src="getFileUrl(previewItem.chemin_fichier)" 
                class="w-full h-full bg-white"
            ></iframe>
            
            <video 
                v-else 
                controls 
                autoplay 
                class="object-contain w-full h-full"
            >
                <source :src="getFileUrl(previewItem.chemin_fichier)" type="video/mp4">
            </video>
        </div>
    </div>

  </div>
</template>

<script setup>
definePageMeta({
  layout: 'formateur',
  middleware: 'auth'
})

const route = useRoute()
const token = useCookie('token')


const API_URL = 'http://127.0.0.1:8000'


const formationId = route.params.id
const coursId = route.query.cours_id 

const resources = ref([])
const loading = ref(true)
const isUploading = ref(false)
const fileInputRef = ref(null)
const previewItem = ref(null)


const triggerFileInput = () => {
  fileInputRef.value.click()
}

const handleFileUpload = async (event) => {
  const file = event.target.files[0]
  if (!file) return

  isUploading.value = true
  const formData = new FormData()
  
  formData.append('file', file) 
  
  if (coursId) {
      formData.append('cours_id', coursId)
  } else {
      alert("Erreur critique : ID du cours manquant.")
      isUploading.value = false
      return
  }

  try {
    const newRessource = await $fetch(`${API_URL}/api/formations/${formationId}/ressources`, {
      method: 'POST',
      body: formData,
      headers: {
          'Authorization': `Bearer ${token.value}`, 
          'Accept': 'application/json'
      }
    })
    
    
    resources.value.push(newRessource)
    
  } catch (error) {
    console.error('Erreur upload:', error)
    alert("Erreur lors de l'envoi du fichier. Vérifiez la taille ou le format.")
  } finally {
    isUploading.value = false
    event.target.value = null 
  }
}


const fetchResources = async () => {
  loading.value = true
  try {
    const data = await $fetch(`${API_URL}/api/formations/${formationId}`, {
        headers: {
            'Authorization': `Bearer ${token.value}`,
            'Accept': 'application/json'
        }
    })
    
   
    let foundResources = []

    if (data.cours && Array.isArray(data.cours)) {
        
        const leCours = data.cours.find(c => c.id == coursId)
        if (leCours && leCours.ressources) {
            foundResources = leCours.ressources
        }
    } else if (data.ressources) {
       
        foundResources = data.ressources.filter(r => r.cours_id == coursId)
    }

    resources.value = foundResources
    
  } catch (error) {
    console.error("Erreur chargement", error)
  } finally {
    loading.value = false
  }
}

const deleteRessource = async (id) => {
  if (!confirm('Êtes-vous sûr de vouloir supprimer cette ressource ?')) return

  try {
    await $fetch(`${API_URL}/api/ressources/${id}`, { 
        method: 'DELETE',
        headers: {
            'Authorization': `Bearer ${token.value}`,
            'Accept': 'application/json'
        }
    })
    resources.value = resources.value.filter(r => r.id !== id)
  } catch (error) {
    console.error(error)
    alert("Impossible de supprimer.")
  }
}

const getFileUrl = (path) => {
    if (!path) return ''
    if (path.startsWith('http')) return path
   
    const cleanPath = path.startsWith('/') ? path : '/' + path
    return `${API_URL}${cleanPath}`
}

const openPreview = (res) => previewItem.value = res

onMounted(() => {
  if (!coursId) {
      alert("Erreur : Aucun cours sélectionné.")
      navigateTo(`/formateur/formations/${formationId}/manage`)
  } else {
      fetchResources()
  }
})
</script>