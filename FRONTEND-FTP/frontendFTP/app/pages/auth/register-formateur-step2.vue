<template>
  <div class="flex items-center justify-center min-h-screen p-4 bg-gray-50">
    
    <ClientOnly>
      
      <div class="w-full max-w-lg p-8 bg-white rounded-lg shadow-lg">
        
        <div class="flex items-center gap-3 mb-6">
          <div class="flex items-center justify-center w-12 h-12 bg-indigo-700 rounded-lg">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
            </svg>
          </div>
          <h1 class="text-2xl font-bold text-gray-800">EDULAB AFRIK</h1>
        </div>

        <h2 class="mb-4 text-lg font-semibold text-gray-700">Devenir Formateur</h2>

        <div class="mb-6">
          <div class="flex items-center justify-between mb-2">
            <span class="text-xs font-medium text-indigo-700">Etape 2 sur 2 : Compétences et experiences</span>
          </div>
          <div class="w-full h-2 bg-gray-200 rounded-full">
            <div class="h-2 bg-indigo-700 rounded-full" style="width: 100%"></div>
          </div>
        </div>

        <div v-if="errorMessage" class="p-3 mb-4 text-sm text-red-700 whitespace-pre-line bg-red-100 rounded-lg">
          {{ errorMessage }}
        </div>

        <form @submit.prevent="handleSubmit" class="space-y-5">
          
          <div>
            <label class="block mb-2 text-sm font-medium text-gray-700">Domaine(s) d'expertise</label>
            <div class="relative">
              <button type="button" @click.stop="toggleDropdown('domaines')" class="w-full px-4 py-2.5 bg-gray-100 border-0 rounded-lg focus:ring-2 focus:ring-indigo-700 focus:bg-white transition text-sm text-left flex items-center justify-between">
                <span v-if="form.domaines.length === 0" class="text-gray-500">Sélectionner les domaines</span>
                <span v-else class="text-gray-700">{{ form.domaines.length }} sélectionné(s)</span>
                <svg class="w-5 h-5 text-gray-500 transition-transform" :class="{ 'rotate-180': openDropdown === 'domaines' }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
              </button>
              
              <div v-if="openDropdown === 'domaines'" class="absolute z-20 w-full mt-2 overflow-y-auto bg-white border border-gray-200 rounded-lg shadow-xl max-h-60">
                <label v-for="domaine in domainesList" :key="domaine.value" class="flex items-center gap-3 px-4 py-3 transition cursor-pointer hover:bg-gray-50">
                  <input type="checkbox" :value="domaine.value" v-model="form.domaines" class="w-4 h-4 text-indigo-700 bg-white border-gray-300 rounded focus:ring-indigo-700" />
                  <span class="text-sm text-gray-700">{{ domaine.label }}</span>
                </label>
              </div>
            </div>
            <div v-if="form.domaines.length > 0" class="flex flex-wrap gap-2 mt-2">
              <span v-for="domaineId in form.domaines" :key="domaineId" class="inline-flex items-center gap-1 px-2 py-1 text-xs font-medium text-indigo-700 bg-indigo-100 rounded-full">
                {{ domainesList.find(d => d.value === domaineId)?.label }}
                <button type="button" @click="removeItem('domaines', domaineId)" class="hover:text-indigo-900"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
              </span>
            </div>
          </div>

          <div>
            <label class="block mb-2 text-sm font-medium text-gray-700">Compétences cles</label>
            <div class="relative">
              <button type="button" @click.stop="toggleDropdown('competences')" class="w-full px-4 py-2.5 bg-gray-100 border-0 rounded-lg focus:ring-2 focus:ring-indigo-700 focus:bg-white transition text-sm text-left flex items-center justify-between">
                <span v-if="form.competences.length === 0" class="text-gray-500">Sélectionner les compétences</span>
                <span v-else class="text-gray-700">{{ form.competences.length }} sélectionnée(s)</span>
                <svg class="w-5 h-5 text-gray-500 transition-transform" :class="{ 'rotate-180': openDropdown === 'competences' }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
              </button>
              
              <div v-if="openDropdown === 'competences'" class="absolute z-20 w-full mt-2 overflow-y-auto bg-white border border-gray-200 rounded-lg shadow-xl max-h-60">
                <label v-for="comp in competencesList" :key="comp.value" class="flex items-center gap-3 px-4 py-3 transition cursor-pointer hover:bg-gray-50">
                  <input type="checkbox" :value="comp.value" v-model="form.competences" class="w-4 h-4 text-green-600 bg-white border-gray-300 rounded focus:ring-green-600" />
                  <span class="text-sm text-gray-700">{{ comp.label }}</span>
                </label>
              </div>
            </div>
            <div v-if="form.competences.length > 0" class="flex flex-wrap gap-2 mt-2">
              <span v-for="compId in form.competences" :key="compId" class="inline-flex items-center gap-1 px-2 py-1 text-xs font-medium text-green-700 bg-green-100 rounded-full">
                {{ competencesList.find(c => c.value === compId)?.label }}
                <button type="button" @click="removeItem('competences', compId)" class="hover:text-green-900"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
              </span>
            </div>
          </div>

          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block mb-1 text-sm font-medium text-gray-700">Années d'expérience</label>
              <input v-model="form.experience" type="number" min="0" placeholder="Ex: 5" class="w-full px-4 py-2.5 bg-gray-100 border-0 rounded-lg focus:ring-2 focus:ring-indigo-700 transition text-sm" required />
            </div>
            <div>
              <label class="block mb-1 text-sm font-medium text-gray-700">Niveau de formation</label>
              <select v-model="form.niveau" class="w-full px-4 py-2.5 bg-gray-100 border-0 rounded-lg focus:ring-2 focus:ring-indigo-700 transition text-sm" required>
                <option value="Bac">Baccalauréat</option>
                <option value="Licence">Licence </option>
                <option value="Master">Master </option>
                <option value="Ingénieur">Ingénieur</option>
                <option value="Doctorat">Doctorat</option>
                <option value="Autre">Autre / Autodidacte</option>
              </select>
            </div>
          </div>

          <div>
            <label class="block mb-1 text-sm font-medium text-gray-700">Description de la formation données</label>
            <textarea v-model="form.description" rows="3" placeholder="Parlez-nous de vos réalisations..." class="w-full px-4 py-2.5 bg-gray-100 border-0 rounded-lg focus:ring-2 focus:ring-indigo-700 transition text-sm resize-none" required></textarea>
          </div>

          <div>
            <label class="block mb-1 text-sm font-medium text-gray-700">Curriculum Vitae (PDF/DOC)</label>
            <div class="relative p-6 text-center transition border-2 border-gray-300 border-dashed rounded-lg hover:border-indigo-700 hover:bg-gray-50">
              <input type="file" @change="handleFileUpload" accept=".pdf,.doc,.docx" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
              <div v-if="!fileName">
                <svg class="w-8 h-8 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                <p class="mt-1 text-xs text-gray-500">Glisser votre CV ici</p>
              </div>
              <div v-else class="flex items-center justify-center gap-2 text-sm font-medium text-green-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ fileName }}
              </div>
            </div>
          </div>

          <hr class="border-gray-200" />

          <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <div>
              <label class="block mb-1 text-sm font-medium text-gray-700">Mot de passe</label>
              <input v-model="form.password" type="password" placeholder="******" class="w-full px-4 py-2.5 bg-gray-100 border-0 rounded-lg focus:ring-2 focus:ring-indigo-700 transition text-sm" required />
            </div>
            <div>
              <label class="block mb-1 text-sm font-medium text-gray-700">Confirmer mot de passe</label>
              <input v-model="form.password_confirmation" type="password" placeholder="******" class="w-full px-4 py-2.5 bg-gray-100 border-0 rounded-lg focus:ring-2 focus:ring-indigo-700 transition text-sm" required />
            </div>
          </div>
      
          <p v-if="passwordMismatch" class="text-xs font-medium text-red-600">Les mots de passe ne correspondent pas.</p>

          <div class="flex gap-3 pt-2">
            <button type="button" @click="goBack" class="px-5 py-3 font-medium text-gray-700 transition bg-gray-200 rounded-lg hover:bg-gray-300">
              Retour
            </button>
            <button 
              type="submit" 
              :disabled="loading"
              class="flex-1 py-3 font-semibold text-white transition-all bg-indigo-700 rounded-lg shadow-md hover:bg-indigo-800 disabled:opacity-50 disabled:cursor-not-allowed hover:shadow-lg"
            >
              <span v-if="loading" class="flex items-center justify-center gap-2">
                <svg class="w-5 h-5 animate-spin" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                Traitement...
              </span>
              <span v-else>Soumettre ma candidature</span>
            </button>
          </div>

        </form>
      </div>
      
      <template #fallback>
        <div class="flex flex-col items-center">
          <div class="w-12 h-12 border-4 border-indigo-200 rounded-full border-t-indigo-700 animate-spin"></div>
          <p class="mt-4 text-indigo-700">Chargement du formulaire...</p>
        </div>
      </template>

    </ClientOnly>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()

