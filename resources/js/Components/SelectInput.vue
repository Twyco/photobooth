<script setup lang="ts">
import { onMounted, ref } from 'vue';

defineProps({
  options: {
    type: Array<{ value: any; label: string }>
  },
  disabledNull: Boolean
});

const model = defineModel<any>({ required: true });

const input = ref<HTMLInputElement | null>(null);

onMounted(() => {
  if (input.value?.hasAttribute('autofocus')) {
    input.value?.focus();
  }
});

defineExpose({ focus: () => input.value?.focus() });
</script>

<template>
  <select
    v-model="model"
    class="rounded-md border-highlight shadow-sm focus:border-secondary focus:ring-secondary w-full text-primary bg-footer"
    ref="input"
  >
    <option
      v-for="option in options"
      :value="option.value"
      :disabled="option.value === null && disabledNull"
    >
      {{ option.label }}
    </option>
  </select>
</template>

<style>
input:-webkit-autofill {
  -webkit-box-shadow: 0 0 0 1000px theme('colors.footer') inset !important;
  -webkit-text-fill-color: theme('colors.primary') !important;
}
</style>
