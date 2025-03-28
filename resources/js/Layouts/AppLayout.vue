<script setup lang="ts">

import {Head, usePage} from "@inertiajs/vue3";
import {ref} from "vue";
import MenuBar from "@/Layouts/Components/MenuBar.vue";

defineProps({
  title: String
})

const page = usePage();

const showMobileMenu = ref<boolean>(false);

const toggleMobileMenu = () => {
  showMobileMenu.value = !showMobileMenu.value;
}

const navMenuItems = page.props.menu.items
</script>

<template>
  <Head :title="title"></Head>
  <div class="min-h-screen flex flex-col">
    <header>
     <menu-bar :menu-items="navMenuItems" />
    </header>

    <main class="flex-1 mt-20 bg-dark-background">
      <slot/>
    </main>

    <footer class="bg-footer text-primary py text-center py-1">
      <p>&copy; 2025 Nico Schröder. Alle Rechte vorbehalten.</p>
    </footer>
  </div>
</template>


<!--      <mobile-menu-bar-->
<!--        v-if="xs || sm"-->
<!--        :model-value="showMobileMenu"-->
<!--        :menu-items="navMenuItems"-->
<!--        @update:showMobileMenu="toggleMobileMenu"-->
<!--      />-->
<!--      <menu-bar v-else :menu-items="navMenuItems"/>-->
<!--      <mobile-nav-drawer-->
<!--        v-if="(xs || sm) && showMobileMenu"-->
<!--        @update:showMobileMenu="toggleMobileMenu"-->
<!--      />-->
