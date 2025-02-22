<script setup lang="ts">
import PaginatedTable from '@/Components/Util/PaginatedTable.vue';
import { PropType } from 'vue';
import { GenericPagination } from '@/Types/generic-pagination';
import { TableHeaderInterface } from '@/Types/table-header-interface';
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
  <AppLayout header="Alben">
    <PaginatedTable
      :data="albums"
      :path="route('admin.albums.index')"
      :headers="tableHeaders"
      create-route-name="admin.albums.create"
      title="Alle Alben"
      edit-route-name="admin.albums.edit"
      show-route-name="admin.albums.show"
      model-name="album"
    />
  </AppLayout>
</template>
