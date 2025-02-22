<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { PropType } from 'vue';
import { UserAlbumInterface } from '@/types/album-interface';
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

    <div class="py-12">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
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
              <li><b>Hier sind dann die Bilder!</b></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
