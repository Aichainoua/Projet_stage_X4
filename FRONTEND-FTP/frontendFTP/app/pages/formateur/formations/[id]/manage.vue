<template>
  <div>
    <div class="flex items-center gap-4 mb-6">
       <button @click="navigateTo('/formateur/formations')" class="text-gray-400 hover:text-gray-600">← Retour</button>
       <h2 class="text-xl font-bold text-gray-900">Developpement front-end</h2>
    </div>

    <div class="flex items-center justify-between mb-6">
      <div class="inline-flex p-1 bg-gray-200 rounded-full">
        
        <button 
          @click="activeTab = 'cours'" 
          :class="[
            'px-6 py-2 text-sm rounded-full transition-all duration-200', 
            activeTab === 'cours' ? 'bg-white font-bold text-gray-900 shadow-sm' : 'font-medium text-gray-500 hover:text-gray-700'
          ]"
        >
          Cours
        </button>

        <button 
          @click="activeTab = 'etudiants'" 
          :class="[
            'px-6 py-2 text-sm rounded-full transition-all duration-200', 
            activeTab === 'etudiants' ? 'bg-white font-bold text-gray-900 shadow-sm' : 'font-medium text-gray-500 hover:text-gray-700'
          ]"
        >
          Etudiants inscrits
        </button>

        <button 
          @click="activeTab = 'sessions'" 
          :class="[
            'px-6 py-2 text-sm rounded-full transition-all duration-200', 
            activeTab === 'sessions' ? 'bg-white font-bold text-gray-900 shadow-sm' : 'font-medium text-gray-500 hover:text-gray-700'
          ]"
        >
          Sessions de tutorat
        </button>

        <button 
          @click="activeTab = 'infos'" 
          :class="[
            'px-6 py-2 text-sm rounded-full transition-all duration-200', 
            activeTab === 'infos' ? 'bg-white font-bold text-gray-900 shadow-sm' : 'font-medium text-gray-500 hover:text-gray-700'
          ]"
        >
          Informations
        </button>
      </div>
      
      <div>
        <button 
          v-if="activeTab === 'cours'"
          class="px-4 py-2 text-sm font-bold text-white transition bg-indigo-800 rounded-lg hover:bg-indigo-900"
        >
          + Ajouter un chapitre
        </button>

        <button 
          v-if="activeTab === 'sessions'"
          @click="showSessionModal = true" 
          class="px-4 py-2 text-sm font-bold text-white transition bg-indigo-800 rounded-lg hover:bg-indigo-900"
        >
          + Planifier une session
        </button>
      </div>
    </div>

    <div v-if="activeTab === 'cours'" class="grid grid-cols-2 gap-6">
       <div v-for="i in 2" :key="i" class="p-6 bg-white border border-gray-100 rounded-lg shadow-sm hover:shadow-md transition">
         <div class="flex justify-between mb-2">
            <h3 class="font-bold text-gray-900">Introduction a Tailwind css</h3>
            <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded">Publié</span>
         </div>
         <p class="mb-8 text-sm text-gray-500">Découvrez les Tailwind css et utiliser css faciliment pour designer vos interfaces</p>
         <div class="flex gap-2">
             <button class="flex-1 py-2 text-sm font-bold text-gray-700 bg-gray-100 rounded hover:bg-gray-200">Modifier</button>
             <button class="flex-1 py-2 text-sm font-bold text-indigo-700 bg-indigo-50 rounded hover:bg-indigo-100">Voir le contenu</button>
         </div>
       </div>
    </div>

    <div v-if="activeTab === 'etudiants'" class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Liste des étudiants (12)</h3>
        <table class="w-full text-left">
            <thead>
                <tr class="text-gray-500 text-sm border-b">
                    <th class="pb-3">Nom</th>
                    <th class="pb-3">Date d'inscription</th>
                    <th class="pb-3">Progression</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="n in 3" :key="n" class="border-b last:border-0">
                    <td class="py-4 font-medium">Jean Dupont</td>
                    <td class="py-4 text-gray-500">22 Oct 2023</td>
                    <td class="py-4 text-indigo-600 font-bold">45%</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div v-if="activeTab === 'sessions'">
       <div class="text-center py-10 bg-white border border-dashed border-gray-300 rounded-lg">
           <p class="text-gray-500 mb-2">Aucune session programmée pour le moment.</p>
           <button @click="showSessionModal = true" class="text-indigo-600 font-bold hover:underline">Planifier une session maintenant</button>
       </div>
    </div>

    <div v-if="activeTab === 'infos'" class="bg-white p-8 rounded-lg border border-gray-100 shadow-sm max-w-2xl">
        <form class="space-y-4">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Titre de la formation</label>
                <input type="text" value="Developpement front-end" class="w-full p-2 border rounded bg-gray-50">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1">Description</label>
                <textarea class="w-full p-2 border rounded bg-gray-50" rows="4">Formation complète sur Vue.js et Tailwind.</textarea>
            </div>
            <button class="px-4 py-2 bg-indigo-800 text-white rounded font-bold">Enregistrer les modifications</button>
        </form>
    </div>


    <div v-if="showSessionModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-sm">
      <div class="w-full max-w-md p-6 bg-white shadow-2xl rounded-xl">
        <h3 class="text-xl font-bold text-gray-900">Nouvelle session</h3>
        <p class="mb-6 text-sm text-gray-500">Planifier une rencontre en direct</p>

        <form class="space-y-4">
          <div>
             <label class="block mb-1 text-sm font-bold text-gray-800">Titre de la session</label>
             <input type="text" class="w-full px-3 py-2 bg-gray-200 border-none rounded-lg">
          </div>
          
          <div class="flex gap-3">
             <div class="flex-1">
               <label class="block mb-1 text-sm font-bold text-gray-800">Date</label>
               <input type="date" class="w-full px-3 py-2 bg-gray-200 border-none rounded-lg">
             </div>
             <div class="w-1/4">
               <label class="block mb-1 text-sm font-bold text-gray-800">Début</label>
               <input type="time" class="w-full px-3 py-2 bg-gray-200 border-none rounded-lg">
             </div>
             <div class="w-1/4">
               <label class="block mb-1 text-sm font-bold text-gray-800">Fin</label>
               <input type="time" class="w-full px-3 py-2 bg-gray-200 border-none rounded-lg">
             </div>
          </div>

          <div>
             <label class="block mb-1 text-sm font-bold text-gray-800">Lien de la réunion (Meet/Zoom)</label>
             <input type="url" class="w-full px-3 py-2 bg-gray-200 border-none rounded-lg">
          </div>

          <div class="flex justify-end gap-3 mt-6">
            <button type="button" @click="showSessionModal = false" class="px-4 py-2 font-bold text-gray-800 bg-gray-100 rounded-lg">Annuler</button>
            <button class="px-4 py-2 font-bold text-white bg-indigo-700 rounded-lg hover:bg-indigo-800">Créer la session</button>
          </div>
        </form>
      </div>
    </div>

  </div>
</template>

<script setup>
definePageMeta({ layout: 'formateur' })

// 1. Variable pour savoir quel onglet est actif (par défaut 'cours')
const activeTab = ref('cours')

// 2. Variable pour la modale
const showSessionModal = ref(false)
</script>