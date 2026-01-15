<template>
  <div class="p-8 bg-[#F5F5F5] min-h-screen">
    <div class="flex items-center gap-4 mb-6">
       <button @click="navigateTo('/formateur/formations')" class="text-gray-400 hover:text-gray-600">
         <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
          </svg>
       </button>
       <h2 class="text-xl font-bold text-gray-900">Developpement front-end</h2>
    </div>

    <div class="flex items-center justify-between mb-8">
      <div class="inline-flex p-1 bg-gray-200 rounded-full">
        <button @click="activeTab = 'cours'" :class="['px-6 py-2 text-sm rounded-full transition-all', activeTab === 'cours' ? 'bg-white font-bold text-gray-900 shadow-sm' : 'font-medium text-gray-500']">Cours</button>
        <button @click="activeTab = 'etudiants'" :class="['px-6 py-2 text-sm rounded-full transition-all', activeTab === 'etudiants' ? 'bg-white font-bold text-gray-900 shadow-sm' : 'font-medium text-gray-500']">Etudiants inscrits</button>
        <button @click="activeTab = 'sessions'" :class="['px-6 py-2 text-sm rounded-full transition-all', activeTab === 'sessions' ? 'bg-white font-bold text-gray-900 shadow-sm' : 'font-medium text-gray-500']">Sessions de tutorat</button>
        <button @click="activeTab = 'infos'" :class="['px-6 py-2 text-sm rounded-full transition-all', activeTab === 'infos' ? 'bg-white font-bold text-gray-900 shadow-sm' : 'font-medium text-gray-500']">Informations</button>
      </div>
    </div>

    <div v-if="activeTab === 'etudiants'" class="animate-fade-in">
      
      <div class="mb-8">
        <div class="p-6 bg-white rounded-lg shadow-sm w-48">
           <p class="text-sm text-gray-500 mb-1">Total inscrits</p>
           <p class="text-4xl font-bold text-gray-900">2</p>
        </div>
      </div>

      <div>
        <h3 class="text-lg font-bold text-gray-900 mb-4 capitalize">Listes des étudiants</h3>
        
        <div class="overflow-hidden rounded-lg shadow-sm">
          <table class="w-full text-left bg-white border-collapse">
            <thead class="bg-[#E5E7EB]"> 
              <tr>
                <th class="p-4 text-sm font-bold text-gray-700">Etudiants</th>
                <th class="p-4 text-sm font-bold text-gray-700">Date d'inscription</th>
                <th class="p-4 text-sm font-bold text-gray-700">Statut</th>
              </tr>
            </thead>
            
            <tbody class="divide-y divide-gray-100">
               <tr class="hover:bg-gray-50 transition">
                 <td class="p-4 text-gray-900 font-medium">Aicha Inoua</td>
                 <td class="p-4 text-gray-500">12/09/2020</td>
                 <td class="p-4 text-gray-900">Actif</td>
               </tr>
               
               <tr class="hover:bg-gray-50 transition">
                 <td class="p-4 text-gray-900 font-medium">Jean Dupont</td>
                 <td class="p-4 text-gray-500">14/09/2020</td>
                 <td class="p-4 text-gray-900">Actif</td>
               </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div v-if="activeTab === 'cours'">
       <div class="p-6 bg-white border border-gray-100 rounded-lg text-center text-gray-500">
          Contenu des cours...
       </div>
    </div>

    <div v-if="activeTab === 'sessions'">
       <button @click="showSessionModal = true" class="w-full py-4 text-sm font-bold text-white transition bg-[#312E81] rounded-xl hover:bg-indigo-900 flex items-center justify-center gap-2 shadow-lg">
         <span class="text-xl">+</span> Ajouter une session
       </button>
    </div>

    <div v-if="showSessionModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm">
      <div class="w-full max-w-lg bg-white shadow-2xl rounded-2xl overflow-hidden animate-fade-in-up">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
           <h3 class="text-lg font-bold">Programmer une session</h3>
           <button @click="showSessionModal = false">✕</button>
        </div>
       <form class="p-6 space-y-5">
          
          <div>
             <label class="block mb-1.5 text-sm font-bold text-gray-700">Titre de la session</label>
             <input type="text" placeholder="Ex;Introduction a tailwing" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:bg-white transition">
          </div>
          
          <div class="grid grid-cols-3 gap-4">
             <div class="col-span-1">
               <label class="block mb-1.5 text-sm font-bold text-gray-700">Date</label>
               <input type="date" class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500">
             </div>
             <div class="col-span-1">
               <label class="block mb-1.5 text-sm font-bold text-gray-700">Début</label>
               <input type="time" class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500">
             </div>
             <div class="col-span-1">
               <label class="block mb-1.5 text-sm font-bold text-gray-700">Fin</label>
               <input type="time" class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500">
             </div>
          </div>

          <div>
             <label class="block mb-1.5 text-sm font-bold text-gray-700">Lien de la visioconférence</label>
             <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                  
                </span>
                <input type="url" placeholder="https://meet.google.com/..." class="w-full pl-10 px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:bg-white transition">
             </div>
          </div>

          <div>
             <label class="block mb-1.5 text-sm font-bold text-gray-700">Note pour les étudiants</label>
             <textarea rows="2" placeholder="Préparez vos questions..." class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:bg-white"></textarea>
          </div>

          <div class="flex gap-3 pt-4">
            <button type="button" @click="showSessionModal = false" class="flex-1 px-4 py-3 font-bold text-gray-700 bg-gray-100 rounded-xl hover:bg-gray-200 transition">
              Annuler
            </button>
            <button type="button" class="flex-1 px-4 py-3 font-bold text-white bg-[#312E81] rounded-xl hover:bg-indigo-900 shadow-md transition transform active:scale-95">
              Créer  la  session
            </button>
          </div>

        </form>
      </div>
    </div>

  </div>
</template>

<script setup>
definePageMeta({ layout: 'formateur' })

// Onglet actif par défaut sur 'etudiants' pour que tu puisses voir le résultat
const activeTab = ref('etudiants')
const showSessionModal = ref(false)
</script>

<style scoped>
.animate-fade-in {
  animation: fadeIn 0.3s ease-in;
}
@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}
</style>