<script setup lang="ts">

import {PropType, ref} from "vue";
import {GenericPagination} from "@/types/generic-pagination";
import {TableHeaderInterface} from "@/types/table-header-interface";
import {TableFilterInterface} from "@/types/table-filter-interface";
import {router} from "@inertiajs/vue3";
import {format, parseISO} from "date-fns";
import PaginationControl from "@/Components/Util/PaginationControll.vue";
import PaginationInfo from "@/Components/Util/PaginationInfo.vue";

const props = defineProps({
  data: {
    type: Object as PropType<GenericPagination>,
    required: true,
  },
  path: String,
  headers: Array<TableHeaderInterface>,
  showRouteName: String,
  editRouteName: String,
  createRouteName: String,
  title: String,
  filterOptions: Array<TableFilterInterface>,
  filterValue: String,
  searchValue: String,
  canSearch: Boolean,
  canFilter: Boolean,
  modelName: {
    type: String,
    default: '',
  }
});

const filter = ref<string>(props.filterValue ?? '');
const search = ref<string>(props.searchValue ?? '');

const fetchPage = (page: number) => {
  if (!props.path) {
    return;
  }
  if (props.canSearch && props.canFilter && (filter.value !== props.filterValue || search.value !== props.searchValue)) {
    page = 1;
  }
  router.visit(props.path, {
    method: 'get',
    data: {
      page: page,
      ...(filter.value ? {filter: filter.value} : {}),
      ...(search.value ? {search: search.value} : {}),
    },
    preserveState: true,
    preserveScroll: true,
  });
};

const visitCreatePage = () => {
  if (!props.createRouteName) {
    return;
  }
  router.visit(route(props.createRouteName), {
    method: 'get'
  })
};

const visitEditPage = (id: number) => {
  if (!props.editRouteName || !props.modelName) {
    return;
  }
  router.visit(route(props.editRouteName, {[props.modelName]: id}), {
    method: 'get'
  })
};

const visitShowPage = (id: number) => {
  if (!props.showRouteName || !props.modelName) {
    return;
  }
  router.visit(route(props.showRouteName, {[props.modelName]: id}), {
    method: 'get'
  })
};

const isoToFormattedDate = (isoString: string) => {
  return format(parseISO(isoString), "dd.MM.yyyy");
}
</script>

<template>
  <div>
    <div class="flex justify-between">
      <h1 class="text-2xk font-bold mb-4">{{ title }}</h1>
      <span v-if="createRouteName">
        <i class="mdi mdi-plus" @click="visitCreatePage"/>
      </span>
    </div>
    <!-- Search / Filter Options -->
    <div class="flex justify-between mb-5">
      <div v-if="canSearch">
        <input
          placeholder="Suchen"
          v-model="search"
          @input="fetchPage(data.currentPage)"
        />
      </div>
      <div v-if="canFilter">
        <select v-model="filter" @change="fetchPage(data.currentPage)">
          <option value="">Kein Filter</option>
          <option v-for="option in filterOptions" :value="option.id">
            {{ option.name }}
          </option>
        </select>
      </div>
    </div>
    <div class="w-full place-items-end mb-4">
      <PaginationControl
        :current-page="data.currentPage"
        :last-page="data.lastPage"
        @click="fetchPage"
      />
    </div>
    <!-- Data Table-->
    <table class="table-auto w-full border rounded-lg py-3">
      <thead>
      <tr class="bg-gray-200">
        <th v-for="header in headers" class="first:pl-2 border-b border-black py-3 text-left">
          {{ header.title }}
        </th>
        <th class="border-b border-black"/>
      </tr>
      </thead>
      <tbody>
      <tr v-for="item in data.data" :key="item.id">
        <td
          v-for="header in headers"
          class="first:pl-2 border-b border-black py-3 text-left"
          :class="showRouteName ? 'cursor-pointer' : ''"
          @click="visitShowPage(item.id)"
        >
          <span v-if="header.type === undefined">
            {{ !header.isDate ? item[header.key] : isoToFormattedDate(item[header.key]) }}
          </span>
          <span v-else-if="header.type === 'object'" v-if="header.objectKey">
            {{ item[header.key][header.objectKey] }}
          </span>
          <p
            v-else-if="header.type === 'array'"
            v-if="header.arrayKey"
            v-for="arrayItem in item[header.key]"
          >
            {{ arrayItem[header.arrayKey] }}
          </p>
          <p
            v-else-if="header.type === 'objectArray'"
            v-if="header.arrayKey && header.objectKey"
            v-for="arrayItem in item[header.key]"
          >
            {{ arrayItem[header.arrayKey][header.objectKey] }}
          </p>
        </td>
        <td v-if="editRouteName" class="border-b border-black py-3 text-center">
          <i class="mdi mdi-pencil cursor-pointer" @click="visitEditPage(item.id)"/>
        </td>
      </tr>
      </tbody>
    </table>
    <div v-if="data.data.length <= 0" class="grid place-items-center mt-2">
      Es wurden keine Daten gefunden!
    </div>

    <div class="w-full flex justify-between">
      <PaginationInfo :per-page="data.perPage" :total="data.total"
                      :current-page="data.currentPage"
      />
      <PaginationControl
        :current-page="data.currentPage"
        :last-page="data.lastPage"
        @click="fetchPage"
        class="mt-4"
      />
    </div>

  </div>
</template>
