<script setup lang="ts">
import {ref} from 'vue';

const props = defineProps({
  compressedSrc: {type: String, required: true},
  originalSrc: {type: String, required: true},
  imgClass: {type: String, required: true},
});
const emit = defineEmits(['loadedCompressedImg', 'loadedOriginalImg']);

const showOriginal = ref<boolean>(false);
const originalSrc = ref<string>('');
const showEffect = ref(false);

const startLoadOriginalImg = () => {
  originalSrc.value = props.originalSrc;
}

const onOriginalLoad = () => {
  emit('loadedOriginalImg');
  showOriginal.value = true;
  showEffect.value = true;
  setTimeout(() => {
    showEffect.value = false;
  }, 1000);
}

const onCompressedLoad = () => {
  emit('loadedCompressedImg');
}

defineExpose({ startLoadOriginalImg });
</script>

<template><div class="relative overflow-hidden">
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
    :class="[imgClass, showEffect ? 'shine-effect' : '']"
    @load="onOriginalLoad"
  />
  <div v-if="showEffect" class="shine-overlay"></div>
</div>
</template>

<style scoped>
.shine-overlay {
  position: absolute;
  top: 0;
  left: -100%;
  width: 150%;
  height: 100%;
  background: rgba(0, 255, 255, 0.3);
  transform: skewX(-30deg);
  animation: shine 1.5s forwards;
}

@keyframes shine {
  0% {
    left: -150%;
  }
  100% {
    left: 150%;
  }
}
</style>