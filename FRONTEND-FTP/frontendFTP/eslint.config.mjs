// @ts-check
import withNuxt from './.nuxt/eslint.config.mjs'

export default withNuxt({
  // Enforce multi-word component names to follow Vue style guide
  rules: {
    'vue/multi-word-component-names': ['error', { ignores: [] }]
  }
})
