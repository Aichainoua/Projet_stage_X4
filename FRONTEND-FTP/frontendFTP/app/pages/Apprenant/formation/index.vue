<template>
  <div>
    <h2 class="mb-6 text-xl font-bold text-gray-900">Mes formations</h2>

    <div class="overflow-hidden bg-white border border-gray-200 rounded-lg shadow-sm">
      <table class="w-full text-left border-collapse">
        <thead class="text-xs font-bold text-gray-500 uppercase border-b border-gray-200 bg-gray-50">
          <tr>
            <th class="px-6 py-4">Formation</th>
            <th class="px-6 py-4">Formateur</th>
            <th class="px-6 py-4">Durée</th>
            <th class="px-6 py-4">Prix</th>
            <th class="px-6 py-4">Niveau</th>
            <th class="px-6 py-4">Cours</th>
            <th class="px-6 py-4 text-center">Action</th>
          </tr>
        </thead>
        <tbody class="text-sm divide-y divide-gray-100">
          <tr class="transition hover:bg-gray-50" v-for="i in 3" :key="i">
            <td class="px-6 py-4 font-bold text-gray-800 uppercase">DEVELOPPEMENT FRONTEND</td>
            <td class="px-6 py-4 font-medium text-gray-600">AICHA INOUA</td>
            <td class="px-6 py-4">6h</td>
            <td class="px-6 py-4">32000</td>
            <td class="px-6 py-4">intermediaire</td>
            <td class="px-6 py-4">3</td>
            <td class="px-6 py-4 text-center">
              <NuxtLink to="/apprenant/formations/1" class="inline-flex items-center justify-center">
                <svg class="w-6 h-6 text-gray-900 cursor-pointer hover:text-indigo-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
              </NuxtLink>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup>
definePageMeta({ layout: 'apprenant' })
</script>