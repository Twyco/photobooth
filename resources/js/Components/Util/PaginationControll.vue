<script setup lang="ts">
import { computed } from 'vue';

const props = defineProps({
  currentPage: {
    type: Number,
    required: true
  },
  lastPage: {
    type: Number,
    required: true
  }
});

const emits = defineEmits(['click']);

const pages = computed(() => {
  const currentPage = props.currentPage;
  const lastPage = props.lastPage;
  let start = currentPage - 2;
  let end = currentPage + 2;

  if (currentPage <= 3) {
    start = 1;
    end = 6;
  } else if (currentPage >= lastPage - 2) {
    start = lastPage - 5;
    end = lastPage;
  }

  const pages: number[] = [];
  for (let i = start; i <= end; i++) {
    if (i <= lastPage && i >= 1) {
      pages.push(i);
    }
  }
  return pages;
});

const fetchPage = (page: number) => {
  emits('click', page);
};
</script>

<template>
  <div class="flex justify-center w-fit">
    <button
      v-text="'<'"
      :disabled="currentPage <= 1"
      class="bg-gray-200 px-4 disabled:opacity-35 rounded mr-2"
      @click="fetchPage(currentPage - 1)"
    />
    <div v-if="lastPage > 6">
      <button
        v-if="currentPage >= 4"
        v-text="1"
        class="mx-1"
        @click="fetchPage(1)"
      />
      <span v-if="currentPage > 4" class="mx-1">...</span>
    </div>

    <!-- Zeige Seiten um die aktuelle Seite herum -->
    <button
      v-for="page in pages"
      :key="page"
      class="mx-1 text-black disabled:opacity-35"
      v-text="page"
      @click="fetchPage(page)"
      :disabled="page == currentPage"
    />

    <div v-if="lastPage > 6">
      <span v-if="currentPage < lastPage - 3" class="mx-1">...</span>
      <button
        v-if="currentPage <= lastPage - 3"
        v-text="lastPage"
        class="mx-1"
        @click="fetchPage(lastPage)"
      />
    </div>
    <button
      v-text="'>'"
      :disabled="currentPage >= lastPage"
      class="bg-gray-200 px-4 disabled:opacity-35 rounded ml-2"
      @click="fetchPage(currentPage + 1)"
    />
  </div>
</template>
