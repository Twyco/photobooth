<script setup lang="ts">
import {computed} from "vue";

const props = defineProps({
  currentPage: {
    type: Number,
    required: true
  },
  total:  {
    type: Number,
    required: true
  },
  perPage:  {
    type: Number,
    required: true
  }
});

const tableInfo = computed(() => {
  const total = props.total;
  const firstItem = props.perPage * (props.currentPage - 1) + 1;
  const lastItem = props.perPage * props.currentPage;
  return `Ergebnisse ${firstItem}-${lastItem > total ? total : lastItem} von ${total}`;
});
</script>

<template>
  <div class="flex justify-center mt-4 w-fit">
    {{ tableInfo }}
  </div>
</template>