// --- ETAT ---
const loading = ref(false)
const errorMessage = ref('')
const fileName = ref('')
const openDropdown = ref('') 

// --- DONNÉES STATIQUES ---
const domainesList = [
  { value: 'soft-skill', label: 'Soft Skills et Attitude Professionnelle' },
  { value: 'supply-chain', label: 'Gestion de la Chaîne Logistique et Stocks' },
  { value: 'RSE', label: 'Transition Écologique et RSE' },
  { value: 'Onboarding', label: 'Réussir Intégration des Nouveaux Collaborateurs' },
  { value: 'Blended Learning', label: 'Concevoir un Cours Hybride Efficace' },
  { value: 'depannage', label: 'Froid et Climatisation' },
  { value: 'management', label: 'Gestion de Projet' },
]

const competencesList = [
  { value: 'maintenance-indus', label: 'Maintenance Industrielle / Mécanique' },
  { value: 'electronique', label: 'Électronique / Électricité' },
  { value: 'froid-clim', label: 'Froid & Climatisation' },
  { value: 'energies-renouvelables', label: 'Énergie Solaire / Photovoltaïque' },
  { value: 'logistique', label: 'Logistique / Supply Chain' },
  { value: 'entrepreneuriat', label: 'Entrepreneuriat / Gestion de PME' },
  { value: 'rse-durable', label: 'RSE / Transition Écologique' },
  { value: 'soft-skills', label: 'Soft Skills / Leadership' },
  { value: 'rh-onboarding', label: 'RH / Onboarding & Culture d\'entreprise' },
  { value: 'gestion-projet', label: 'Gestion de Projet / Agilité' },
]

