<script setup lang="ts">

import {Head, usePage} from "@inertiajs/vue3";
import {useDisplay} from "vuetify";
import {ref} from "vue";
import MobileMenuBar from "@/Layouts/Components/MobileMenuBar.vue";
import MenuBar from "@/Layouts/Components/MenuBar.vue";
import MobileNavDrawer from "@/Layouts/Components/MobileNavDrawer.vue";

defineProps({
  title: String
})

const {xs, sm} = useDisplay();
const page = usePage();

const showMobileMenu = ref<boolean>(false);

const toggleMobileMenu = () => {
  showMobileMenu.value = !showMobileMenu.value;
}

const navMenuItems = page.props.menu.items
</script>

<template>
  <Head :title="title"></Head>
  <v-app class="overflow-hidden h-screen">
    <mobile-menu-bar
      v-if="xs || sm"
      :model-value="showMobileMenu"
      :menu-items="navMenuItems"
      @update:showMobileMenu="toggleMobileMenu"
    />
    <menu-bar v-else :menu-items="navMenuItems"/>
    <mobile-nav-drawer
      v-if="(xs || sm) && showMobileMenu"
      @update:showMobileMenu="toggleMobileMenu"
    />
    <v-main class="overflow-y-auto h-full">
      <v-container>
        <slot/>
      </v-container>
    </v-main>
  </v-app>
</template>