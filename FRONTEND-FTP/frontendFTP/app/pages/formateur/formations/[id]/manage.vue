<template>
  <div>
    <div class="flex items-center gap-4 mb-6">
       <button class="text-gray-400">←</button>
       [cite_start]<h2 class="text-xl font-bold text-gray-900">Developpement front-end [cite: 27]</h2>
    </div>

    <div class="flex items-center justify-between mb-6">
      <div class="inline-flex p-1 bg-gray-200 rounded-full">
        <button class="px-6 py-2 text-sm font-bold text-gray-900 bg-white rounded-full shadow-sm">Cours</button>
        <button class="px-6 py-2 text-sm font-medium text-gray-500 hover:text-gray-700">Etudiants inscrits</button>
        <button class="px-6 py-2 text-sm font-medium text-gray-500 hover:text-gray-700">Sessions de tutorat</button>
        <button class="px-6 py-2 text-sm font-medium text-gray-500 hover:text-gray-700">Informations</button>
      </div>
      
      <button @click="showSessionModal = true" class="px-4 py-2 text-sm font-bold text-white transition bg-indigo-800 rounded-lg hover:bg-indigo-900">
        + Ajouter un cours
      </button>
    </div>

    <div class="grid grid-cols-2 gap-6">
       <div v-for="i in 2" :key="i" class="p-6 bg-white border border-gray-100 rounded-lg shadow-sm">
         <h3 class="mb-2 font-bold text-gray-900">Introduction a Tailwind css</h3>
         <p class="mb-8 text-sm text-gray-500">Découvrez les Tailwind css et utiliser css faciliment pour designer vos interfaces</p>
         <button class="w-full py-2 font-bold text-gray-800 bg-gray-100 rounded">Gérer le cours</button>
       </div>
    </div>

    <div v-if="showSessionModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-sm">
      <div class="w-full max-w-md p-6 bg-white shadow-2xl rounded-xl">
        <h3 class="text-xl font-bold text-gray-900">Nom du cours</h3>
        <p class="mb-6 text-sm text-gray-500">Nouvelle session</p>

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
               <label class="block mb-1 text-sm font-bold text-gray-800">Heure debut</label>
               <input type="time" class="w-full px-3 py-2 bg-gray-200 border-none rounded-lg">
             </div>
             <div class="w-1/4">
               <label class="block mb-1 text-sm font-bold text-gray-800">Heure fin</label>
               <input type="time" class="w-full px-3 py-2 bg-gray-200 border-none rounded-lg">
             </div>
          </div>

          <div>
             <label class="block mb-1 text-sm font-bold text-gray-800">Type de session</label>
             <input type="text" class="w-full px-3 py-2 bg-gray-200 border-none rounded-lg">
          </div>

          <div>
             <label class="block mb-1 text-sm font-bold text-gray-800">Lien de la session</label>
             <input type="url" class="w-full px-3 py-2 bg-gray-200 border-none rounded-lg">
          </div>

          <div class="flex justify-end gap-3 mt-6">
            <button type="button" @click="showSessionModal = false" class="px-4 py-2 font-bold text-gray-800 bg-gray-100 rounded-lg">Annuler</button>
            <button class="px-4 py-2 font-bold text-white bg-indigo-700 rounded-lg hover:bg-indigo-800">Ajouter une session</button>
          </div>
        </form>
      </div>
    </div>

  </div>
</template>

<script setup>
definePageMeta({ layout: 'formateur' })
const showSessionModal = ref(false)
</script>