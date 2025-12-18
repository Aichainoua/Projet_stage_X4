// composables/useApi.ts

export const useApi = () => {
  // --- 1. CONFIGURATION ---
  
  // Récupérer l'URL de base. On gère le cas où config n'est pas dispo.
  let apiBaseUrl = 'http://localhost:8000/api'
  
  try {
    const config = useRuntimeConfig()
    if (config?.public?.apiBase) {
      apiBaseUrl = config.public.apiBase
    }
  } catch (e) {
    console.warn('Runtime config non disponible, fallback sur localhost:8000')
  }
  
  // Normalisation de l'URL (pour éviter les doubles slashs //api)
  if (!apiBaseUrl.endsWith('/api')) {
    apiBaseUrl = apiBaseUrl.replace(/\/api\/?$/, '') + '/api'
  }

  // --- 2. FONCTIONS INTERNES ---

  const getAuthHeaders = (): HeadersInit => {
    const headers: HeadersInit = {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
    }

    // IMPORTANT : On vérifie si on est côté client avant de toucher au localStorage
    // process.client est une variable globale Nuxt
    if (process.client) {
      const token = localStorage.getItem('token')
      if (token) {
        (headers as any)['Authorization'] = `Bearer ${token}`
      }
    }

    return headers
  }

  const handleResponse = async (response: Response) => {
    const contentType = response.headers.get('content-type')
    const isJson = contentType?.includes('application/json')
    
    let data
    if (isJson) {
      data = await response.json()
    } else {
      const text = await response.text()
      try {
        data = JSON.parse(text)
      } catch {
        // Si ce n'est pas du JSON, on retourne le texte brut ou null
        data = text ? { message: text } : {}
      }
    }

    if (!response.ok) {
      // Création d'une erreur personnalisée avec les données du backend
      const error: any = new Error(data.message || 'Une erreur est survenue')
      error.response = data
      error.status = response.status
      throw error
    }

    return data
  }

  const apiCall = async (endpoint: string, options: RequestInit = {}) => {
    // Construction de l'URL
    let url: string
    if (endpoint.startsWith('http')) {
      url = endpoint
    } else {
      // Nettoyage des slashs pour éviter http://url//endpoint
      const baseUrl = apiBaseUrl.endsWith('/') ? apiBaseUrl.slice(0, -1) : apiBaseUrl
      const cleanEndpoint = endpoint.startsWith('/') ? endpoint : '/' + endpoint
      url = `${baseUrl}${cleanEndpoint}`
    }
    
    // Fusion des headers
    const defaultOptions: RequestInit = {
      headers: getAuthHeaders(),
      ...options,
    }

    // Gestion spéciale pour FormData (upload de fichiers)
    // Le navigateur doit définir lui-même le boundary, donc on supprime Content-Type
    if (options.body instanceof FormData) {
      const headers = { ...defaultOptions.headers }
      delete (headers as any)['Content-Type']
      defaultOptions.headers = headers
    }

    try {
      // Appel réseau
      const response = await fetch(url, defaultOptions)
      return await handleResponse(response)
    } catch (error: any) {
      console.error(`Erreur API [${options.method || 'GET'} ${endpoint}]:`, error.message)
      throw error
    }
  }

  // --- 3. EXPORTS DES MÉTHODES ---
  return {
    // Helpers génériques
    apiCall, // On l'exporte au cas où on en a besoin directement
    
    // Auth
    async registerApprenant(data: any) {
      return apiCall('/auth/register/apprenant', {
        method: 'POST',
        body: JSON.stringify(data),
      })
    },

    async registerFormateur(formData: FormData) {
      return apiCall('/auth/register/formateur', {
        method: 'POST',
        body: formData, // Pas de JSON.stringify ici !
      })
    },

    async login(email: string, password: string) {
      return apiCall('/auth/login', {
        method: 'POST',
        body: JSON.stringify({ email, password }),
      })
    },

    async logout() {
      return apiCall('/auth/logout', {
        method: 'POST',
      })
    },

    async getProfile() {
      return apiCall('/auth/me', {
        method: 'GET'
      })
    },

    // Méthodes HTTP génériques
    async get(endpoint: string) {
      return apiCall(endpoint, { method: 'GET' })
    },

    async post(endpoint: string, data: any) {
      return apiCall(endpoint, {
        method: 'POST',
        body: JSON.stringify(data),
      })
    },

    async put(endpoint: string, data: any) {
      return apiCall(endpoint, {
        method: 'PUT',
        body: JSON.stringify(data),
      })
    },

    async delete(endpoint: string) {
      return apiCall(endpoint, { method: 'DELETE' })
    },

    // Helper spécifique pour l'upload (ex: avatar, documents)
    async upload(endpoint: string, formData: FormData) {
      return apiCall(endpoint, {
        method: 'POST',
        body: formData,
      })
    },
  }
}