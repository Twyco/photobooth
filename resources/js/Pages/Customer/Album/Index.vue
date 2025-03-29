<script setup lang="ts">
import {AdminAlbumInterface} from "@/types/album-interface";
import AppLayout from "@/Layouts/AppLayout.vue";
import TitleSeparator from "@/Components/TitleSeparator.vue";
import CodeInput from "@/Components/CodeInput.vue";
import {usePage} from "@inertiajs/vue3";
import { Link } from '@inertiajs/vue3';

defineProps({
  albums: Array<AdminAlbumInterface>
});

const pageProps = usePage().props;

</script>

<template>
  <AppLayout title="Meine Fotoalben">
    <div class="md:container md:mx-auto my-12 px-6 md:px-0">
      <div class="max-w-5xl md:mx-auto">
        <div class="max-w-xl mx-auto mb-12">
          <CodeInput/>
        </div>
        <TitleSeparator title="Meine Alben" />

        <div v-if="pageProps.auth.user === null"
            class="w-full flex items-center justify-center mb-4">
          <span class="text-primary text-md">Du musst angemeldet sein, um deine Gespeicherten Alben hier zu sehen zu können!</span>
        </div>
        <div v-else class="container-small mb-6">
          <ul>
            <li v-for="(album, index) in albums" :key="index">
              <Link :href="route('album.show', { album: album.uuid })">
                {{ album.title }}
              </Link>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
