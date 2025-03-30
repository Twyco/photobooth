<script setup lang="ts">
defineProps({
  events: {
    type: Array<{ title: string; description: string }>
  }
});
</script>

<template>
  <div
    v-if="events"
    class="relative border-l-2 border-secondary space-y-12 py-6"
  >
    <div
      v-for="(event, index) in events"
      :key="index"
      class="relative flex items-start"
    >
      <div
        class="absolute -left-5 w-10 h-10 flex items-center justify-center bg-secondary text-primary rounded-full select-none"
      >
        {{ index + 1 }}
      </div>

      <div class="ml-8 px-4">
        <h3 class="font-bold text-secondary text-2xl">{{ event.title }}</h3>
        <p class="text-primary">{{ event.description }}</p>
      </div>
    </div>
  </div>
</template>
