<script setup lang="ts">
import {Head} from '@inertiajs/vue3';
import {PropType} from 'vue';
import {AdminAlbumInterface} from '@/types/album-interface';
import AdminLayout from "@/Layouts/AdminLayout.vue";

const props = defineProps({
  album: {
    type: Object as PropType<AdminAlbumInterface>,
    required: true,
  },
  qrCodeUrl: String,
});
console.log(props.album);
</script>

<template>
  <Head title="Album ansicht"/>

  <AdminLayout>
    <ul>
      <li><b>ID:</b> {{ album.id }}</li>
      <li><b>Titel:</b> {{ album.title }}</li>
      <li>
        <b>Beschreibung:</b> {{ album.description }}
      </li>
      <li>
        <b>Veranstaltungsdatum:</b>
        {{ album.eventDate }}
      </li>
      <li><b>UUID:</b> {{ album.uuid }}</li>
      <li>
        <b>Direktlink: </b>
        <a
          :href="route('album.show', {album: album.uuid})"
          class="text-blue-800 visited:text-blue-800 active:text-blue-800"
        >
          {{ route('album.show', {album: album.uuid}) }}
        </a>
      </li>
      <li v-if="qrCodeUrl">
        <b>Qrcode:</b>
        <img
          :src="qrCodeUrl"
          alt="Qrcode"
          width="200"
          class="ml-2"
        />
      </li>
      <li>
        <b>Codes:</b>
        <ul class="ml-2">
          <li v-for="accessCode in album.accessCodes">
            <b>Code:</b>
            {{ accessCode.accessCode }} -
            <b>Usages:</b> {{ accessCode.usages }} -
            <b>Saves:</b> {{ accessCode.saves }}
          </li>
        </ul>
      </li>
    </ul>
  </AdminLayout>
</template>
