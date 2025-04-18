<script setup lang="ts">
import { Head, usePage } from '@inertiajs/vue3';
import {computed, PropType, ref} from 'vue';
import MenuBar from '@/Layouts/Components/MenuBar.vue';
import MobileMenu from '@/Layouts/Components/MobileMenu.vue';

const props = defineProps({
  title: String,
  verticalMainContentAlign: {
    type: String as PropType<'start' | 'center' | 'end'>,
    default: 'start',
  }
});

const page = usePage();

const showMenu = ref<boolean>(false);

const navMenuItems = page.props.menu.items;

const mainClass = computed(() => {
  if(props.verticalMainContentAlign === 'start') {
    return 'items-start';
  }

  if(props.verticalMainContentAlign === 'center') {
    return 'items-center';
  }

  if(props.verticalMainContentAlign === 'end') {
    return 'items-end';
  }

})
</script>

<template>
  <Head :title="title"></Head>
  <div class="min-h-screen flex flex-col">
    <header>
      <menu-bar
        :menu-items="navMenuItems"
        @update:show-menu="showMenu = !showMenu"
      />
      <mobile-menu
        v-show="showMenu"
        :menu-items="navMenuItems"
        @update:show-menu="showMenu = !showMenu"
      />
    </header>

    <main
      class="flex-1 mt-20 flex"
      :class="mainClass"
    >

      <slot />
    </main>

    <footer class="bg-footer text-primary py text-center py-1">
      <p>&copy; 2025 Domes Fotobox. Alle Rechte vorbehalten.</p>
    </footer>
  </div>
</template>
