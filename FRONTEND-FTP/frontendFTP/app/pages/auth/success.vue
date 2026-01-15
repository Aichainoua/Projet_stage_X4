<template>
  <div class="min-h-screen flex flex-col items-center py-10 px-4 bg-[#fcf7f7] font-sans">
    
    <div class="flex items-center w-full max-w-md mb-10">
      <svg 
        class="w-10 h-10 text-[#1a237e]" 
        fill="none" 
        stroke="currentColor" 
        viewBox="0 0 24 24" 
        xmlns="http://www.w3.org/2000/svg"
      >
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
      </svg>
      <span class="ml-3 text-[#2c4a96] text-xl font-semibold tracking-wide uppercase">
        EDULAB AFRIK
      </span>
    </div>

    <div class="p-4 mb-6 bg-white rounded-lg">
      <img 
        src="/image.png" 
        alt="Succès" 
        class="object-cover w-48 h-auto"
      />
    </div>

    <div class="max-w-md mb-8 text-center">
      <div class="flex items-center justify-center gap-2 mb-4">
        <span class="text-2xl">🌸</span>
        <h1 class="text-[#4a3db7] font-semibold text-lg">
          Merci pour votre candidature !
        </h1>
      </div>
      
      <p class="px-4 text-sm leading-relaxed text-gray-600">
        Votre profil a bien été transmis à notre équipe. Vous recevrez une réponse par email après étude de votre dossier.
      </p>
    </div>

    <div class="w-full max-w-md bg-white shadow-sm border-l-[8px] border-[#1a237e] p-6">
      <h2 class="mb-3 text-sm font-semibold text-gray-800">Prochaines étapes :</h2>
      <ul class="space-y-2 text-sm text-gray-700 list-disc list-inside">
        <li>Notre équipe examinera votre candidature sous 3 à 5 jours ouvrables</li>
        <li>Vous recevrez un email de confirmation à votre adresse email</li>
        <li>Si votre profil est retenu, nous vous contacterons pour un entretien</li>
      </ul>
    </div>

    <NuxtLink 
      to="/user-login" 
      class="mt-8 text-sm text-gray-500 hover:text-[#1a237e] underline"
    >
      Retour à l'accueil
    </NuxtLink>

  </div>
</template>

<script setup>
// Pas de logique complexe ici, c'est juste une page d'affichage
useHead({
  title: 'Candidature Envoyée - Edulab Afrik'
})
</script>