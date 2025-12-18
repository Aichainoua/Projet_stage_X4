<template>
  <div class="relative max-w-md mx-auto mt-4 overflow-hidden bg-white border border-gray-100 shadow-lg rounded-2xl">
    
    <div class="flex items-center justify-center p-8 bg-indigo-900">
       <svg class="w-24 h-24 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
    </div>

    <div class="p-6">
      <div class="flex items-start justify-between mb-2">
        <span class="px-3 py-1 text-xs font-bold text-gray-600 bg-gray-100 rounded-full">Intermediaire</span>
        <span class="text-xl font-bold text-gray-900">75000 FCFA</span>
      </div>

      <h1 class="mb-2 text-xl font-bold text-gray-900">Developpeur front-end</h1>
      <p class="pb-4 mb-6 text-sm text-gray-500 border-b border-gray-100">
        Apprenez a créer des interfaces avec tailwind, javascripts...
      </p>

      <div class="mb-6">
        <p class="mb-1 text-xs font-bold text-gray-500">Formateur</p>
        <p class="text-sm font-medium text-gray-900">Aicha Inoua</p>
      </div>

      <div class="flex items-center justify-between px-4 mb-8">
        <div class="text-center">
          <svg class="w-6 h-6 mx-auto mb-1 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
          <span class="block text-xs font-bold">1 cours</span>
        </div>
        <div class="text-center">
          <svg class="w-6 h-6 mx-auto mb-1 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
          <span class="block text-xs font-bold">6h Total</span>
        </div>
        <div class="text-center">
          <svg class="w-6 h-6 mx-auto mb-1 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
          <span class="block text-xs font-bold">1 session</span>
        </div>
      </div>

      <button @click="showPayment = true" class="w-full py-3 font-bold text-white transition bg-indigo-900 rounded-lg shadow-lg hover:bg-indigo-800">
        S'inscrire et payer
      </button>
    </div>

    <div v-if="showPayment" class="absolute inset-0 z-50 flex flex-col p-6 bg-white animate-fade-in">
      <h3 class="mb-6 text-lg font-bold">Payer la formation</h3>

      <div class="flex items-center gap-4 p-3 mb-8 rounded-lg bg-gray-50">
         <div class="flex items-center justify-center w-12 h-12 text-white bg-indigo-700 rounded">
           <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
         </div>
         <div class="flex-1">
           <p class="text-sm font-bold text-gray-900">Développement frontend</p>
           <p class="text-xs text-gray-500 uppercase">AICHA INOUA</p>
         </div>
         <span class="px-3 py-1 text-xs font-bold text-white bg-indigo-600 rounded-full">32.000</span>
      </div>

      <p class="mb-4 text-sm text-gray-600">Selectionnez un moyen de paiement</p>

      <div class="mb-8 space-y-4">
        <button class="flex items-center justify-center w-full gap-3 py-4 font-bold text-gray-800 transition bg-gray-200 rounded-lg hover:bg-gray-300">
          <span class="w-6 h-4 border border-orange-500 rounded-sm"></span> orange Money
        </button>
        <button class="flex items-center justify-center w-full gap-3 py-4 font-bold text-gray-800 transition bg-gray-200 rounded-lg hover:bg-gray-300">
          <span class="w-6 h-4 border border-yellow-400 rounded-sm"></span> MTN Mobile Money
        </button>
      </div>

      <div class="flex gap-4 mt-auto">
        <button class="flex items-center justify-center flex-1 gap-2 py-3 font-bold text-white bg-indigo-700 rounded-lg">
           <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
           Payer 32 000 FCFA
        </button>
        <button @click="showPayment = false" class="px-6 py-3 font-bold text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">
           Annuler
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
definePageMeta({ layout: 'apprenant' })
const showPayment = ref(false)
</script>