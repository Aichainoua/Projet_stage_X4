<script setup>
definePageMeta({ layout: 'formateur' })
const user = useCookie('user')
</script>

<template>
  <div>
    <h1 class="mb-2 text-2xl font-bold">Tableau de bord Formateur</h1>
    <p class="mb-8 text-gray-500">Bienvenue, {{ user?.name }}</p>

    <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-4">
      <div class="p-6 bg-white border-l-4 border-indigo-600 shadow-sm rounded-xl">
        <p class="text-sm text-gray-500">Total Étudiants</p>
        <p class="text-3xl font-bold">128</p>
      </div>
      <div class="p-6 bg-white border-l-4 border-green-500 shadow-sm rounded-xl">
        <p class="text-sm text-gray-500">Revenus ce mois</p>
        <p class="text-3xl font-bold">450K</p>
      </div>
      <div class="p-6 bg-white border-l-4 border-purple-500 shadow-sm rounded-xl">
        <p class="text-sm text-gray-500">Formations actives</p>
        <p class="text-3xl font-bold">4</p>
      </div>
      <div class="p-6 bg-white border-l-4 border-orange-500 shadow-sm rounded-xl">
        <p class="text-sm text-gray-500">Sessions à venir</p>
        <p class="text-3xl font-bold">2</p>
      </div>
    </div>

    <div class="p-6 bg-white border shadow-sm rounded-xl">
        <h3 class="mb-4 font-bold">Derniers inscrits</h3>
        <p class="italic text-gray-500">Tableau des dernières inscriptions...</p>
    </div>
  </div>
</template>