<template>
  <div class="min-h-screen p-8 bg-gray-50">
    <h1 class="mb-8 text-2xl font-bold text-gray-900">Developpent Frontend</h1>

    <div class="mb-8 overflow-hidden bg-white rounded-lg shadow-sm">
      <table class="w-full text-left">
        <thead class="border-b">
          <tr>
            <th class="px-6 py-3 font-semibold text-gray-900 uppercase">COURS</th>
            <th class="px-6 py-3 font-semibold text-gray-900">Durée</th>
            <th class="px-6 py-3 font-semibold text-gray-900">Progression</th>
            <th class="px-6 py-3 font-semibold text-gray-900">Action</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
          <tr v-for="(cours, index) in courses" :key="index">
            <td class="px-6 py-4 text-gray-900">Tailwing css</td>
            <td class="px-6 py-4 text-gray-900">3h</td>
            <td class="px-6 py-4">
              <div v-if="index === 0" class="w-24 h-4 bg-gray-200 rounded"></div>
              <button v-else-if="index === 1" class="px-3 py-1 text-xs font-bold text-gray-700 bg-gray-200 rounded">Acceder</button>
              <span v-else>3</span>
            </td>
            <td class="px-6 py-4">
               <button @click="openResource(cours)" class="text-black hover:text-indigo-700">
                 <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <div v-if="selectedResource" class="p-6 bg-white rounded-lg shadow-sm">
      <h2 class="mb-6 text-xl font-bold">Ressources du cours</h2>
      
      <div class="mb-6">
        <div class="flex items-center justify-between pb-4 mb-4 border-b">
          <div>
            <p class="text-lg font-medium">{{ selectedResource.title }}</p>
          </div>
          <div class="flex items-center gap-8">
            <span class="flex items-center gap-2">
               <svg v-if="selectedResource.type === 'video'" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
               <svg v-else class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
               {{ selectedResource.type === 'video' ? 'Vidéo' : 'PDF' }}
            </span>
            <span class="px-3 py-1 text-sm font-medium text-gray-700 bg-gray-200 rounded-full">Termine</span>
          </div>
        </div>

        <div class="bg-gray-100 rounded-lg overflow-hidden min-h-[400px] flex items-center justify-center border">
            
            <div v-if="selectedResource.type === 'video'" class="w-full h-full p-4">
                <video controls class="w-full rounded shadow-lg">
                    <source src="movie.mp4" type="video/mp4">
                    Votre navigateur ne supporte pas la balise vidéo.
                </video>
            </div>

            <div v-else-if="selectedResource.type === 'pdf'" class="w-full h-[600px]">
                <iframe src="/dummy.pdf" class="w-full h-full" title="PDF Viewer"></iframe>
            </div>

        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
definePageMeta({ layout: 'apprenant' })

const courses = ref([
    { title: 'les bases de tailwing', type: 'video' },
    { title: 'Documentation Avancée', type: 'pdf' },
    { title: 'Tailwing css', type: 'video' }
])

const selectedResource = ref(null)

const openResource = (cours) => {
    selectedResource.value = cours
}
</script>