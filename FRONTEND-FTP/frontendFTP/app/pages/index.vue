<script setup>
definePageMeta({
  middleware: [
    function (to, from) {
      return navigateTo('/auth/user-login')
    }
  ]
})
</script>

<template>
  <div>Redirection...</div>
</template>