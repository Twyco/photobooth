<script setup lang="ts">
import { onMounted, ref } from 'vue';

const model = defineModel<string>({ required: true });

const input = ref<HTMLInputElement | null>(null);

onMounted(() => {
  if (input.value?.hasAttribute('autofocus')) {
    input.value?.focus();
  }
});

defineExpose({ focus: () => input.value?.focus() });
</script>

<template>
  <input
    class="rounded-md border-highlight shadow-sm focus:border-secondary focus:ring-secondary w-full text-primary bg-footer"
    v-model="model"
    ref="input"
  />
</template>

<style>
input:-webkit-autofill {
  -webkit-box-shadow: 0 0 0 1000px theme('colors.footer') inset !important;
  -webkit-text-fill-color: theme('colors.primary') !important;
}
</style>
