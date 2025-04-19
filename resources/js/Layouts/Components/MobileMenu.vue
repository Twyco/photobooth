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
  <div
    class="md:hidden flex flex-col min-h-dvh absolute top-0 left-0 bg-footer w-full z-50"
  >
    <div class="grid grid-cols-5 w-full text-primary">
      <div class="col-span-3 flex items-center px-6 py-4 text-center">
        <Link
          :href="route('home')"
          class="w-full whitespace-nowrap text-primary font-bold md:text-2xl text-3xl"
          >Domes Fotobox</Link
        >
      </div>

      <div class="col-span-2 flex items-center justify-end pr-6">
        <i
          class="mdi mdi-close text-4xl z-50"
          @click="emits('update:showMenu')"
        />
      </div>
    </div>

    <div class="grid grid-cols-1 w-full divide-primary gap-y-3 divide-y-2 px-3">
      <Link
        v-for="(item, index) in menuItems"
        :key="index"
        :href="item.route"
        class="whitespace-nowrap px-3 pt-3 text-xl h-full"
        :class="item.active ? 'text-secondary font-bold' : 'text-primary'"
      >
        {{ item.label }}
      </Link>
    </div>

    <div class="flex flex-col items-center px-6 pb-6 mt-auto">
      <template v-if="!page.props.auth?.user">
        <Link
          :href="route('login')"
          class="inline-flex items-center justify-center w-full whitespace-nowrap rounded-lg bg-dark-background px-4 py-2 text-primary"
        >
          Anmelden
        </Link>
        <Link
          :href="route('register')"
          class="inline-flex mt-3 items-center justify-center w-full whitespace-nowrap rounded-lg bg-secondary px-4 py-2 text-primary"
        >
          Registrieren
        </Link>
      </template>
      <template v-else>
        <template v-if="page.props.auth.user.is_admin">
          <Link
            v-if="page.props.menu.isAdminPage"
            :href="route('home')"
            class="inline-flex mb-3 items-center justify-center w-full whitespace-nowrap rounded-lg bg-gray-700 px-4 py-2 text-primary"
          >
            User
          </Link>
          <Link
            v-else
            :href="route('admin.dashboard')"
            class="inline-flex mb-3 items-center justify-center w-full whitespace-nowrap rounded-lg bg-red-700 px-4 py-2 text-primary"
          >
            Admin
          </Link>
        </template>
        <Link
          :href="route('logout')"
          method="post"
          class="inline-flex items-center justify-center w-full whitespace-nowrap rounded-lg bg-dark-background px-4 py-2 text-primary"
        >
          Ausloggen
        </Link>
        <Link
          :href="route('profile.edit')"
          class="inline-flex mt-3 items-center justify-center w-full whitespace-nowrap rounded-lg bg-secondary px-4 py-2 text-primary"
        >
          Mein Account
        </Link>
      </template>
    </div>
  </div>
</template>
