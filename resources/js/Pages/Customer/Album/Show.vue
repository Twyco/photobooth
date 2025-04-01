<script setup lang="ts">
import { UserAlbumWithImages } from '@/types/album-interface';
import AppLayout from '@/Layouts/AppLayout.vue';
import { computed, PropType } from 'vue';
import { format } from 'date-fns';

const props = defineProps({
  album: {
    type: Object as PropType<UserAlbumWithImages>,
    required: true
  },
  hasAlbumSaved: { type: Boolean, default: false }
});

const formatedDate = computed(() =>
  format(new Date(props.album.eventDate), 'dd.MM.yyyy')
);
</script>

<template>
  <AppLayout title="Mein Alben">
    <div class="md:container md:mx-auto my-12 px-6 md:px-2">
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
      <div
        class="mt-4 md:mt-16 md:px-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4"
      >
        <img
          v-for="(image, index) in album.images"
          :src="image"
          class="w-full h-full object-cover rounded-lg"
          :key="index"
          loading="lazy"
        />
      </div>
    </div>
  </AppLayout>
</template>
