// composables/useApi.ts

// Interface pour typer les erreurs renvoyées par Laravel
interface LaravelValidationError {
    message: string;
    errors?: Record<string, string[]>; // Ex: { email: ["Email déjà pris"] }
}

export const useApi = () => {
    // --- 1. CONFIGURATION ---
    const config = useRuntimeConfig()
    // Priorité : Config publique > Fallback local
    // Note: Assurez-vous que votre nuxt.config.ts a bien runtimeConfig.public.apiBase défini
    let apiBaseUrl = config.public?.apiBase as string || 'http://127.0.0.1:8000/api'

    // Normalisation : On s'assure qu'il n'y a pas de slash à la fin pour éviter les doubles //
    apiBaseUrl = apiBaseUrl.replace(/\/+$/, '') 
    // Si l'URL ne finit pas par /api, on l'ajoute (optionnel selon votre config serveur)
    if (!apiBaseUrl.endsWith('/api')) {
        apiBaseUrl = `${apiBaseUrl}/api`
    }

    // --- 2. FONCTIONS INTERNES ---

    const getAuthHeaders = (isFormData: boolean = false): HeadersInit => {
        const headers: Record<string, string> = {
            'Accept': 'application/json',
            // IMPORTANT : Si c'est du FormData, on ne met PAS 'Content-Type'. 
            // Le navigateur le fera avec le boundary.
        }

        if (!isFormData) {
            headers['Content-Type'] = 'application/json'
        }

        if (import.meta.client) {
            const token = localStorage.getItem('token')
            if (token) {
                headers['Authorization'] = `Bearer ${token}`
            }
        }

        return headers
    }

    const handleResponse = async (response: Response) => {
        const contentType = response.headers.get('content-type')
        const isJson = contentType?.includes('application/json')

        let data: any
        
        if (isJson) {
            data = await response.json()
        } else {
            const text = await response.text()
            // On essaie quand même de parser si le header manquait mais que c'est du JSON
            try {
                data = JSON.parse(text)
            } catch {
                data = { message: text || response.statusText }
            }
        }

        if (!response.ok) {
            // Création d'une erreur personnalisée pour le front
            const error: any = new Error(data.message || 'Une erreur est survenue')
            
            // On attache les détails techniques
            error.status = response.status
            error.response = data
            
            // SPECIFIQUE LARAVEL : On remonte les erreurs de validation au niveau supérieur
            // Si data.errors existe (cas du 422), on le met dans error.errors
            if (data.errors) {
                error.errors = data.errors
            }

            console.error(`🚨 API Error [${response.status}]`, data)
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
            // Nettoyage du endpoint pour éviter // au début
            const cleanEndpoint = endpoint.startsWith('/') ? endpoint : `/${endpoint}`
            url = `${apiBaseUrl}${cleanEndpoint}`
        }

        // Détection automatique de FormData
        const isFormData = options.body instanceof FormData

        // Fusion des options
        const fetchOptions: RequestInit = {
            ...options,
            headers: {
                ...getAuthHeaders(isFormData),
                ...options.headers, // Permet de surcharger si nécessaire
            },
        }

        try {
            const response = await fetch(url, fetchOptions)
            return await handleResponse(response)
        } catch (error: any) {
            // Si c'est une erreur réseau (serveur éteint, pas internet)
            if (!error.status) {
                console.error("Erreur Réseau / Serveur injoignable")
                throw new Error("Impossible de contacter le serveur. Vérifiez votre connexion.")
            }
            throw error
        }
    }

    // --- 3. EXPORTS ---
    return {
        apiCall,

        // --- AUTH ---
        
        // Inscription Apprenant (JSON classique)
        registerApprenant: (data: any) => apiCall('/auth/register/apprenant', {
            method: 'POST',
            body: JSON.stringify(data),
        }),

        // Inscription Formateur (Multipart/FormData pour le CV)
        registerFormateur: (formData: FormData) => apiCall('/auth/register/formateur', {
            method: 'POST',
            body: formData, // Le 'Content-Type' sera géré automatiquement par apiCall
        }),

        login: (email: string, password: string) => apiCall('/auth/login', {
            method: 'POST',
            body: JSON.stringify({ email, password }),
        }),

        logout: () => apiCall('/auth/logout', { method: 'POST' }),

        getProfile: () => apiCall('/auth/me', { method: 'GET' }),

        // --- HELPERS GÉNÉRIQUES ---
        
        get: (endpoint: string) => apiCall(endpoint, { method: 'GET' }),

        post: (endpoint: string, data: any) => apiCall(endpoint, {
            method: 'POST',
            body: JSON.stringify(data),
        }),

        put: (endpoint: string, data: any) => apiCall(endpoint, {
            method: 'PUT',
            body: JSON.stringify(data),
        }),

        delete: (endpoint: string) => apiCall(endpoint, { method: 'DELETE' }),

        // Helper explicite pour l'upload (si besoin ailleurs que register)
        upload: (endpoint: string, formData: FormData) => apiCall(endpoint, {
            method: 'POST',
            body: formData,
        }),
    }
}