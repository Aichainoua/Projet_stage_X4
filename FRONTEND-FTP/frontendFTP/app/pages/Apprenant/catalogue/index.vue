<template>
  <div>
    <h2 class="mb-1 text-2xl font-bold text-gray-900">Catalogue de formations</h2>
    <p class="mb-6 text-gray-500">Découvrez nos formations tutorées et en autonomie</p>

    <div class="flex items-center p-2 mb-8 bg-white border border-gray-200 rounded-lg shadow-sm">
      <svg class="w-5 h-5 ml-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
      <input type="text" placeholder="Rechercher une formation" class="w-full px-4 py-2 text-gray-700 bg-transparent outline-none">
      <button class="flex items-center gap-2 px-4 py-2 font-medium text-gray-500 rounded hover:bg-gray-50">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
        Filtres
      </button>
    </div>

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
      <div v-for="course in courses" :key="course.id" class="flex flex-col overflow-hidden transition bg-white border border-gray-100 shadow-sm rounded-xl hover:shadow-md">
        
        <div class="relative flex items-center justify-center h-40 bg-indigo-900">
          <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
          <span v-if="course.isTutored" class="absolute flex items-center gap-1 px-2 py-1 text-xs font-bold text-indigo-900 rounded top-3 right-3 bg-white/90">
             <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
             tutorée
          </span>
        </div>

        <div class="flex flex-col flex-1 p-5">
          <div class="flex gap-2 mb-2">
            <span class="px-2 py-1 text-xs font-medium text-gray-600 bg-gray-100 rounded-full">{{ course.level }}</span>
            [cite_start]<span v-if="course.isRegistered" class="px-2 py-1 text-xs font-bold text-gray-800 bg-gray-100 rounded-full">Inscrit [cite: 17]</span>
          </div>

          <h3 class="mb-1 font-bold text-gray-900">{{ course.title }}</h3>
          <p class="mb-4 text-xs text-gray-500 line-clamp-2">{{ course.desc }}</p>

          <div class="mt-auto">
             <p class="mb-2 text-sm font-bold text-gray-800">{{ course.author }} <span class="font-normal text-gray-400">Mentor</span></p>
             <div class="flex items-center justify-between pt-3 border-t border-gray-100">
               <span class="font-bold text-gray-900">{{ course.price }} FCFA</span>
               
               <NuxtLink :to="`/apprenant/catalogue/${course.id}`" class="px-4 py-2 text-xs font-bold text-white transition bg-indigo-900 rounded hover:bg-indigo-800">
                 Voir les détails
               </NuxtLink>
             </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
definePageMeta({ layout: 'apprenant' })
const courses = ref([
  { id: 1, title: 'Developpeur front-end', desc: 'Apprenez a créer des interfaces avec tailwind, javascripts...', price: 75000, level: 'Intermediaire', author: 'Jully Makogne', isTutored: true, isRegistered: true },
  { id: 2, title: 'Developpeur Back-end', desc: 'Apprenez Node.js et Express...', price: 75000, level: 'Intermediaire', author: 'Jully Makogne', isTutored: false, isRegistered: false },
  { id: 3, title: 'Design UI/UX', desc: 'Maitrisez Figma et les concepts UX...', price: 75000, level: 'Intermediaire', author: 'Jully Makogne', isTutored: false, isRegistered: false },
])
</script>