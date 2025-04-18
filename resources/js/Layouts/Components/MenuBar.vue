<script setup lang="ts">
import { NavMenuItem } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';

defineProps({
  menuItems: {
    type: Array<NavMenuItem>,
    default: []
  }
});

const emits = defineEmits(['update:showMenu']);

const page = usePage();
</script>

<template>
  <div class="w-full bg-dark-background z-10 text-primary">
    <nav
      class="grid h-full w-full grid-cols-5 md:grid-cols-8 border-b-4 border-secondary"
    >
      <div
        class="col-span-3 flex items-center px-6 py-4 text-center md:col-span-1"
      >
        <Link
          :href="route('home')"
          class="w-full whitespace-nowrap text-primary font-bold md:text-2xl text-3xl"
          >Domes Fotobox</Link
        >
      </div>

      <div class="col-span-2 flex items-center justify-end pr-6 md:hidden">
        <i class="mdi mdi-menu text-4xl" @click="emits('update:showMenu')" />
      </div>

      <div class="mx-auto hidden items-center md:col-span-5 md:flex h-full">
        <Link
          v-for="(item, index) in menuItems"
          :key="index"
          :href="item.route"
          class="mx-2 px-4 w-full whitespace-nowrap text-primary h-full pt-5"
          :class="
            item.active
              ? 'border-secondary border-b-4 text-secondary font-bold'
              : ''
          "
        >
          {{ item.label }}
        </Link>
      </div>

      <div class="flex items-center justify-end text-right md:col-span-2">
        <template v-if="!page.props.auth?.user">
          <Link
            :href="route('login')"
            class="mr-3 hidden whitespace-nowrap rounded-lg bg-dark-background px-4 py-2 text-primary md:inline-flex"
          >
            Anmelden
          </Link>
          <Link
            :href="route('register')"
            class="mr-6 hidden whitespace-nowrap rounded-lg bg-secondary px-4 py-2 text-primary md:inline-flex"
          >
            Registrieren
          </Link>
        </template>
        <template v-else>
          <template v-if="page.props.auth.user.is_admin">
            <Link
              v-if="page.props.menu.isAdminPage"
              :href="route('home')"
              class="hidden text-sm bg-gray-700 px-2 py-1 rounded-lg md:inline-flex"
            >
              User
            </Link>
            <Link
              v-else
              :href="route('admin.dashboard')"
              class="hidden text-sm bg-red-700 px-2 py-1 rounded-lg md:inline-flex"
            >
              Admin
            </Link>
          </template>
          <Link
            :href="route('logout')"
            method="post"
            class="mr-3 hidden whitespace-nowrap rounded-lg bg-dark-background px-4 py-2 text-primary md:inline-flex"
          >
            Ausloggen
          </Link>
          <Link
            :href="route('profile.edit')"
            class="mr-6 hidden whitespace-nowrap rounded-lg bg-secondary px-4 py-2 text-primary md:inline-flex"
          >
            Mein Account
          </Link>
        </template>
      </div>
    </nav>
  </div>
</template>
