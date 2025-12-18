<template>
  <div>
    <div class="flex items-center justify-between mb-8">
      <div>
        [cite_start]<h2 class="text-xl font-bold text-gray-900">Mes Formations [cite: 24]</h2>
        <p class="text-sm text-gray-500">Gerez vos formations et cours</p>
      </div>
      <NuxtLink to="/formateur/formations/create" class="flex items-center gap-2 px-6 py-3 font-bold text-white transition bg-indigo-800 rounded-lg shadow hover:bg-indigo-900">
        <span class="text-xl leading-none">+</span> Nouvelle Formation
      </NuxtLink>
    </div>

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-2">
      <div v-for="i in 2" :key="i" class="flex flex-col p-6 bg-white border border-gray-100 shadow-sm rounded-xl">
         <h3 class="mb-2 font-bold text-gray-900">Developpement web front-end</h3>
         <p class="mb-6 text-sm text-gray-500">Apprenez a faire les interfaces avec avec javascripts, tailwing css..</p>
         
         <div class="flex justify-end mb-4">
            <span class="flex items-center gap-1 text-xs font-bold text-gray-600">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
              2 COURS
            </span>
         </div>

         <div class="flex items-center justify-between pt-4 mt-auto border-t border-gray-100">
            <span class="font-bold text-indigo-600">75000 FCFA</span>
            <span class="px-3 py-1 text-xs font-bold text-gray-600 bg-gray-100 rounded-full">Intermediaire</span>
         </div>
         
         <NuxtLink to="/formateur/formations/1/manage" class="w-full py-3 mt-4 font-bold text-center text-gray-900 transition bg-gray-100 rounded-lg hover:bg-gray-200">
           Gérer la formation
         </NuxtLink>
      </div>
    </div>
  </div>
</template>

<script setup>
definePageMeta({ layout: 'Formateur' })
</script>