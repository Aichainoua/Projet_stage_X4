<script setup>
definePageMeta({
  layout: 'apprenant',
  middleware: 'auth'
})

const route = useRoute()
const router = useRouter()
const token = useCookie('token')
const API_URL = 'http://127.0.0.1:8000'

const coursId = route.params.id

// États
const resources = ref([])
const coursTitre = ref('')
const loading = ref(true)
const previewItem = ref(null)

// --- Méthodes ---

const fetchCourseData = async () => {
  loading.value = true
  try {
    const data = await $fetch(`${API_URL}/api/cours/${coursId}`, {
        headers: {
            'Authorization': `Bearer ${token.value}`,
            'Accept': 'application/json'
        }
    })
    
    // Adaptation robuste (data ou data.data)
    const responseData = data.data || data;

    if (responseData) {
        coursTitre.value = responseData.titre
        resources.value = responseData.ressources || []
    }

  } catch (error) {
    console.error("Erreur chargement du cours", error)
  } finally {
    loading.value = false
  }
}

const getFileUrl = (path) => {
    if (!path) return ''
    if (path.startsWith('http')) return path
    const cleanPath = path.startsWith('/') ? path : '/' + path
    return `${API_URL}${cleanPath}`
}

const openPreview = (res) => previewItem.value = res
const goBack = () => router.back()

onMounted(() => {
    fetchCourseData()
})
</script>

<template>
  <div class="h-full min-h-screen p-8 bg-gray-50">
    
    <div class="flex items-center gap-4 mb-6">
        <button @click="goBack" class="p-2 text-gray-600 transition-colors bg-white border border-gray-200 rounded-full hover:bg-gray-100 hover:text-indigo-700">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </button>
        <div>
            <h1 v-if="coursTitre" class="text-2xl font-bold text-gray-900">{{ coursTitre }}</h1>
            <h1 v-else class="text-2xl font-bold text-gray-900">Chargement...</h1>
            <p class="text-sm text-gray-500">Consultez les ressources disponibles pour ce cours.</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 min-h-[400px] p-6 relative">
      
      <div v-if="loading" class="flex items-center justify-center h-64">
        <div class="w-10 h-10 border-4 border-indigo-900 rounded-full animate-spin border-t-transparent"></div>
      </div>

      <div v-else-if="resources.length === 0" class="flex flex-col items-center justify-center h-64 text-gray-400">
        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="mb-2 opacity-50"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="12" y1="18" x2="12" y2="12"/><line x1="9" y1="15" x2="15" y2="15"/></svg>
        <p>Aucune ressource disponible pour le moment.</p>
      </div>

      <div v-else class="space-y-4">
        <div 
          v-for="res in resources" 
          :key="res.id"
          @click="openPreview(res)"
          class="flex items-center p-4 transition-all bg-white border border-gray-100 rounded-lg cursor-pointer group hover:shadow-md hover:border-indigo-200 hover:bg-indigo-50/30"
        >
            <div class="p-3 mr-4 text-indigo-600 rounded-lg bg-indigo-50 group-hover:bg-indigo-100">
              <svg v-if="res.type === 'pdf'" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
              <svg v-else class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            
            <div class="flex-1 overflow-hidden">
              <h3 class="font-medium text-gray-900 truncate" :title="res.titre">{{ res.titre }}</h3>
              <p class="text-xs font-semibold tracking-wider text-gray-500 uppercase">{{ res.type }}</p>
            </div>

            <div class="text-gray-300 group-hover:text-indigo-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
            </div>
        </div>
      </div>
    </div>

    <div v-if="previewItem" class="fixed inset-0 z-50 flex items-center justify-center p-2 bg-black/90 backdrop-blur-sm">
        <div class="relative w-[98vw] max-w-full h-[95vh] bg-black rounded-lg overflow-hidden flex flex-col shadow-2xl">
            <button @click="previewItem = null" class="absolute z-50 p-2 text-white transition rounded-full top-4 right-4 bg-white/10 hover:bg-white/20">
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
                controlsList="nodownload" 
            >
                <source :src="getFileUrl(previewItem.chemin_fichier)" type="video/mp4">
                Votre navigateur ne supporte pas la lecture de vidéos.
            </video>
        </div>
    </div>

  </div>
</template>