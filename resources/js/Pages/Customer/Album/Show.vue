<script setup lang="ts">
import { UserAlbumWithImages } from '@/types/album-interface';
import AppLayout from '@/Layouts/AppLayout.vue';
import { PropType } from 'vue';

defineProps({
  album: {
    type: Object as PropType<UserAlbumWithImages>,
    required: true
  },
  hasAlbumSaved: { type: Boolean, default: false }
});
</script>

<template>
  <AppLayout title="Mein Alben">
    <p>{{ album }}</p>
    <p>{{ hasAlbumSaved }}</p>
  </AppLayout>
</template>
