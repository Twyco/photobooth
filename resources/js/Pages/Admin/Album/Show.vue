<script setup lang="ts">
import {PropType} from 'vue';
import {AdminAlbumInterface} from '@/types/album-interface';
import AppLayout from '@/Layouts/AppLayout.vue';
import TitleSeparator from "@/Components/TitleSeparator.vue";
import {format} from "date-fns";
import {Link} from "@inertiajs/vue3";

defineProps({
  album: {
    type: Object as PropType<AdminAlbumInterface>,
    required: true
  }
});
</script>

<template>
  <AppLayout :title="album.title">
    <div class="md:container md:mx-auto my-12 px-8 md:px-0">
      <div class="max-w-5xl md:mx-auto">
        <Link
          :href="route('admin.album.index')"
          class="text-primary inline-flex ml-2 py-1 rounded-lg mb-1"
        >
          <i class="mdi mdi-arrow-left"/> Zurück zur Übersicht
        </Link>
        <TitleSeparator title="Albuminfo"/>
        <div class="hidden lg:flex gap-x-2 px-8 text-primary mb-2">
          <div class="flex flex-col flex-1 bg-footer px-4 py-2 rounded-lg gap-y-2">
            <div class="flex gap-2">
              <span class="font-bold shrink-0">ID:</span>
              <p class="text-justify">{{ album.id }}</p>
            </div>
            <div class="flex gap-2">
              <span class="font-bold shrink-0">Titel:</span>
              <p class="text-justify">{{ album.title }}</p>
            </div>
            <div class="flex gap-2">
              <span class="font-bold shrink-0">Datum der Veranstaltung:</span>
              <p class="text-justify">{{ format(new Date(album.eventDate), 'dd.MM.yyyy') }}</p>
            </div>
            <div class="flex gap-2">
              <span class="font-bold shrink-0">UUID:</span>
              <p class="text-justify">{{ album.uuid }}</p>
            </div>
            <div class="flex gap-2">
              <span class="font-bold shrink-0">Cover:</span>
              <img
                class="aspect-square w-1/2"
                :src="album.cover  ?? '/images/no_cover_fallback.webp'"
                alt="Albumcover"
              />
            </div>
          </div>
          <div class="flex flex-col flex-1 bg-footer px-4 py-2 rounded-lg gap-y-2">
            <div class="flex gap-2">
              <span class="font-bold shrink-0">Beschreibung:</span>
              <p class="text-justify">{{ album.description }}</p>
            </div>
            <div class="flex gap-2">
              <span class="font-bold shrink-0">Direktzugang:</span>
              <img
                class="aspect-square w-1/2"
                :src="album.qrCode"
                alt="QrCode"
              />
            </div>
          </div>
        </div>
        <!--Mobile View-->
        <div class="grid grid-cols-[auto_1fr] lg:hidden bg-footer gap-y-2 gap-x-2 rounded-lg p-2 text-primary mb-2">
          <span class="font-bold">ID:</span>
          <p>{{ album.id }}</p>

          <span class="font-bold">Titel:</span>
          <p>{{ album.title }}</p>

          <span class="font-bold">Datum der Veranstaltung:</span>
          <p>{{ format(new Date(album.eventDate), 'dd.MM.yyyy') }}</p>

          <span class="font-bold">Beschreibung:</span>
          <p>{{ album.description }}</p>

          <span>UUID:</span>
          <p>{{ album.uuid }}</p>

          <span class="font-bold">Direktzugang:</span>
          <img
            class="aspect-square w-full"
            :src="album.qrCode"
            alt="QrCode"
          />

          <span class="font-bold">Cover:</span>
          <img
            class="aspect-square w-full"
            :src="album.cover  ?? '/images/no_cover_fallback.webp'"
            alt="Albumcover"
          />

        </div>
      </div>
    </div>
  </AppLayout>
</template>
