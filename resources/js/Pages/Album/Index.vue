<script setup lang="ts">
import { AdminAlbumInterface } from '@/types/album-interface';
import NavLink from '@/Components/NavLink.vue';
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
  albums: Array<AdminAlbumInterface>
});
</script>

<template>
  <AppLayout title="Alben - Übersicht">
    <ul>
      <li v-for="(album, index) in albums" :key="index">
        <NavLink :href="route('album.show', { album: album.uuid })">
          Show: {{ album.title }}
        </NavLink>
      </li>
    </ul>
  </AppLayout>
</template>
