<script setup lang="ts">
import PaginatedTable from '@/Components/Util/PaginatedTable.vue';
import { PropType } from 'vue';
import { GenericPagination } from '@/types/generic-pagination';
import { TableHeaderInterface } from '@/types/table-header-interface';
import AppLayout from '@/Layouts/AppLayout.vue';
import TitleSeparator from '@/Components/TitleSeparator.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
  photobooths: {
    type: Object as PropType<GenericPagination>,
    required: true
  }
});

const tableHeaders: TableHeaderInterface[] = [
  { key: 'id', title: 'ID' },
  { key: 'name', title: 'Name' },
  { key: 'active_album', title: 'Album', type: 'object', objectKey: 'title' }
];
</script>

<template>
  <AppLayout title="Alben">
    <div class="md:container md:mx-auto my-12 px-6 md:px-0">
      <div class="flex w-full justify-end">
        <Link
          :href="route('admin.photobooth.create')"
          class="inline-flex whitespace-nowrap rounded-lg bg-secondary px-4 py-2 text-primary"
        >
          Neue Fotobox erstellen
        </Link>
      </div>
      <TitleSeparator title="Alle Fotoboxen" />
      <div class="max-w-5xl md:mx-auto">
        <div class="w-full flex flex-col">
          <PaginatedTable
            :data="photobooths"
            :path="route('admin.photobooth.index')"
            :headers="tableHeaders"
            edit-route-name="admin.photobooth.edit"
            show-route-name="admin.photobooth.show"
            model-name="photobooth"
          />
        </div>
      </div>
    </div>
  </AppLayout>
</template>
