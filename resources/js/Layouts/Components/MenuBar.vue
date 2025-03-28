<script setup lang="ts">

import {NavMenuItem} from "@/types";
import {Link, usePage} from '@inertiajs/vue3'

defineProps({
  menuItems: {
    type: Array<NavMenuItem>,
    default: []
  }
});

const emits = defineEmits(['update:showMenu'])

const page = usePage();

</script>

<template>
  <div class="fixed top-0 left-0 w-full bg-dark-background z-10 text-primary">
    <nav class="grid h-full w-full grid-cols-5 md:grid-cols-8 border-b-4 border-secondary">

      <div class="col-span-3 flex items-center px-6 py-4 text-center md:col-span-1">
        <Link :href="route('home')" class="w-full whitespace-nowrap text-primary font-bold md:text-2xl text-3xl">Domes Fotobox</Link>
      </div>

      <div class="col-span-2 flex items-center justify-end pr-6 md:hidden">
        <i class="mdi mdi-menu text-4xl" />
      </div>

      <div class="mx-auto hidden items-center md:col-span-5 md:flex h-full">
        <template v-for="(item, index) in menuItems" :key="index">
          <Link
            v-if="!item.button"
            :href="item.route"
            class="mx-2 px-4 w-full whitespace-nowrap text-primary h-full pt-5"
            :class="item.active ? 'border-secondary border-b-4 text-secondary font-bold' : ''"
          >
            {{ item.label }}
          </Link>
        </template>
      </div>

      <div class="flex items-center justify-end text-right md:col-span-2">
        <Link
          v-if="!page.props.auth?.user"
          :href="route('login')"
          class="mr-3 hidden rounded-lg border-white bg-dark-background px-4 py-2 text-primary md:inline-flex"
        >
          Anmelden
        </Link>
        <Link
          v-if="!page.props.auth?.user"
          :href="route('register')"
          class="mr-6 hidden rounded-lg border-white bg-secondary px-4 py-2 text-primary md:inline-flex "
        >
          Registrieren
        </Link>
      </div>
    </nav>
  </div>
</template>
