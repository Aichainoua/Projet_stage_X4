<template>
  <div class="flex items-center justify-center min-h-screen p-4 bg-gray-50">
    <div class="w-full max-w-md p-8 bg-white rounded-lg shadow-lg">
      
      <div class="flex items-center gap-3 mb-6">
        <div class="flex items-center justify-center w-12 h-12 bg-indigo-700 rounded-lg">
          <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
          </svg>
        </div>
        <h1 class="text-2xl font-bold text-gray-800">EDULAB AFRIK</h1>
      </div>

      
      <h2 class="mb-4 text-lg font-semibold text-gray-700">Créer un compte</h2>

     
      <div class="flex gap-2 mb-6">
        <button 
           @click="navigateTo('/register-step1')"
          class="flex-1 px-4 py-2 font-medium text-gray-700 transition bg-gray-100 rounded-lg hover:bg-gray-200"
        >
          Apprenant
        </button>
        <button 
          @click="navigateTo('/register-formateur-step1')"
          class="flex-1 px-4 py-2 font-medium text-gray-700 transition bg-gray-100 rounded-lg hover:bg-gray-200"
        >
          FORMATEUR
        </button>
      </div>

      <p class="mb-6 text-xs text-gray-500">
        Remplissez vos coordonnées pour commencer votre inscription en tant que formateur
      </p>

      
      <div class="mb-6">
        <div class="flex items-center justify-between mb-2">
          <span class="text-xs font-medium text-indigo-700">Etape 1 sur 2 : Informations personnelles</span>
        </div>
        <div class="w-full h-2 bg-gray-200 rounded-full">
          <div class="h-2 bg-indigo-700 rounded-full" style="width: 50%"></div>
        </div>
      </div>

      <form @submit.prevent="handleNext" class="space-y-4">
     
        <div>
          <label class="block mb-1 text-sm font-medium text-gray-700">Nom</label>
          <input
            v-model="form.nom"
            type="text"
            placeholder="INOUA"
            class="w-full px-4 py-2.5 bg-gray-100 border-0 rounded-lg focus:ring-2 focus:ring-indigo-700 focus:bg-white transition text-sm"
            required
          />
        </div>
      
        <div>
          <label class="block mb-1 text-sm font-medium text-gray-700">Prénom</label>
          <input
            v-model="form.prenom"
            type="text"
            placeholder="AICHA"
            class="w-full px-4 py-2.5 bg-gray-100 border-0 rounded-lg focus:ring-2 focus:ring-indigo-700 focus:bg-white transition text-sm"
            required
          />
        </div>

        <div>
          <label class="block mb-1 text-sm font-medium text-gray-700">Email</label>
          <input
            v-model="form.email"
            type="email"
            placeholder="votre@email.com"
            class="w-full px-4 py-2.5 bg-gray-100 border-0 rounded-lg focus:ring-2 focus:ring-indigo-700 focus:bg-white transition text-sm"
            required
          />
        </div>

      
        <div>
          <label class="block mb-1 text-sm font-medium text-gray-700">Date de naissance</label>
          <input
            v-model="form.dateNaissance"
            type="date"
            class="w-full px-4 py-2.5 bg-gray-100 border-0 rounded-lg focus:ring-2 focus:ring-indigo-700 focus:bg-white transition text-sm"
            required
          />
        </div>

        
        <div>
          <label class="block mb-1 text-sm font-medium text-gray-700">Pays de résidence</label>
          <div class="relative">
            <button
              type="button"
              @click="paysDropdownOpen = !paysDropdownOpen"
              class="w-full px-4 py-2.5 bg-gray-100 border-0 rounded-lg focus:ring-2 focus:ring-indigo-700 focus:bg-white transition text-sm text-left flex items-center justify-between"
            >
              <span v-if="selectedCountry.name" class="text-gray-700">
                {{ selectedCountry.emoji }} {{ selectedCountry.name }}
              </span>
              <span v-else class="text-gray-500">Sélectionnez un pays</span>
              <svg class="w-5 h-5 text-gray-500 transition-transform" :class="{ 'rotate-180': paysDropdownOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
              </svg>
            </button>
            
            
            <div 
              v-if="paysDropdownOpen"
              class="absolute z-20 w-full mt-2 overflow-y-auto bg-white border border-gray-200 rounded-lg shadow-lg max-h-64"
            >
              <div class="p-2">
                <input
                  v-model="paysSearch"
                  type="text"
                  placeholder="Rechercher un pays..."
                  class="w-full px-3 py-2 mb-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                  @click.stop
                />
              </div>
              <div class="overflow-y-auto max-h-48">
                <button
                  v-for="country in filteredCountries"
                  :key="country.code"
                  type="button"
                  @click="selectCountry(country)"
                  class="flex items-center w-full gap-3 px-4 py-2 text-sm text-left transition hover:bg-gray-50"
                >
                  <span class="text-xl">{{ country.emoji }}</span>
                  <span class="flex-1 text-gray-700">{{ country.name }}</span>
                  <span class="text-xs text-gray-400">+{{ country.dialCode }}</span>
                </button>
              </div>
            </div>
          </div>
        </div>

        
        <div>
          <label class="block mb-1 text-sm font-medium text-gray-700">Numéro de téléphone</label>
          <div class="flex gap-2">
            
            <div class="w-32">
              <div class="w-full px-4 py-2.5 bg-gray-100 border-0 rounded-lg text-sm flex items-center justify-between">
                <span class="text-gray-700">+{{ selectedCountry.dialCode }}</span>
                <span class="text-xl">{{ selectedCountry.emoji }}</span>
              </div>
            </div>
            
            
            <div class="flex-1">
              <input
                v-model="form.telephone"
                type="tel"
                class="w-full px-4 py-2.5 bg-gray-100 border-0 rounded-lg focus:ring-2 focus:ring-indigo-700 focus:bg-white transition text-sm"
                :placeholder="getPhonePlaceholder()"
                required
              />
            </div>
          </div>
        </div>

        <!-- Biographie -->
        <div>
          <label class="block mb-1 text-sm font-medium text-gray-700">Courte biographie</label>
          <textarea
            v-model="form.biographie"
            placeholder="Parlez-nous de vous..."
            rows="3"
            class="w-full px-4 py-2.5 bg-gray-100 border-0 rounded-lg focus:ring-2 focus:ring-indigo-700 focus:bg-white transition text-sm resize-none"
            required
          ></textarea>
        </div>

        <button
          type="submit"
          class="flex items-center justify-center w-full gap-2 py-3 mt-6 font-semibold text-white transition duration-200 bg-indigo-700 rounded-lg hover:bg-indigo-800"
        >
          Étape suivante
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
          </svg>
        </button>
      </form>
    </div>
  </div>
