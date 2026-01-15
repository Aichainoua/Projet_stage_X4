<template>
  <button
    class="w-full py-3 bg-indigo-700 text-white rounded-full hover:bg-indigo-800 transition"
    @click="$emit('click')"
  >
    <slot />
  </button>
</template>
