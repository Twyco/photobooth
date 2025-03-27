<script setup lang="ts">

import {NavMenuItem} from "@/types";
import {Link, usePage} from '@inertiajs/vue3'
import {computed} from "vue";

defineProps({
  menuItems: {
    type: Array<NavMenuItem>,
    default: []
  }
})

const page = usePage();

const borderStyle = computed(() => {
  return {borderBottom: `4px solid #2563eb`};
});

</script>

<template>
  <v-app-bar
    color="dark-background"
    class="text-md text-primary font-bold "
    :style="borderStyle"
    prominent
  >
    <v-toolbar-title>
      <span class="text-xl font-bold">
        Domes Fotobox
      </span>
    </v-toolbar-title>
    <v-spacer />
    <template v-for="(item, index) in menuItems" :key="index">
      <Link
        v-if="!item.button"
        :href="item.route"
        class="mr-4 inline-flex h-full items-center pt-1"
        :class="item.active ? 'border-secondary border-b-4 text-secondary' : 'border-transparent border-b-4'"
      >
        {{ item.label }}
      </Link>
    </template>
    <v-spacer />
    <Link
      v-if="!page.props.auth?.user"
      :href="route('login')"
      class="mr-4 inline-flex items-center"
    >
      Anmelden
    </Link>
    <Link
      v-if="!page.props.auth?.user"
      :href="route('register')"
      class="mr-4 block bg-secondary rounded-lg p-2"
    >
      Registrieren
    </Link>
  </v-app-bar>
</template>
