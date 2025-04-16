<script setup lang="ts">
import { UserAlbum } from '@/types/album-interface';
import { Link } from '@inertiajs/vue3';
import { format } from 'date-fns';
import { ref } from "vue";

const props = defineProps({
  albums: { type: Array<UserAlbum>, required: true },
  sortDate: {
    type: String,
    default: 'desc',
  },
});

const dateSortAsc = ref<boolean>(props.sortDate === 'asc');

const emits = defineEmits(['update:dateSort']);

const changeDateSort = () => {
  dateSortAsc.value = !dateSortAsc.value;
  emits('update:dateSort', dateSortAsc.value ? 'asc' : 'desc');
}
</script>

<template>
  <div class="w-full flex flex-col justify-between py-2">
    <div
      class="w-full flex justify-between px-0 md:px-4 py-1 font-semibold border-footer border-b-2 mb-2"
    >
      <span class="font-bold">Titel</span>
      <div @click="changeDateSort" class="cursor-pointer">
        <span class="font-bold">
          Event Datum
          <i v-if="dateSortAsc" class="mdi mdi-arrow-down" />
          <i v-else class="mdi mdi-arrow-up" />
        </span>
      </div>
    </div>

    <Link
      v-for="album in albums"
      :key="album.uuid"
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
  </div>
</template>
