
export default defineNuxtRouteMiddleware((to, from) => {
  const token = useCookie('token')
  if (to.path.startsWith('/auth')) {
    return
  }
  if (!token.value) {
    return navigateTo('/auth/user-login')
  }
})