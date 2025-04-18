<script setup lang="ts">
import { ref } from 'vue';

const props = defineProps({
  compressedSrc: { type: String, required: true },
  originalSrc: { type: String, required: true },
  imgClass: { type: String, required: true }
});
const emit = defineEmits(['loadedCompressedImg', 'loadedOriginalImg']);

const showOriginal = ref<boolean>(false);
const originalSrc = ref<string>('');

const startLoadOriginalImg = () => {
  originalSrc.value = props.originalSrc;
};

const onOriginalLoad = () => {
  emit('loadedOriginalImg');
  showOriginal.value = true;
};

const onCompressedLoad = () => {
  emit('loadedCompressedImg');
};

defineExpose({ startLoadOriginalImg });
</script>

<template>
  <img
    v-show="!showOriginal"
    :src="compressedSrc"
    :class="imgClass"
    loading="lazy"
    @load="onCompressedLoad"
  />
  <img
    v-show="showOriginal"
    :src="originalSrc"
    :class="imgClass"
    @load="onOriginalLoad"
  />
</template>
