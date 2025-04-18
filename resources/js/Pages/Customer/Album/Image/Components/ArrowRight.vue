<script setup lang="ts">

defineProps({
  width: {
    type: Number,
    default: 18,
  },
  height: {
    type: Number,
    default: 36,
  },
})
</script>

<template>
  <svg xmlns="http://www.w3.org/2000/svg" :width="width" :height="height" viewBox="0 0 14 36">
    <path d="M 7 36 L 13 18 L 7 0" fill="none" stroke="black" stroke-width="3"/>
  </svg>
</template>
