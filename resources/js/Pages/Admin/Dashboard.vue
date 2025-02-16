<script setup lang="ts">
import {Head} from '@inertiajs/vue3';
import NavLink from '@/Components/NavLink.vue';
import AdminLayout from "@/Layouts/AdminLayout.vue";
</script>

<template>
  <Head title="Admin - Dashboard"/>

  <AdminLayout>
    <NavLink
      class="mr-8"
      :href="route('admin.albums.index')"
    >
      Alle Alben anzeigen
    </NavLink>
    <NavLink :href="route('admin.albums.create')">
      Album erstellen
    </NavLink>
  </AdminLayout>
</template>
