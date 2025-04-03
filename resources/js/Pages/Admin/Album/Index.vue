<script setup lang="ts">
import PaginatedTable from '@/Components/Util/PaginatedTable.vue';
import { PropType } from 'vue';
import { GenericPagination } from '@/types/generic-pagination';
import { TableHeaderInterface } from '@/types/table-header-interface';
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
  albums: {
    type: Object as PropType<GenericPagination>,
    required: true
  }
});

const tableHeaders: TableHeaderInterface[] = [
  { key: 'id', title: 'Id' },
  { key: 'title', title: 'Albumname' },
  { key: 'eventDate', title: 'Veranstaltungsdatum', isDate: true }
];
</script>

<template>
  <AppLayout title="Alben">
    <PaginatedTable
      :data="albums"
      :path="route('admin.album.index')"
      :headers="tableHeaders"
      create-route-name="admin.album.create"
      title="Alle Alben"
      edit-route-name="admin.album.edit"
      show-route-name="admin.album.show"
      model-name="album"
    />
  </AppLayout>
</template>
