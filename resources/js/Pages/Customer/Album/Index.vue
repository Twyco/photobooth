<script setup lang="ts">
import { UserAlbum } from '@/types/album-interface';
import AppLayout from '@/Layouts/AppLayout.vue';
import TitleSeparator from '@/Components/TitleSeparator.vue';
import CodeInput from '@/Components/CodeInput.vue';
import { usePage } from '@inertiajs/vue3';
import { computed, onMounted, ref } from 'vue';
import ListAlbumView from '@/Pages/Customer/Album/Components/ListAlbumView.vue';
import GridAlbumView from '@/Pages/Customer/Album/Components/GridAlbumView.vue';
import CompactAlbumView from '@/Pages/Customer/Album/Components/CompactAlbumView.vue';

const viewModes = ['compact', 'list', 'grid'] as const;
type ViewMode = (typeof viewModes)[number];

defineProps({
  albums: { type: Array<UserAlbum>, default: [] }
});

const pageProps = usePage().props;

const albumListViewMode = ref<ViewMode>('grid');

onMounted(() => {
  if (pageProps.auth.user === null) {
    return;
  }
  const savedViewMode = localStorage.getItem('albumViewMode') as ViewMode;
  if (viewModes.includes(savedViewMode)) {
    albumListViewMode.value = savedViewMode;
    return;
  }
  albumListViewMode.value = 'grid';
  localStorage.setItem('albumViewMode', albumListViewMode.value);
});

const switchViewMode = () => {
  if (pageProps.auth.user === null) {
    return;
  }
  const currentIndex = viewModes.indexOf(albumListViewMode.value);
  const nextIndex = (currentIndex + 1) % viewModes.length;
  albumListViewMode.value = viewModes[nextIndex];

  localStorage.setItem('albumViewMode', albumListViewMode.value);
};

const viewModeIcon = computed(() => {
  switch (albumListViewMode.value) {
    case 'compact':
      return 'view-headline';
    case 'list':
      return 'format-list-bulleted';
    case 'grid':
      return 'view-grid-outline';
  }
});
</script>

<template>
  <AppLayout title="Meine Fotoalben">
    <div class="md:container md:mx-auto my-12 px-6 md:px-2">
      <div class="max-w-5xl md:mx-auto">
        <div class="max-w-xl mx-auto mb-12">
          <CodeInput />
        </div>
        <TitleSeparator
          v-if="pageProps.auth.user !== null"
          title="Meine Alben"
          :icon="viewModeIcon"
          @click:icon="switchViewMode"
        />
        <TitleSeparator v-else title="Meine Alben" />

        <div
          v-if="pageProps.auth.user === null"
          class="w-full flex items-center justify-center mb-4"
        >
          <span class="text-primary text-md"
            >Du musst angemeldet sein, um deine Gespeicherten Alben hier zu
            sehen zu können!</span
          >
        </div>
        <div v-else class="w-full mb-6 mx-auto md:px-12">
          <ListAlbumView v-if="albumListViewMode === 'list'" :albums="albums" />
          <CompactAlbumView
            v-else-if="albumListViewMode === 'compact'"
            :albums="albums"
          />
          <GridAlbumView
            v-else-if="albumListViewMode === 'grid'"
            :albums="albums"
          />
        </div>
      </div>
    </div>
  </AppLayout>
</template>
