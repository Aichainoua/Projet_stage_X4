<template>
  <div class="flex flex-col h-full">
    <h2 class="mb-6 text-xl font-bold text-gray-900">Developpent Frontend</h2>

    <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
      
      <div class="bg-white border border-gray-200 rounded-lg shadow-sm lg:col-span-1 h-fit">
         <div class="px-6 py-4 font-bold border-b border-gray-200 bg-gray-50">Programme</div>
         <div class="divide-y divide-gray-100">
           <div 
             v-for="(chapter, idx) in chapters" 
             :key="idx" 
             class="flex items-center justify-between px-6 py-4 cursor-pointer hover:bg-gray-50"
             :class="{'bg-indigo-50 border-l-4 border-indigo-900': currentChapter.id === chapter.id}"
             @click="currentChapter = chapter"
           >
             <span class="text-sm font-medium text-gray-800">{{ chapter.title }}</span>
             <div class="flex items-center gap-3">
               <span class="text-xs text-gray-500">{{ chapter.duration }}</span>
               <svg class="w-5 h-5 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
             </div>
           </div>
         </div>
      </div>

      <div class="lg:col-span-2">
         <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
            <h3 class="flex items-center gap-2 mb-4 text-lg font-bold">
              Ressource du cours
              <span class="px-2 py-1 text-xs bg-gray-200 rounded">{{ currentChapter.type }}</span>
            </h3>

            <div class="flex items-center justify-center w-full overflow-hidden bg-black rounded-lg aspect-video">
              
              <video v-if="currentChapter.type === 'Vidéo'" controls class="w-full h-full" src="https://www.w3schools.com/html/mov_bbb.mp4">
                Votre navigateur ne supporte pas la vidéo.
              </video>

              <iframe v-else-if="currentChapter.type === 'PDF'" src="https://pdfobject.com/pdf/sample.pdf" class="w-full h-full bg-white"></iframe>

            </div>

            <div class="flex justify-end mt-4">
               <button class="px-4 py-2 text-sm font-bold text-gray-700 bg-gray-200 rounded">Terminé</button>
            </div>
         </div>
      </div>

    </div>
  </div>
</template>

<script setup>
definePageMeta({ layout: 'apprenant' })

const chapters = [
  { id: 1, title: 'Tailwing css intro', duration: '3h', type: 'Vidéo' },
  { id: 2, title: 'Installation', duration: '3h', type: 'PDF' },
  { id: 3, title: 'Les bases de tailwing', duration: '3h', type: 'Vidéo' },
]
const currentChapter = ref(chapters[2]) // Par défaut sur la vidéo "Bases" comme source 22
</script>