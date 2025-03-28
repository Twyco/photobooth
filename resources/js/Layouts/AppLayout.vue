<script setup lang="ts">

import {Head, usePage} from "@inertiajs/vue3";
import {ref} from "vue";
import MenuBar from "@/Layouts/Components/MenuBar.vue";
import MobileMenu from "@/Layouts/Components/MobileMenu.vue";

defineProps({
  title: String
})

const page = usePage();

const showMenu = ref<boolean>(false);

const navMenuItems = page.props.menu.items
</script>

<template>
  <Head :title="title"></Head>
  <div class="min-h-screen flex flex-col">
    <header>
      <menu-bar :menu-items="navMenuItems" @update:show-menu="showMenu = !showMenu"/>
      <mobile-menu v-show="showMenu" :menu-items="navMenuItems" @update:show-menu="showMenu = !showMenu"/>
    </header>

    <main class="flex-1 mt-20 bg-dark-background">
      <slot/>
    </main>

    <footer class="bg-footer text-primary py text-center py-1">
      <p>&copy; 2025 Nico Schröder. Alle Rechte vorbehalten.</p>
    </footer>
  </div>
</template>