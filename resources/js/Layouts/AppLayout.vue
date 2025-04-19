<script setup lang="ts">
import { Head, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import MenuBar from '@/Layouts/Components/MenuBar.vue';
import MobileMenu from '@/Layouts/Components/MobileMenu.vue';

const props = defineProps({
  title: String,
  centerMainContentVertikal: Boolean
});

const page = usePage();

const showMenu = ref<boolean>(false);

const navMenuItems = page.props.menu.items;
</script>

<template>
  <Head :title="title"></Head>
  <div class="min-h-dvh flex flex-col">
    <header class="z-20">
      <menu-bar
        :menu-items="navMenuItems"
        @update:show-menu="showMenu = !showMenu"
      />
      <mobile-menu
        v-show="showMenu"
        :menu-items="navMenuItems"
        class="z-40"
        @update:show-menu="showMenu = !showMenu"
      />
    </header>

    <main
      class="flex-1 mt-20 z-10"
      :class="centerMainContentVertikal ? 'flex items-center' : ''"
    >
      <slot />
    </main>

    <footer class="bg-footer text-primary text-center py-1 z-10">
      <p class="px-1">&copy; 2025 Domes Fotobox. Alle Rechte vorbehalten.</p>
    </footer>
  </div>
</template>
