<script setup>
const props = defineProps({
  courseId: {
    type: [Number, String],
    required: true
  }
})

const emit = defineEmits(['close', 'payment-success'])

const router = useRouter() 
const token = useCookie('token')
const API_URL = 'http://127.0.0.1:8000/api'


const showPayment = ref(false)         
const showConfirmModal = ref(false)   
const processingPayment = ref(false)   
const paymentSuccess = ref(false)      
const selectedMethod = ref('')         


const { data: course, pending } = useFetch(() => `${API_URL}/formations/${props.courseId}`, {
    headers: { 'Authorization': `Bearer ${token.value}` },
    lazy: true 
})

const formatPrice = (price) => new Intl.NumberFormat('fr-FR').format(price) + ' FCFA'


const askConfirmation = (method) => {
    selectedMethod.value = method
    showConfirmModal.value = true 
}


const executePayment = async () => {
   
    showConfirmModal.value = false
    
    if (!course.value) return;
    const montantAchat = course.value.prix;
    const method = selectedMethod.value;

    processingPayment.value = true

    try {
        await $fetch(`${API_URL}/inscriptions`, {
            method: 'POST',
            headers: { 
                'Authorization': `Bearer ${token.value}`,
                'Accept': 'application/json'
            },
            body: {
                formation_id: props.courseId, 
                moyen_paiement: method,
                montant_paye: montantAchat 
            }
        })

        paymentSuccess.value = true;
        emit('payment-success', props.courseId)

    } catch (e) {
        console.error(e)
        const errorMsg = e.data?.details || e.data?.message || "Le paiement a échoué.";
        alert("Erreur : " + errorMsg);
        showPayment.value = false
    } finally {
        processingPayment.value = false
    }
}

const finishProcess = () => {
    emit('close') 
    router.push('/apprenant/formation') 
}
</script>

