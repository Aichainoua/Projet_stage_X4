<template>
  <div class="flex h-screen bg-[#F5F5F5] font-sans text-slate-800">
    
    <aside class="fixed z-20 flex flex-col w-64 h-full bg-white border-r border-gray-200 shadow-sm">
      <div class="flex items-center h-20 px-6 border-b border-gray-100">
        <div class="flex items-center gap-2 text-indigo-900">
          <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
          <div>
            <h1 class="text-lg font-bold leading-tight">EDULAB AFRIK</h1>
            <p class="text-xs text-gray-500">Espace apprenant</p>
          </div>
        </div>
      </div>

      <nav class="flex-1 py-6 space-y-1">
        <NuxtLink to="/apprenant/dashboard" active-class="font-bold text-indigo-900 border-l-4 border-indigo-900 bg-indigo-50" class="flex items-center gap-3 px-6 py-3 text-gray-600 transition-colors hover:bg-gray-50">
          <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
          Accueil
        </NuxtLink>

        <NuxtLink to="/apprenant/catalogue" active-class="font-bold text-indigo-900 border-l-4 border-indigo-900 bg-indigo-50" class="flex items-center gap-3 px-6 py-3 text-gray-600 transition-colors hover:bg-gray-50">
          <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
          Catalogue
        </NuxtLink>

        <NuxtLink to="/apprenant/formations" active-class="font-bold text-indigo-900 border-l-4 border-indigo-900 bg-indigo-50" class="flex items-center gap-3 px-6 py-3 text-gray-600 transition-colors hover:bg-gray-50">
          <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z"/></svg>
          Mes formations
        </NuxtLink>
      </nav>

      <div class="p-4 mt-auto text-white bg-indigo-900">
        <button @click="logout" class="flex items-center w-full gap-3 p-2 transition rounded hover:bg-indigo-800">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
          Deconnexion
        </button>
      </div>
    </aside>

    <div class="flex flex-col flex-1 min-w-0 ml-64">
      <header class="sticky top-0 z-10 flex items-center justify-end h-20 px-8 bg-white border-b border-gray-200">
        <div class="flex items-center gap-3">
          <div class="flex items-center justify-center w-10 h-10 text-sm font-bold text-white bg-indigo-900 rounded-full">AI</div>
          <div class="leading-tight text-right">
            <p class="text-sm font-bold text-gray-900">AICHA INOUA</p>
            <p class="text-xs text-gray-500 uppercase">Apprenant</p>
          </div>
        </div>
      </header>

      <main class="flex-1 p-8 overflow-y-auto">
        <slot />
      </main>
    </div>
  </div>
</template>

<script setup>
const router = useRouter()
const logout = () => {
  // Logique de déconnexion ici (clear tokens, etc.)
  router.push('/')
}
</script>