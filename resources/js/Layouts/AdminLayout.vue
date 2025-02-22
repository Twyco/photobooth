<script setup lang="ts">
import NavLink from '@/Components/NavLink.vue';
</script>

<template>
  <header class="bg-white shadow">
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
      <div class="space-x-8 sm:-my-px sm:ms-10 sm:flex">
        <NavLink
          :href="route('admin.albums.index')"
          :active="route().current('admin.albums.index')"
        >
          Alle Alben anzeigen
        </NavLink>
        <NavLink
          :href="route('admin.albums.create')"
          :active="route().current('admin.albums.create')"
        >
          Album erstellen
        </NavLink>
      </div>
    </div>
  </header>

  <div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
      <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
        <div class="px-4 sm:px-12 py-6 text-gray-900">
          <slot name="default" />
        </div>
      </div>
    </div>
  </div>
</template>
