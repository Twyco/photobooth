<script setup lang="ts">
defineProps({
  title: {type: String, default: ''}
})
</script>

<template>
  <div class="w-full border-secondary border-b-2 mb-8">
    <span class="text-secondary text-lg uppercase font-bold border-b-4 border-secondary">
      {{ title }}
    </span>
  </div>
</template>
