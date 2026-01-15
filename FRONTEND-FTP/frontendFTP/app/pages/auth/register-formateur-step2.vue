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
        <button @click="navigateTo('/register-step1')" class="flex-1 px-4 py-2 font-medium text-gray-700 transition bg-gray-100 rounded-lg hover:bg-gray-200">
          APPRENANT
        </button>
        <button class="flex-1 px-4 py-2 font-medium text-white bg-indigo-700 rounded-lg">
          FORMATEUR
        </button>
      </div>

      <p class="mb-6 text-xs text-gray-500">Présenter les qualifications pour devenir formateur</p>

      <div class="mb-6">
        <div class="flex items-center justify-between mb-2">
          <span class="text-xs font-medium text-indigo-700">Etape 2 sur 2 : Compétences et expériences</span>
        </div>
        <div class="w-full h-2 bg-gray-200 rounded-full">
          <div class="h-2 bg-indigo-700 rounded-full" style="width: 100%"></div>
        </div>
      </div>

      <form @submit.prevent="handleSubmit" class="space-y-4">
        <div>
          <label class="block mb-2 text-sm font-medium text-gray-700">Domaine(s) d'expertise</label>
          <div class="relative">
            <button type="button" @click="dropdownOpen = !dropdownOpen" class="w-full px-4 py-2.5 bg-gray-100 border-0 rounded-lg focus:ring-2 focus:ring-indigo-700 focus:bg-white transition text-sm text-left flex items-center justify-between">
              <span v-if="form.domaines.length === 0" class="text-gray-500">Sélectionner les domaines</span>
              <span v-else class="text-gray-700">{{ form.domaines.length }} domaine(s) sélectionné(s)</span>
              <svg class="w-5 h-5 text-gray-500 transition-transform" :class="{ 'rotate-180': dropdownOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
              </svg>
            </button>
            
            <div v-if="dropdownOpen" class="absolute z-10 w-full mt-2 overflow-y-auto bg-white border border-gray-200 rounded-lg shadow-lg max-h-64">
              <label v-for="domaine in domainesExpertise" :key="domaine.value" class="flex items-center gap-3 px-4 py-3 transition cursor-pointer hover:bg-gray-50">
                <input type="checkbox" :value="domaine.value" v-model="form.domaines" class="w-4 h-4 text-indigo-700 bg-white border-gray-300 rounded focus:ring-indigo-700 focus:ring-2" />
                <span class="text-sm text-gray-700">{{ domaine.label }}</span>
              </label>
            </div>
          </div>
          
          <div v-if="form.domaines.length > 0" class="flex flex-wrap gap-2 mt-3">
            <span v-for="domaineId in form.domaines" :key="domaineId" class="inline-flex items-center gap-1 px-3 py-1 text-xs font-medium text-indigo-700 bg-indigo-100 rounded-full">
              {{ domainesExpertise.find(d => d.value === domaineId)?.label }}
              <button type="button" @click="removeDomaine(domaineId)" class="hover:bg-indigo-200 rounded-full p-0.5 transition">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
              </button>
            </span>
          </div>
        </div>

        <div>
          <label class="block mb-1 text-sm font-medium text-gray-700">Compétences clés</label>
          <input v-model="form.competences" type="text" placeholder="Ex: React, Vue.js, Node.js" class="w-full px-4 py-2.5 bg-gray-100 border-0 rounded-lg focus:ring-2 focus:ring-indigo-700 focus:bg-white transition text-sm" required />
        </div>

        <div>
          <label class="block mb-1 text-sm font-medium text-gray-700">Années d'expériences</label>
          <input v-model="form.experience" type="number" min="0" placeholder="Ex: 5" class="w-full px-4 py-2.5 bg-gray-100 border-0 rounded-lg focus:ring-2 focus:ring-indigo-700 focus:bg-white transition text-sm" required />
        </div>

        <div>
          <label class="block mb-1 text-sm font-medium text-gray-700">Niveau de formation</label>
          <select v-model="form.niveau" class="w-full px-4 py-2.5 bg-gray-100 border-0 rounded-lg focus:ring-2 focus:ring-indigo-700 focus:bg-white transition text-sm" required>
            <option value="">Sélectionnez un niveau</option>
            <option value="bac">Baccalauréat</option>
            <option value="licence">Licence</option>
            <option value="master">Master</option>
            <option value="doctorat">Doctorat</option>
            <option value="autre">Autre</option>
          </select>
        </div>

        <div>
          <label class="block mb-1 text-sm font-medium text-gray-700">Description des formations données</label>
          <textarea v-model="form.description" placeholder="Décrivez votre expérience..." rows="3" class="w-full px-4 py-2.5 bg-gray-100 border-0 rounded-lg focus:ring-2 focus:ring-indigo-700 focus:bg-white transition text-sm resize-none" required></textarea>
        </div>

        <div>
          <label class="block mb-1 text-sm font-medium text-gray-700">CV</label>
          <div class="p-6 text-center transition border-2 border-gray-300 border-dashed rounded-lg cursor-pointer hover:border-indigo-700">
            <input type="file" @change="handleFileUpload" accept=".pdf,.doc,.docx" class="hidden" id="cv-upload" />
            <label for="cv-upload" class="cursor-pointer">
              <svg class="w-10 h-10 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
              </svg>
              <p class="text-sm text-gray-600">Glisser-Déposer ou cliquer</p>
              <p class="mt-1 text-xs text-gray-500">(PDF, DOC, DOCX - Max 5MB)</p>
            </label>
          </div>
          <p v-if="fileName" class="mt-2 text-sm text-green-600">✓ {{ fileName }}</p>
        </div>

        <div class="flex gap-3 mt-6">
          <button type="button" @click="navigateTo('/register-formateur-step1')" class="flex items-center justify-center flex-1 gap-2 py-3 font-semibold text-gray-700 transition duration-200 bg-gray-200 rounded-lg hover:bg-gray-300">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Retour
          </button>
          <button type="submit" :disabled="loading" class="flex-1 py-3 font-semibold text-white transition duration-200 bg-indigo-700 rounded-lg hover:bg-indigo-800 disabled:opacity-50 disabled:cursor-not-allowed">
            {{ loading ? 'Envoi...' : 'Soumettre' }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
const dropdownOpen = ref(false)
const loading = ref(false)
const fileName = ref('')
const error = ref('')

const domainesExpertise = [
  { value: 'genie-logiciel', label: 'Génie logiciel' },
  { value: 'dev-web', label: 'Développement web' },
  { value: 'dev-mobile', label: 'Développement mobile' },
  { value: 'data-science', label: 'Data Science' },
  { value: 'ia-ml', label: 'Intelligence Artificielle & ML' },
  { value: 'cybersecsecurite', label: 'Cybersécurité' },
  { value: 'design-ui-ux', label: 'Design UI/UX' },
  { value: 'devops', label: 'DevOps' },
  { value: 'base-donnees', label: 'Base de données' },
  { value: 'cloud', label: 'Cloud Computing' },
]

const form = ref({
  domaines: [],
  competences: '',
  experience: '',
  niveau: '',
  description: ''
})

const handleFileUpload = (event) => {
  const file = event.target.files[0]
  if (file) {
    if (file.size > 5 * 1024 * 1024) {
      alert('Le fichier est trop volumineux (max 5MB)')
      return
    }
    fileName.value = file.name
  }
}

const removeDomaine = (domaineId) => {
  form.value.domaines = form.value.domaines.filter(d => d !== domaineId)
}

const handleSubmit = async () => {
  if (form.value.domaines.length === 0) {
    alert('Veuillez sélectionner au moins un domaine d\'expertise')
    return
  }

  loading.value = true

  try {
    // Récupérer les données de l'étape 1
    const step1Data = JSON.parse(localStorage.getItem('formateurStep1') || '{}')
    
    if (!step1Data.email || !step1Data.nom) {
      alert('Les données de l\'étape 1 sont manquantes. Veuillez recommencer.')
      navigateTo('/register-formateur-step1')
      return
    }
    
    // Préparer FormData pour l'upload de fichier
    const formData = new FormData()
    
    // Données étape 1
    formData.append('nom', step1Data.nom)
    formData.append('prenom', step1Data.prenom)
    formData.append('email', step1Data.email)
    formData.append('telephone', step1Data.telephone)
    formData.append('codePays', step1Data.codePays)
    formData.append('paysCode', step1Data.paysCode)
    formData.append('paysEmoji', step1Data.paysEmoji)
    formData.append('dateNaissance', step1Data.dateNaissance)
    formData.append('pays', step1Data.pays)
    formData.append('biographie', step1Data.biographie)
    
    // Données étape 2
    form.value.domaines.forEach(domaine => {
      formData.append('domaines[]', domaine)
    })
    formData.append('competences', form.value.competences)
    formData.append('experience', form.value.experience)
    formData.append('niveau', form.value.niveau)
    formData.append('description', form.value.description)
    
    // Fichier CV
    const cvInput = document.getElementById('cv-upload')
    if (cvInput && cvInput.files && cvInput.files[0]) {
      formData.append('cvFile', cvInput.files[0])
    }

    // Utiliser le composable API
    const { registerFormateur } = useApi()
    const data = await registerFormateur(formData)

    if (data.success) {
      // Nettoyer le localStorage
      localStorage.removeItem('formateurStep1')
      
      alert(data.message)
      navigateTo('/registration-success')
    } else {
      const errorMessage = data.message || 'Erreur lors de la soumission'
      const errors = data.errors ? Object.values(data.errors).flat().join('\n') : ''
      alert(`${errorMessage}\n${errors}`)
    }
  } catch (error) {
    console.error('Erreur:', error)
    const errorMessage = error?.response?.message || error?.message || 'Erreur lors de la soumission de votre candidature'
    const errors = error?.response?.errors ? Object.values(error.response.errors).flat().join('\n') : ''
    alert(`${errorMessage}\n${errors}`)
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  document.addEventListener('click', (e) => {
    if (!e.target.closest('.relative')) {
      dropdownOpen.value = false
    }
  })
})
</script>