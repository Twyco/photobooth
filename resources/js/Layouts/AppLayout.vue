<script setup lang="ts">
import { Head, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import MenuBar from '@/Layouts/Components/MenuBar.vue';
import MobileMenu from '@/Layouts/Components/MobileMenu.vue';

defineProps({
  title: String,
  centerMainContentVertikal: Boolean
});

const page = usePage();

const showMenu = ref<boolean>(false);
const scrollY = ref<number>();

const toggleMenu = () => {
  showMenu.value = !showMenu.value;
  if (showMenu.value) {
    scrollY.value = window.scrollY;

    document.body.classList.add('overflow-hidden');
    document.documentElement.classList.add('overflow-hidden');
  } else {
    document.body.classList.remove('overflow-hidden');
    document.documentElement.classList.remove('overflow-hidden');
    if(scrollY.value) {
      window.scrollTo(0, scrollY.value);
    }
  }
}

const navMenuItems = page.props.menu.items;
</script>

<template>
  <Head :title="title"></Head>
  <div class="min-h-dvh flex flex-col">
    <header>
      <menu-bar
        :menu-items="navMenuItems"
        @update:show-menu="toggleMenu"
      />
      <mobile-menu
        v-show="showMenu"
        :menu-items="navMenuItems"
        @update:show-menu="toggleMenu"
      />
    </header>

    <main
      class="flex-1 mt-20"
      :class="centerMainContentVertikal ? 'flex items-center' : ''"
    >
      <slot />
    </main>

    <footer class="bg-footer text-primary py text-center py-1">
      <p>&copy; 2025 Domes Fotobox. Alle Rechte vorbehalten.</p>
    </footer>
  </div>
</template>
