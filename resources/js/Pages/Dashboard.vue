<script setup lang="ts">
import NavLink from '@/Components/NavLink.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
</script>

<template>
  <AppLayout title="Dashboard">
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Dashboard
      </h2>
    </template>

    <div class="py-12">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            <NavLink :href="route('album.index')"> Alben - Übersicht </NavLink>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
