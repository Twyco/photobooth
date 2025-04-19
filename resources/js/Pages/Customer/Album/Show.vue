<script setup lang="ts">
import { UserAlbumWithImages } from '@/types/album-interface';
import AppLayout from '@/Layouts/AppLayout.vue';
import { computed, onMounted, PropType, ref } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import { format } from 'date-fns';
import ProgressiveImage from '@/Components/ProgressiveImage.vue';

const props = defineProps({
  album: {
    type: Object as PropType<UserAlbumWithImages>,
    required: true
  },
  hasAlbumSaved: { type: Boolean, default: false }
});

const pageProps = usePage().props;

const formatedDate = computed(() =>
  format(new Date(props.album.eventDate), 'dd.MM.yyyy')
);

const compressedLoadedCount = ref(0);

onMounted(() => {
  compressedLoadedCount.value = 0;
});
const progressiveImgRefs = ref<InstanceType<typeof ProgressiveImage>[]>([]);

const startLoadOriginalImg = () => {
  compressedLoadedCount.value += 1;
  if (compressedLoadedCount.value >= progressiveImgRefs.value.length) {
    progressiveImgRefs.value.forEach((img) => {
      img.startLoadOriginalImg();
    });
  }
};

window.addEventListener('load', function () {
  window.scrollTo(0, 1);
});
</script>

<template>
  <AppLayout title="Mein Alben">
    <div
      :class="`md:container md:mx-auto ${hasAlbumSaved ? 'my-12' : 'mb-12'} px-6 md:px-2`"
    >
      <div
        v-if="!!pageProps.auth?.user && album && !hasAlbumSaved"
        class="w-full py-2 md:pb-0 flex justify-center md:justify-start"
      >
        <Link
          :href="route('album.save', { album: album.uuid })"
          class="md:ml-4 px-4 py-2 rounded-lg bg-footer whitespace-nowrap"
          method="post"
        >
          In meine Fotoalben speichern
        </Link>
      </div>
      <div class="w-full flex flex-col md:flex-row">
        <div
          class="flex flex-col-reverse md:flex-col md:px-4 py-0 mr-0 md:py-2 md:mr-8 md:whitespace-nowrap"
        >
          <h1
            class="font-bold text-secondary text-3xl md:text-5xl mb-0 md:mb-2"
          >
            {{ album.title }}
          </h1>
          <h2 class="font-bold text-primary text-lg md:text-3xl mb-1 md:mb-0">
            {{ formatedDate }}
          </h2>
        </div>
        <div
          v-if="!!album.description"
          class="md:flex-grow md:flex md:items-center px-4 py-2 border-l-2 md:border-l-4 border-secondary"
        >
          <p class="text-primary">
            {{ album.description }}
          </p>
        </div>
      </div>
      <div
        class="mt-4 md:mt-16 md:px-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4"
      >
        <Link
          v-for="(image, index) in album.images"
          :href="
            route('album.image.show', {
              album: album.uuid,
              imageNumber: index + 1
            })
          "
          :key="index"
        >
          <ProgressiveImage
            ref="progressiveImgRefs"
            :compressed-src="image.compressed"
            :original-src="image.original"
            img-class="w-full h-full object-cover rounded-lg transition-opacity duration-500"
            @loaded-compressed-img="startLoadOriginalImg"
          />
        </Link>
      </div>
    </div>
  </AppLayout>
</template>
