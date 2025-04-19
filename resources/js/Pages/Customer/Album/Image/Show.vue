<script setup lang="ts">
import ProgressiveImage from '@/Components/ProgressiveImage.vue';
import { onBeforeUnmount, onMounted, PropType, ref } from 'vue';
import { UserAlbum } from '@/types/album-interface';
import { Link, router } from '@inertiajs/vue3';
import ArrowLeft from '@/Pages/Customer/Album/Image/Components/ArrowLeft.vue';
import ArrowRight from '@/Pages/Customer/Album/Image/Components/ArrowRight.vue';

const props = defineProps({
  album: {
    type: Object as PropType<UserAlbum>,
    required: true
  },
  image: {
    type: Object as any,
    required: true
  },
  nextImg: String,
  prevImg: String
});

const progressiveImg = ref<InstanceType<typeof ProgressiveImage> | null>(null);

function handleKeyDown(event: KeyboardEvent) {
  if (event.key === 'ArrowLeft' && props.prevImg) {
    router.visit(props.prevImg ?? '', { replace: true });
  } else if (event.key === 'ArrowRight' && props.nextImg) {
    router.visit(props.nextImg ?? '', { replace: true });
  }
}

onMounted(() => {
  window.addEventListener('keydown', handleKeyDown);
});

onBeforeUnmount(() => {
  window.removeEventListener('keydown', handleKeyDown);
});
</script>

<template>
  <div
    class="relative flex items-center justify-center min-h-dvh w-screen overflow-hidden"
  >
    <div
      class="relative w-full h-full lg:max-w-[75vw] lg:max-h-[75vh] lg:w-fit"
    >
      <Link
        v-if="prevImg"
        :href="prevImg"
        class="absolute z-10 left-1 top-1/2 transform opacity-80 -translate-y-1/2 rounded-full p-2 lg:-left-12 lg:bg-primary lg:bg-opacity-50 lg:hover:bg-opacity-70 lg:px-3 lg:py-5"
        replace
      >
        <ArrowLeft />
      </Link>

      <ProgressiveImage
        ref="progressiveImg"
        :compressed-src="image.compressed"
        :original-src="image.original"
        img-class="object-contain w-full h-full transition-opacity duration-500"
        @loaded-compressed-img="
          progressiveImg && progressiveImg.startLoadOriginalImg()
        "
      />

      <Link
        v-if="nextImg"
        :href="nextImg"
        class="absolute z-10 right-1 top-1/2 transform -translate-y-1/2 rounded-full p-2 lg:-right-12 lg:bg-primary lg:bg-opacity-50 lg:hover:bg-opacity-70 lg:px-3 lg:py-5"
        replace
      >
        <ArrowRight />
      </Link>
    </div>

    <Link
      class="absolute top-8 right-8 bg-primary bg-opacity-50 hover:bg-opacity-70 rounded-full px-2 py-1 text-xl"
      :href="route('album.show', { album: album.uuid })"
      replace
    >
      <i class="mdi mdi-close" />
    </Link>
  </div>
</template>
