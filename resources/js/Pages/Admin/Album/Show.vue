<script setup lang="ts">
import { PropType } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import TitleSeparator from '@/Components/TitleSeparator.vue';
import { format } from 'date-fns';
import { Link } from '@inertiajs/vue3';
import { AdminAlbumInterface } from '@/types/album-interface';

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
          <i class="mdi mdi-arrow-left" /> Zurück zur Übersicht
        </Link>
        <TitleSeparator title="Albuminfo" />
        <div class="hidden lg:flex gap-x-2 px-8 text-primary mb-2">
          <div
            class="flex flex-col flex-1 bg-footer px-4 py-2 rounded-lg gap-y-2"
          >
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
              <p class="text-justify">
                {{ format(new Date(album.eventDate), 'dd.MM.yyyy') }}
              </p>
            </div>
            <div class="flex gap-2">
              <span class="font-bold shrink-0">UUID:</span>
              <p class="text-justify">{{ album.uuid }}</p>
            </div>
            <div class="flex gap-2">
              <span class="font-bold shrink-0">Link zum Album:</span>
              <Link
                class="text-justify text-blue-500"
                :href="route('album.show', {album: album.uuid})"
              >
                {{ route('album.show', {album: album.uuid}) }}
              </Link>
            </div>
            <div class="flex gap-2">
              <span class="font-bold shrink-0">Cover:</span>
              <img
                class="aspect-square w-1/2"
                :src="album.cover ?? '/images/no_cover_fallback.webp'"
                alt="Albumcover"
              />
            </div>
          </div>
          <div
            class="flex flex-col flex-1 bg-footer px-4 py-2 rounded-lg gap-y-2"
          >
            <div class="flex gap-2">
              <span class="font-bold shrink-0">Beschreibung:</span>
              <p class="text-justify">{{ album.description ?? '-' }}</p>
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
        <div
          class="grid grid-cols-3 md:grid-cols-4 lg:hidden bg-footer gap-y-2 gap-x-2 rounded-lg p-2 text-primary mb-2"
        >
          <span class="font-bold md:col-span-2">ID:</span>
          <p class="col-span-2">{{ album.id }}</p>

          <span class="font-bold md:col-span-2">Titel:</span>
          <p class="col-span-2">{{ album.title }}</p>

          <span class="font-bold md:col-span-2">Datum der Veranstaltung:</span>
          <p class="col-span-2">
            {{ format(new Date(album.eventDate), 'dd.MM.yyyy') }}
          </p>

          <span class="font-bold md:col-span-2">Beschreibung:</span>
          <p class="col-span-2">{{ album.description }}</p>

          <span class="font-bold md:col-span-2">UUID:</span>
          <p class="col-span-2 md:col-span-2">{{ album.uuid }}</p>

          <span class="font-bold md:col-span-2">Link zum Album:</span>
          <Link
            class="col-span-2 md:col-span-2 text-blue-500"
            :href="route('album.show', {album: album.uuid})"
          >
            {{ route('album.show', {album: album.uuid}) }}
          </Link>

          <span class="font-bold md:col-span-2">Direktzugang:</span>
          <img
            class="aspect-square w-full col-span-2"
            :src="album.qrCode"
            alt="QrCode"
          />

          <span class="font-bold md:col-span-2">Cover:</span>
          <img
            class="aspect-square w-full col-span-2"
            :src="album.cover ?? '/images/no_cover_fallback.webp'"
            alt="Albumcover"
          />
        </div>

        <div class="lg:px-8">
          <div class="text-primary w-full bg-footer px-4 py-2 rounded-lg">
            <div
              class="grid grid-cols-12 border-b-2 border-highlight text-secondary px-1 mb-1"
            >
              <div class="col-span-8 font-bold">Code</div>
              <div class="col-span-2 font-bold text-right">Usages</div>
              <div class="col-span-2 font-bold text-right">Saves</div>
            </div>
            <div class="grid grid-cols-12 px-1 text-primary">
              <template v-for="code in album.accessCodes" :key="code.id">
                <div class="col-span-8">{{ code.accessCode }}</div>
                <div class="col-span-2 text-right">{{ code.usages }}</div>
                <div class="col-span-2 text-right">{{ code.saves }}</div>
              </template>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
