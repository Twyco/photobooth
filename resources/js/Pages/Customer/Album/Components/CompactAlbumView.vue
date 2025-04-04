<script setup lang="ts">
import { UserAlbum } from '@/types/album-interface';
import { Link } from '@inertiajs/vue3';
import { format } from 'date-fns';

defineProps({
  albums: { type: Array<UserAlbum>, required: true }
});
</script>

<template>
  <div class="w-full flex flex-col justify-between py-2">
    <div
      class="w-full flex justify-between px-0 md:px-4 py-1 font-semibold border-footer border-b-2 mb-2"
    >
      <span class="font-bold">Titel</span>
      <span class="font-bold">Event Datum</span>
    </div>

    <template v-for="album in albums" :key="album.uuid">
      <Link
        :href="route('album.show', { album: album.uuid })"
        class="w-full flex items-center justify-between gap-x-2 px-0 md:px-4 py-1 rounded-lg hover:bg-highlight hover:bg-opacity-25"
      >
        <span class="font-bold whitespace-nowrap">{{ album.title }}</span>
        <span
          v-if="album.description"
          class="hidden md:inline-flex flex-1 text-gray-500 truncate"
        >
          <i class="mdi mdi-menu-right" /> {{ album.description }}
        </span>
        <span class="whitespace-nowrap text-right">{{
          format(new Date(album.eventDate), 'dd.MM.yyyy')
        }}</span>
      </Link>
    </template>
  </div>
</template>
