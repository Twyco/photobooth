<script setup lang="ts">
import { PropType } from 'vue';
import { AdminAlbumInterface } from '@/types/album-interface';
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
  album: {
    type: Object as PropType<AdminAlbumInterface>,
    required: true
  }
});
</script>

<template>
  <AppLayout title="Album ansicht">
    <ul>
      <li><b>ID:</b> {{ album.id }}</li>
      <li><b>Titel:</b> {{ album.title }}</li>
      <li><b>Beschreibung:</b> {{ album.description }}</li>
      <li>
        <b>Veranstaltungsdatum:</b>
        {{ album.eventDate }}
      </li>
      <li><b>UUID:</b> {{ album.uuid }}</li>
      <li>
        <b>Direktlink: </b>
        <a
          :href="route('album.show', { album: album.uuid })"
          class="text-blue-800 visited:text-blue-800 active:text-blue-800"
        >
          {{ route('album.show', { album: album.uuid }) }}
        </a>
      </li>
      <li v-if="album.qrCode">
        <b>Qrcode:</b>
        <img :src="album.qrCode" alt="Qrcode" width="200" class="ml-2" />
      </li>
      <li>
        <b>Codes:</b>
        <ul class="ml-2">
          <li v-for="accessCode in album.accessCodes">
            <b>Code:</b>
            {{ accessCode.accessCode }} - <b>Usages:</b>
            {{ accessCode.usages }} - <b>Saves:</b> {{ accessCode.saves }}
          </li>
        </ul>
      </li>
    </ul>
  </AppLayout>
</template>