// --- FORMULAIRE ---
const form = ref({
  domaines: [],
  competences: [],
  experience: '',
  niveau: 'Licence',
  description: '',
  password: '',
  password_confirmation: ''
})
const cvFile = ref(null)

// --- COMPUTED ---
const passwordMismatch = computed(() => {
  return form.value.password && 
         form.value.password_confirmation && 
         form.value.password !== form.value.password_confirmation
})

// --- LIFECYCLE ---
onMounted(() => {
  document.addEventListener('click', (e) => {
    if (!e.target.closest('.relative')) {
      openDropdown.value = ''
    }
  })

  // Vérification de l'étape 1
  if (!localStorage.getItem('formateurStep1')) {
     console.warn("Pas de données étape 1, redirection...")
     // router.push('/auth/register-formateur-step1') // Décommente pour activer la sécu
  }
})

// --- METHODES ---
const toggleDropdown = (name) => {
  openDropdown.value = openDropdown.value === name ? '' : name
}

const removeItem = (type, value) => {
  if (type === 'domaines') {
    form.value.domaines = form.value.domaines.filter(item => item !== value)
  } else {
    form.value.competences = form.value.competences.filter(item => item !== value)
  }
}

const handleFileUpload = (event) => {
  const file = event.target.files[0]
  if (file) {
    if (file.size > 5 * 1024 * 1024) { // 5MB limit
      alert('Le fichier est trop volumineux (Max 5MB)')
      return
    }
    cvFile.value = file
    fileName.value = file.name
  }
}

