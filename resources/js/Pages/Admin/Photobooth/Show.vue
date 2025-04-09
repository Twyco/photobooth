<script setup lang="ts">
import { PropType } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import TitleSeparator from '@/Components/TitleSeparator.vue';
import { Link } from '@inertiajs/vue3';
import Dropdown from '@/Components/Dropdown.vue';
import { Photobooth } from '@/types/photobooth-interface';

defineProps({
  photobooth: {
    type: Object as PropType<Photobooth>,
    required: true
  }
});
</script>

<template>
  <AppLayout :title="photobooth.name">
    <div class="md:container md:mx-auto my-12 px-8 md:px-0">
      <div class="max-w-5xl md:mx-auto">
        <div class="w-full flex justify-between px-1 md:px-4">
          <Link
            :href="route('admin.photobooth.index')"
            class="text-primary inline-flex py-1 rounded-lg mb-1"
          >
            <i class="mdi mdi-arrow-left" /> Zurück zur Übersicht
          </Link>
          <Dropdown content-classes="bg-footer" width="w-fit">
            <template v-slot:trigger>
              <i class="mdi mdi-dots-vertical text-2xl" />
            </template>
            <template v-slot:content>
              <div class="flex flex-col">
                <Link
                  :href="
                    route('admin.photobooth.edit', {
                      photobooth: photobooth.id
                    })
                  "
                  class="px-8 py-1 md:py-2 text-primary bg-transparent hover:bg-highlight md:rounded-lg text-center"
                >
                  Bearbeiten
                </Link>
                <Link
                  :href="
                    route('admin.photobooth.destroy', {
                      photobooth: photobooth.id
                    })
                  "
                  method="delete"
                  class="px-8 py-1 md:py-2 text-red-500 bg-transparent hover:text-primary hover:bg-highlight md:rounded-lg text-center"
                >
                  Löschen
                </Link>
              </div>
            </template>
          </Dropdown>
        </div>
        <TitleSeparator title="Fotoboxinfo" />
        <div
          class="flex flex-col bg-footer gap-y-2 rounded-lg p-2 text-primary"
        >
          <div class="flex gap-x-2">
            <span class="font-bold">ID:</span>
            <p class="col-span-2">{{ photobooth.id }}</p>
          </div>

          <div class="flex gap-x-2">
            <span class="font-bold">Name:</span>
            <p class="col-span-2">{{ photobooth.name }}</p>
          </div>

          <div class="flex gap-x-2">
            <span class="font-bold">Aktives Album:</span>
            <Link
              class="col-span-2 md:col-span-2 text-blue-500"
              :href="
                photobooth.active_album
                  ? route('admin.album.show', {
                      album: photobooth.active_album?.id
                    })
                  : '#'
              "
              >{{ photobooth.active_album?.title }}
            </Link>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
