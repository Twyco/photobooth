<script setup lang="ts">
import { UserAlbum } from '@/types/album-interface';
import { Link } from '@inertiajs/vue3';
import { format } from 'date-fns';
import { ref } from 'vue';

const props = defineProps({
  albums: { type: Array<UserAlbum>, required: true },
  sortDate: {
    type: String,
    default: 'desc'
  }
});

const dateSortAsc = ref<boolean>(props.sortDate === 'asc');

const emits = defineEmits(['update:dateSort']);

const changeDateSort = () => {
  dateSortAsc.value = !dateSortAsc.value;
  emits('update:dateSort', dateSortAsc.value ? 'asc' : 'desc');
};
</script>

<template>
  <div class="w-full flex flex-col justify-between py-2">
    <div
      class="w-full flex justify-end px-0 md:px-4 py-1 font-semibold border-footer border-b-2 mb-2"
    >
      <div @click="changeDateSort" class="cursor-pointer">
        <span class="font-bold">
          Event Datum
          <i v-if="dateSortAsc" class="mdi mdi-arrow-down" />
          <i v-else class="mdi mdi-arrow-up" />
        </span>
      </div>
    </div>
  </div>
  <div
    class="w-full grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-1 sm:gap-2 py-2"
  >
    <template v-for="album in albums" :key="album.uuid">
      <Link
        :href="route('album.show', { album: album.uuid })"
        class="flex flex-col items-center justify-between px w-full p-2 rounded-lg bg-footer hover:bg-highlight hover:bg-opacity-25"
      >
        <img
          :src="album.cover?.url ?? '/fallback/images/no_cover_fallback.webp'"
          :alt="album.title"
          class="w-full aspect-square object-cover rounded-lg"
        />
        <div class="w-full flex flex-col justify-between px-2 py-1 flex-1">
          <span class="font-bold text-lg min-h-14">{{ album.title }}</span>
          <span class="w-full text-right">{{
            format(new Date(album.eventDate), 'dd.MM.yyyy')
          }}</span>
        </div>
      </Link>
    </template>
  </div>
</template>
