<script setup lang="ts">

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head} from "@inertiajs/vue3";
import NavLink from "@/Components/NavLink.vue";

defineProps({
  header: String
})
</script>

<template>
  <Head :title="header"/>

  <AuthenticatedLayout>
    <template #header>
      <div
        class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex"
      >
        <NavLink
          v-if="$page.props.auth.user.is_admin"
          :href="route('admin.dashboard')"
          :active="route().current('admin.dashboard')"
        >
          Dashboard
        </NavLink>
        <NavLink
          :href="route('admin.albums.index')"
          :active="route().current('admin.albums.index')"
        >
          Alle Alben anzeigen
        </NavLink>
        <NavLink
          v-if="$page.props.auth.user.is_admin"
          :href="route('admin.albums.create')"
          :active="route().current('admin.albums.create')"
        >
          Album erstellen
        </NavLink>
      </div>
    </template>

    <div class="py-12">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            <slot name="default"/>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