<template>
  <div class="relative flex flex-col items-center justify-center w-full h-full p-4 bg-white">
    
    <div class="w-full max-w-md mb-4" v-if="!paymentSuccess">
        <button @click="$emit('close')" class="flex items-center gap-2 text-sm font-medium text-gray-500 transition hover:text-indigo-900">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Retour au catalogue
        </button>
    </div>

    <div v-if="pending" class="flex flex-col items-center py-20 text-indigo-900">
        <div class="w-8 h-8 mb-2 border-2 border-indigo-900 rounded-full animate-spin border-t-transparent"></div>
        Chargement...
    </div>

    <div v-else-if="course" class="relative z-10 w-full max-w-md overflow-hidden bg-white border border-gray-100 shadow-lg rounded-2xl">
    
      <div class="flex items-center justify-center p-8 bg-indigo-900">
         <svg class="w-24 h-24 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
      </div>

      <div class="p-6">
        <div class="flex items-start justify-between mb-2">
          <span class="px-3 py-1 text-xs font-bold text-gray-600 uppercase bg-gray-100 rounded-full">{{ course.niveau }}</span>
          <span class="text-xl font-bold text-gray-900">{{ formatPrice(course.prix) }}</span>
        </div>

        <h1 class="mb-2 text-xl font-bold text-gray-900">{{ course.titre }}</h1>
        <p class="pb-4 mb-6 text-sm text-gray-500 border-b border-gray-100 line-clamp-3">{{ course.description }}</p>

        <div class="flex items-center gap-3 mb-6">
           <div class="flex items-center justify-center w-8 h-8 text-xs font-bold text-white bg-gray-400 rounded-full">
              {{ course.user?.prenom?.charAt(0) }}{{ course.user?.nom?.charAt(0) }}
           </div>
           <div>
              <p class="text-xs font-bold text-gray-500">Formateur</p>
              <p class="text-sm font-medium text-gray-900 capitalize">{{ course.user?.prenom }} {{ course.user?.nom }}</p>
           </div>
        </div>

        <button @click="showPayment = true" class="w-full py-3 font-bold text-white transition bg-indigo-900 rounded-lg shadow-lg hover:bg-indigo-800">
          S'inscrire et payer
        </button>
      </div>

      <div v-if="showPayment && !paymentSuccess" class="absolute inset-0 z-40 flex flex-col p-6 bg-white/95 backdrop-blur-sm animate-fade-in">
        <h3 class="mb-6 text-lg font-bold text-gray-900">Finaliser l'inscription</h3>
        
        <div class="flex items-center gap-4 p-3 mb-8 border border-gray-100 rounded-lg bg-gray-50">
           <div class="flex items-center justify-center w-10 h-10 text-xs text-white bg-indigo-700 rounded-full">{{ course.titre.charAt(0) }}</div>
           <div class="flex-1">
             <p class="text-sm font-bold text-gray-900 line-clamp-1">{{ course.titre }}</p>
           </div>
           <span class="px-2 py-1 text-xs font-bold text-white bg-indigo-600 rounded-full">{{ formatPrice(course.prix) }}</span>
        </div>

        <p class="mb-4 text-sm font-bold text-gray-600">Moyen de paiement :</p>
        
        <div v-if="processingPayment" class="flex flex-col items-center justify-center flex-1 space-y-4">
            <div class="w-10 h-10 border-4 border-indigo-600 rounded-full animate-spin border-t-transparent"></div>
            <p class="text-sm font-medium text-gray-500">Validation en cours...</p>
        </div>

        <div v-else class="mb-8 space-y-3">
          <button @click="askConfirmation('Orange Money')" class="flex items-center justify-between w-full px-4 py-3 font-bold text-gray-700 transition border rounded-lg hover:bg-orange-50 hover:border-orange-500">
            <span>Orange Money</span><div class="w-4 h-4 bg-orange-500 rounded-sm"></div>
          </button>
          <button @click="askConfirmation('MTN Money')" class="flex items-center justify-between w-full px-4 py-3 font-bold text-gray-700 transition border rounded-lg hover:bg-yellow-50 hover:border-yellow-500">
            <span>MTN Money</span><div class="w-4 h-4 bg-yellow-400 rounded-sm"></div>
          </button>
        </div>

        <div v-if="!processingPayment" class="mt-auto">
          <button @click="showPayment = false" class="w-full px-6 py-3 font-bold text-gray-700 transition bg-gray-100 rounded-lg hover:bg-gray-200">Annuler</button>
        </div>
      </div>

      <div v-if="paymentSuccess" class="absolute inset-0 z-50 flex flex-col items-center justify-center p-6 text-center bg-white animate-fade-in">
        <div class="flex items-center justify-center w-20 h-20 mb-6 bg-green-100 rounded-full">
            <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
        </div>
        <h3 class="mb-2 text-2xl font-bold text-gray-900">Félicitations !</h3>
        <p class="mb-8 text-gray-500">Votre inscription est validée. Bon apprentissage !</p>
        <button @click="finishProcess" class="w-full py-4 font-bold text-white transition transform bg-green-600 shadow-lg rounded-xl hover:bg-green-700 hover:scale-105 active:scale-95">
            Accéder au cours 🚀
        </button>
      </div>
    </div>
    
    <div v-else class="py-20 text-red-500">Formation introuvable.</div>

    <div v-if="showConfirmModal" class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm animate-fade-in">
        <div class="w-full max-w-sm overflow-hidden transition-all transform scale-100 bg-white shadow-2xl rounded-2xl">
            <div :class="selectedMethod.includes('Orange') ? 'bg-[#ff7900]' : 'bg-yellow-400'" class="p-6 text-center text-white">
                <h3 class="text-lg font-bold">Confirmer le paiement</h3>
            </div>
            
            <div class="p-6 text-center">
                <p class="mb-1 text-sm text-gray-500">Montant à payer</p>
                <p class="mb-2 text-3xl font-bold text-gray-900">{{ course ? formatPrice(course.prix) : '...' }}</p>
                <p class="flex items-center justify-center gap-2 mb-6 text-sm font-medium text-gray-600">
                    via {{ selectedMethod }}
                </p>

                <div class="flex gap-3">
                    <button @click="showConfirmModal = false" class="flex-1 py-3 font-bold text-gray-600 transition bg-gray-100 rounded-lg hover:bg-gray-200">
                        Non
                    </button>
                    <button @click="executePayment" class="flex-1 py-3 font-bold text-white transition bg-indigo-900 rounded-lg shadow-lg hover:bg-indigo-800">
                        Oui, payer
                    </button>
                </div>
            </div>
        </div>
    </div>
    </div>
</template>

<style scoped>
.animate-fade-in {
    animation: fadeIn 0.3s ease-out forwards;
}
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>