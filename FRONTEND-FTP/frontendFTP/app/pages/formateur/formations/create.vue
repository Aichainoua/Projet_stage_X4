<template>
  <div class="flex items-start justify-center pt-10">
    <div class="w-full max-w-lg p-8 bg-white border border-gray-100 shadow-lg rounded-xl">
      <h2 class="mb-1 text-xl font-bold text-gray-900">créer une nouvelle formation </h2>
      <p class="mb-6 text-sm text-gray-500">Remplir les information de base de votre fomation</p>

      <form class="space-y-5">
        <div>
          <label class="block mb-2 text-sm font-bold text-gray-800">Titre de la formation</label>
          <input type="text" class="w-full px-4 py-3 bg-gray-200 border-none rounded-lg focus:ring-2 focus:ring-indigo-500">
        </div>

        <div>
          <label class="block mb-2 text-sm font-bold text-gray-800">Description</label>
          <textarea rows="4" class="w-full px-4 py-3 bg-gray-200 border-none rounded-lg focus:ring-2 focus:ring-indigo-500"></textarea>
        </div>

        <div class="flex gap-4">
          <div class="flex-1">
             <label class="block mb-2 text-sm font-bold text-gray-800">Categorie</label>
             <select class="w-full px-4 py-3 bg-gray-200 border-none rounded-lg appearance-none"><option></option></select>
          </div>
          <div class="flex-1">
             <label class="block mb-2 text-sm font-bold text-gray-800">Niveau</label>
             <select class="w-full px-4 py-3 bg-gray-200 border-none rounded-lg appearance-none"><option></option></select>
          </div>
        </div>

        <div>
          <label class="block mb-2 text-sm font-bold text-gray-800">Prix</label>
          <input type="text" class="w-1/2 px-4 py-3 bg-gray-200 border-none rounded-lg focus:ring-2 focus:ring-indigo-500">
        </div>

        <div class="flex justify-end gap-4 mt-8">
          <button type="button" class="px-6 py-3 font-bold text-gray-800 bg-gray-100 rounded-lg">Annuler</button>
          <button class="px-6 py-3 font-bold text-white bg-indigo-700 rounded-lg shadow-md hover:bg-indigo-800">Créer la formation</button>
        </div>
      </form>
    </div>
  </div>
</template>
<script setup>
definePageMeta({ layout: 'formateur' ,
   middleware: 'auth'
})
</script>