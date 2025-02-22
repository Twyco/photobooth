<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { PropType } from 'vue';
import { UserAlbumInterface } from '@/Types/album-interface';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import AppLayout from '@/Layouts/AppLayout.vue';

const props = defineProps({
  album: {
    type: Object as PropType<UserAlbumInterface>,
    required: true
  },
  hasAlbumSaved: Boolean
});

const saveAlbum = () => {
  router.post(route('album.save', { album: props.album.uuid }));
};
</script>

<template>
  <AppLayout title="Album ansicht">
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">
        User - Album - Ansicht
      </h2>
    </template>
    <primary-button v-if="!hasAlbumSaved" @click="saveAlbum()"
      >Album Speichern</primary-button
    >
    <ul class="mt-4">
      <li><b>Titel:</b> {{ album.title }}</li>
      <li><b>Beschreibung:</b> {{ album.description }}</li>
      <li>
        <b>Veranstaltungsdatum:</b>
        {{ album.eventDate }}
      </li>
      <li><b>UUID:</b> {{ album.uuid }}</li>
    </ul>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4">
      <img
        v-for="(image, index) in album.images"
        :key="index"
        :src="image"
        class="w-full h-auto rounded-lg shadow-md"
        alt="Album Image"
      />
    </div>
  </AppLayout>
</template>
