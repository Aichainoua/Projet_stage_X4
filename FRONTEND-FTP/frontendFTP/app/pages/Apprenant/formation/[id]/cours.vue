<script setup>
// Exemple de données reçues de l'API
const currentResource = ref({
  id: 1,
  title: "Les bases de Tailwind",
  type: "video", // ou 'pdf'
  url: "https://example.com/video.mp4" // ou lien PDF
})
</script>

<template>
  <div class="flex h-[calc(100vh-100px)] gap-6">
    <div class="w-1/4 p-4 overflow-y-auto bg-white rounded-lg shadow">
      <h3 class="mb-4 font-bold">Plan du cours</h3>
      </div>

    <div class="flex flex-col w-3/4 p-6 bg-white rounded-lg shadow">
      <h2 class="mb-4 text-2xl font-bold">{{ currentResource.title }}</h2>

      <div class="flex items-center justify-center flex-1 overflow-hidden bg-gray-100 border rounded-lg">
        
        <div v-if="currentResource.type === 'video'" class="w-full h-full">
          <video controls class="object-contain w-full h-full">
            <source :src="currentResource.url" type="video/mp4">
            Votre navigateur ne supporte pas la vidéo.
          </video>
          </div>

        <div v-else-if="currentResource.type === 'pdf'" class="w-full h-full">
          <iframe :src="currentResource.url" class="w-full h-full"></iframe>
          <div class="p-4 text-center">
            <a :href="currentResource.url" target="_blank" class="text-indigo-700 underline">
              Télécharger le PDF si l'affichage échoue
            </a>
          </div>
        </div>

      </div>

      <div class="flex justify-between mt-4">
        <button class="px-4 py-2 text-gray-700 bg-gray-200 rounded">Précédent</button>
        <button class="px-4 py-2 text-white bg-indigo-700 rounded">Marquer comme terminé</button>
      </div>
    </div>
  </div>
</template>