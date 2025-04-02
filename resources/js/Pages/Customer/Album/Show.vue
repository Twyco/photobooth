<script setup lang="ts">
import {UserAlbumWithImages} from '@/types/album-interface';
import AppLayout from '@/Layouts/AppLayout.vue';
import {computed, onMounted, PropType, ref} from 'vue';
import {Link, usePage} from '@inertiajs/vue3';
import {format} from 'date-fns';

const props = defineProps({
  album: {
    type: Object as PropType<UserAlbumWithImages>,
    required: true
  },
  hasAlbumSaved: {type: Boolean, default: false}
});

const pageProps = usePage().props;

const formatedDate = computed(() =>
  format(new Date(props.album.eventDate), 'dd.MM.yyyy')
);

const images = ref(props.album.images.map(img => ({
  compressed: img.compressed,
  original: img.original,
  showOriginal: false,
})));

const loadedCount = ref(0);

const markImageAsLoaded = (index: number) => {
  loadedCount.value++;
  console.log(loadedCount.value);
  if (loadedCount.value === images.value.length) {
    console.log('loaded All')
    setTimeout(() => {
      images.value.forEach(img => img.showOriginal = true);
    }, 100);
  }
};

onMounted(() => {
  loadedCount.value = 0;
});

</script>

<template>
  <AppLayout title="Mein Alben">
    <div :class="`md:container md:mx-auto ${hasAlbumSaved ? 'my-12' : 'mb-12'} px-6 md:px-2`">
      <div v-if="!!pageProps.auth?.user && album && !hasAlbumSaved"
           class="w-full py-2 md:pb-0  flex justify-center md:justify-start">
        <Link
          :href="route('album.save', {album: album.uuid})"
          class="md:ml-4 px-4 py-2 rounded-lg bg-footer whitespace-nowrap"
          method="post"
        >
          In meine Fotoalben speichern
        </Link>
      </div>
      <div class="w-full flex flex-col md:flex-row">
        <div
          class="flex flex-col-reverse md:flex-col px-4 py-0 mr-0 md:py-2 md:mr-8 md:whitespace-nowrap"
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
      <p>Debug: {{Math.min(loadedCount, images.length)}}/{{images.length}} Bilder in low Quality geladen {{loadedCount >= images.length ? '&#9989;' : '&#10060;'}}</p>
      <p>Debug: {{Math.min(Math.max(loadedCount - images.length, 0), images.length)}}/{{images.length}} Bilder in height Quality geladen {{loadedCount >= (images.length * 2) ? '&#9989;' : '&#10060;'}}</p>
      <div
        class="mt-4 md:mt-16 md:px-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4"
      >
        <img v-for="(image, index) in images"
        :key="index"
          :src="image.showOriginal ? image.original : image.compressed"
          class="w-full h-full object-cover rounded-lg transition-opacity duration-500"
          loading="lazy"
          @load="markImageAsLoaded(index)"
        />
      </div>
    </div>
  </AppLayout>
</template>
