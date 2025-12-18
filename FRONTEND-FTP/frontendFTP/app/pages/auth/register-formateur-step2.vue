<template>
  <div class="flex items-center justify-center min-h-screen p-4 bg-gray-50">
    <div class="w-full max-w-md p-8 bg-white rounded-lg shadow-lg">
      
      <div class="flex items-center gap-3 mb-6">
        <div class="flex items-center justify-center w-12 h-12 bg-indigo-700 rounded-lg">
          <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
          </svg>
        </div>
        <div>
          <h1 class="text-2xl font-bold text-gray-800">EDULAB AFRIK</h1>
          <span class="text-xs font-semibold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded">FORMATEUR</span>
        </div>
      </div>

      <div class="flex items-center justify-between mb-6">
        <h2 class="text-lg font-semibold text-gray-700">Profil Professionnel</h2>
        <span class="text-sm font-medium text-gray-500">Étape 2/2</span>
      </div>
      
      <div class="w-full h-2 mb-6 bg-gray-200 rounded-full">
        <div class="h-2 bg-indigo-700 rounded-full" style="width: 100%"></div>
      </div>

      <form @submit.prevent="handleSubmit" class="space-y-4">
        
        <div>
          <label class="block mb-1 text-sm font-medium text-gray-700">Domaine d'expertise</label>
          <input
            v-model="form.specialite"
            type="text"
            placeholder="Ex: Développement Web, Marketing..."
            class="w-full px-4 py-2.5 bg-gray-100 border-0 rounded-lg focus:ring-2 focus:ring-indigo-700 focus:bg-white transition text-sm"
            required
          />
        </div>

        <div>
          <label class="block mb-1 text-sm font-medium text-gray-700">Années d'expérience</label>
          <input
            v-model="form.experience"
            type="number"
            min="0"
            placeholder="Ex: 5"
            class="w-full px-4 py-2.5 bg-gray-100 border-0 rounded-lg focus:ring-2 focus:ring-indigo-700 focus:bg-white transition text-sm"
            required
          />
        </div>

        <div>
          <label class="block mb-1 text-sm font-medium text-gray-700">Pays de résidence</label>
          <select 
            v-model="form.pays_id"
            class="w-full px-4 py-2.5 bg-gray-100 border-0 rounded-lg focus:ring-2 focus:ring-indigo-700 focus:bg-white transition text-sm"
            required
          >
            <option value="" disabled selected>Choisir un pays</option>
            <option value="1">Cameroun</option>
            <option value="2">France</option>
            <option value="3">Sénégal</option>
          </select>
        </div>

        <div>
          <label class="block mb-1 text-sm font-medium text-gray-700">Courte Biographie</label>
          <textarea
            v-model="form.biographie"
            rows="3"
            placeholder="Décrivez votre parcours en quelques mots..."
            class="w-full px-4 py-2.5 bg-gray-100 border-0 rounded-lg focus:ring-2 focus:ring-indigo-700 focus:bg-white transition text-sm"
          ></textarea>
        </div>

        <div>
          <label class="block mb-1 text-sm font-medium text-gray-700">CV (Format PDF)</label>
          <input
            type="file"
            @change="handleFileUpload"
            accept=".pdf"
            class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
            required
          />
          <p class="mt-1 text-xs text-gray-500">Maximum 2 Mo.</p>
        </div>

        <div v-if="error" class="p-3 text-sm text-red-700 whitespace-pre-line border border-red-200 rounded-lg bg-red-50">
          {{ error }}
        </div>

        <div class="flex gap-3 mt-6">
            <button
                type="button"
                @click="navigateTo('/register-formateur-step1')"
                class="flex-1 py-3 font-semibold text-gray-700 transition bg-gray-200 rounded-lg hover:bg-gray-300"
            >
                Retour
            </button>
            <button
                type="submit"
                :disabled="loading"
                class="flex-1 py-3 font-semibold text-white transition duration-200 bg-indigo-700 rounded-lg hover:bg-indigo-800 disabled:opacity-50 disabled:cursor-not-allowed"
            >
                {{ loading ? 'Envoi...' : 'Terminer' }}
            </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
const loading = ref(false)
const error = ref('')
const cvFile = ref(null)

const form = ref({
  specialite: '',
  experience: '',
  biographie: '',
  pays_id: '',
})

// Gestion du fichier
const handleFileUpload = (event) => {
  const file = event.target.files[0]
  if (file && file.type === 'application/pdf') {
    cvFile.value = file
  } else {
    alert('Veuillez sélectionner un fichier PDF valide.')
    event.target.value = null // Reset input
    cvFile.value = null
  }
}

const handleSubmit = async () => {
  loading.value = true
  error.value = ''

  try {
    // 1. Récupération des données de l'étape 1 (Stockées dans le LocalStorage par exemple)
    const step1DataString = localStorage.getItem('register_formateur_step1')
    
    if (!step1DataString) {
        throw new Error("Les données de l'étape 1 sont manquantes. Veuillez recommencer.")
    }
    
    const step1Data = JSON.parse(step1DataString)

    // 2. Création de l'objet FormData (Obligatoire pour envoyer des fichiers)
    const formData = new FormData()

    // Ajout données Etape 1
    formData.append('nom', step1Data.nom)
    formData.append('prenom', step1Data.prenom)
    formData.append('email', step1Data.email)
    formData.append('password', step1Data.password)
    formData.append('telephone', step1Data.telephone || '')

    // Ajout données Etape 2
    formData.append('specialite', form.value.specialite)
    formData.append('annees_experience', form.value.experience)
    formData.append('biographie', form.value.biographie)
    formData.append('pays_id', form.value.pays_id)

    // Ajout du fichier CV
    if (cvFile.value) {
        formData.append('cv', cvFile.value)
    }

    // 3. Envoi au Backend
    const response = await $fetch('http://127.0.0.1:8000/api/auth/register/formateur', {
        method: 'POST',
        body: formData
        // Note: Ne PAS mettre de header 'Content-Type': 'application/json' avec FormData, 
        // $fetch le gère automatiquement.
    })

    // 4. Succès -> Nettoyage et Redirection page Succès
    localStorage.removeItem('register_formateur_step1') // On nettoie
    
    // Redirection vers la page de félicitations
    await navigateTo('/inscription-succes')

  } catch (err) {
    console.error(err)
    if (err.response?._data?.errors) {
        const msgs = Object.values(err.response._data.errors).flat().join('\n')
        error.value = msgs
    } else if (err.message) {
        error.value = err.message
    } else {
        error.value = "Une erreur est survenue lors de l'enregistrement."
    }
  } finally {
    loading.value = false
  }
}
</script>