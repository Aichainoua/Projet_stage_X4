<template>
  <div class="w-full mb-4">
    <label class="text-gray-700 text-sm font-medium">{{ label }}</label>
    <input
      :type="type"
      :placeholder="placeholder"
      v-model="model"
      class="w-full p-3 border bg-gray-100 rounded-md mt-1 focus:outline-none focus:ring-2 focus:ring-indigo-500"
    />
  </div>
</template>

<script setup>
const props = defineProps({
  label: String,
  placeholder: String,
  modelValue: String,
  type: { type: String, default: "text" },
})
const emit = defineEmits(["update:modelValue"])
const model = computed({
  get: () => props.modelValue,
  set: value => emit("update:modelValue", value)
})
</script>