</template>

<script setup>
const paysDropdownOpen = ref(false)
const paysSearch = ref('')

const countries = [
  { code: 'CM', name: 'Cameroun', dialCode: '237', emoji: '🇨🇲' },
  { code: 'FR', name: 'France', dialCode: '33', emoji: '🇫🇷' },
  { code: 'BE', name: 'Belgique', dialCode: '32', emoji: '🇧🇪' },
  { code: 'CH', name: 'Suisse', dialCode: '41', emoji: '🇨🇭' },
  { code: 'CA', name: 'Canada', dialCode: '1', emoji: '🇨🇦' },
  { code: 'US', name: 'États-Unis', dialCode: '1', emoji: '🇺🇸' },
  { code: 'SN', name: 'Sénégal', dialCode: '221', emoji: '🇸🇳' },
  { code: 'CI', name: 'Côte d\'Ivoire', dialCode: '225', emoji: '🇨🇮' },
  { code: 'GA', name: 'Gabon', dialCode: '241', emoji: '🇬🇦' },
  { code: 'BJ', name: 'Bénin', dialCode: '229', emoji: '🇧🇯' },
  { code: 'TG', name: 'Togo', dialCode: '228', emoji: '🇹🇬' },
]

const sortedCountries = computed(() => {
  return [...countries].sort((a, b) => a.name.localeCompare(b.name))
})

const selectedCountry = ref(sortedCountries.value.find(c => c.code === 'CM') || sortedCountries.value[0])

const form = ref({
  nom: '',
  prenom: '',
  email: '',
  telephone: '',
  dateNaissance: '',
  pays: 'Cameroun',
  biographie: ''
})

const filteredCountries = computed(() => {
  if (!paysSearch.value) return sortedCountries.value
  const search = paysSearch.value.toLowerCase()
  return sortedCountries.value.filter(country => 
    country.name.toLowerCase().includes(search) ||
    country.dialCode.includes(search)
  )
})

const selectCountry = (country) => {
  selectedCountry.value = country
  form.value.pays = country.name
  paysDropdownOpen.value = false
  paysSearch.value = ''
}

const getPhonePlaceholder = () => {
  if (selectedCountry.value.dialCode === '237') return '6 00 00 00 00'
  if (selectedCountry.value.dialCode === '33') return '6 12 34 56 78'
  if (selectedCountry.value.dialCode === '1') return '555 123 4567'
  return 'Numéro de téléphone'
}

const handleNext = () => {
  const telephoneComplet = `+${selectedCountry.value.dialCode} ${form.value.telephone}`
  
  const formData = {
    ...form.value,
    telephone: telephoneComplet,
    codePays: selectedCountry.value.dialCode,
    nomComplet: `${form.value.prenom} ${form.value.nom}`.trim(),
    paysCode: selectedCountry.value.code,
    paysEmoji: selectedCountry.value.emoji
  }
  
  // Stocker dans localStorage
  localStorage.setItem('formateurStep1', JSON.stringify(formData))
  
  navigateTo('/register-formateur-step2')
}

onMounted(() => {
  document.addEventListener('click', (e) => {
    if (!e.target.closest('.relative')) {
      paysDropdownOpen.value = false
    }
  })
})
</script>