const goBack = () => {
  router.push('/auth/register-formateur-step1')
}

// --- SUBMIT ---
const handleSubmit = async () => {
  errorMessage.value = ''
  
  // Validation Frontend
  if (form.value.domaines.length === 0) return alert('Sélectionnez au moins un domaine.')
  if (form.value.competences.length === 0) return alert('Sélectionnez au moins une compétence.')
  if (!cvFile.value) return alert('Veuillez joindre votre CV.')
  if (passwordMismatch.value) return alert('Les mots de passe ne correspondent pas.')
  if (!form.value.password) return alert('Veuillez définir un mot de passe.')

  loading.value = true

  try {
    const step1Raw = localStorage.getItem('formateurStep1')
    if (!step1Raw) throw new Error("Les données de l'étape 1 sont perdues. Veuillez recommencer.")
    const step1Data = JSON.parse(step1Raw)

    const formData = new FormData()

    // 1. Ajout des données de l'étape 1
    Object.keys(step1Data).forEach(key => {
        if(step1Data[key] !== null && step1Data[key] !== undefined && key !== 'pays') {
             formData.append(key, step1Data[key])
        }
    })

    // 2. Gestion spécifique de l'ID Pays (si nécessaire)
    formData.append('pays_id', step1Data.pays_id || '1')

    // 3. Ajout des données de l'étape 2
    formData.append('annees_experience', form.value.experience)
    formData.append('niveau_etude', form.value.niveau)
    formData.append('description_experience', form.value.description)
    formData.append('password', form.value.password)
    formData.append('password_confirmation', form.value.password_confirmation)

    // 4. Gestion des Tableaux (Spécialités & Compétences)
    // ⚠️ IMPORTANT : Si Laravel attend "specialite_id" (un seul), il faut prendre form.value.domaines[0]
    // Ici, je suppose que tu envoies une chaine de caractères comme avant, 
    // mais si ça plante, dis-le moi pour changer en tableau [].
    formData.append('specialite', form.value.domaines.join(', ')) 
    formData.append('competences', form.value.competences.join(', '))

    // 5. Ajout du fichier
    if (cvFile.value) {
        formData.append('cv', cvFile.value)
    }

    console.log("🚀 Envoi vers Laravel...")

    const response = await $fetch('http://localhost:8000/api/auth/register/formateur', {
        method: 'POST',
        body: formData
    })

    console.log("✅ Succès:", response)
    
    localStorage.removeItem('formateurStep1')
    alert('Compte créé avec succès ! Connectez-vous.')
    
    if (response.access_token) {
        // Optionnel : Connexion automatique
        // localStorage.setItem('token', response.access_token)
    }
    router.push('/auth/success') // Redirection vers la page success 

  } catch (error) {
    console.error("❌ Erreur capture:", error)
    
    let msg = "Une erreur inconnue est survenue."

    if (error.data && error.data.errors) {
      // Formater les erreurs Laravel pour l'affichage
      msg = Object.values(error.data.errors).flat().join('\n')
      // AFFICHER L'ALERTE POUR QUE TU SACHES EXACTEMENT CE QUI BLOQUE
      alert("Erreur de validation Laravel :\n" + JSON.stringify(error.data.errors, null, 2))
    } else if (error.data && error.data.message) {
      msg = error.data.message
      alert("Erreur serveur : " + msg)
    } else {
      alert("Erreur technique : " + error.message)
    }

    errorMessage.value = msg
  } finally {
    loading.value = false
  }
}
</script>