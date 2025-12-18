import { defineStore } from 'pinia'

export const useAuthStore = defineStore('authStore', {
  state: () => ({
    step1: {
      nom: '',
      email: '',
      password: '',
      confirm_password: '',
      role: 'APPRENANT'
    },
    step2: {
      domaine: '',
      competences: '',
      experience: '',
      niveau: '',
      description: '',
      cv: null
    }
  }),

  actions: {
    setStep1(data) {
      Object.assign(this.step1, data)
    },
    setStep2(data) {
      Object.assign(this.step2, data)
    }
  }
})
