<script setup lang="ts">
import {UserAlbum} from "@/types/album-interface";
import {Link} from "@inertiajs/vue3";
import {format} from "date-fns";

defineProps({
  albums: {type: Array<UserAlbum>, required: true},
});

</script>

<template>
  <div class="w-full grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-2 py-2">
    <template
      v-for="album in albums"
      :key="album.uuid"
    >
      <Link
        :href="route('album.show', {album: album.uuid})"
        class="flex flex-col items-center justify-between px w-full p-2 rounded-lg bg-footer hover:bg-gray-highlight hover:bg-opacity-25"
      >
        <img :src="album.cover" :alt="album.title" class="w-full aspect-square object-cover rounded-lg"/>
        <div class="w-full flex flex-col justify-between px-2 py-1 flex-1">
          <span class="font-bold text-lg min-h-14">{{ album.title }}</span>
          <span class="w-full text-right">{{ format(new Date(album.eventDate), 'dd.MM.yyyy') }}</span>
        </div>
      </Link>
    </template>
  </div>
</template>
