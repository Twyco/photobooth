<script setup lang="ts">
defineProps({
  title: { type: String, default: '' },
  icon: { type: String, default: ''}
});

defineEmits(['click:icon'])
</script>

<template>
  <div class="w-full flex justify-between items-center border-secondary border-b-2 mb-8">
    <span
      class="text-secondary text-lg uppercase font-bold border-b-2 border-secondary"
    >
      {{ title }}
    </span>
    <i v-if="icon" :class="`mdi mdi-${icon} mr-2 text-3xl cursor-pointer`" style="line-height: 1px" @click="$emit('click:icon')"/>
  </div>
</template>
