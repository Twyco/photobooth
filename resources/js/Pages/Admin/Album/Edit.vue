<script setup lang="ts">
import { Link, router, useForm } from '@inertiajs/vue3';
import { PropType } from 'vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { AdminAlbumInterface } from '@/types/album-interface';
import AppLayout from '@/Layouts/AppLayout.vue';
import TitleSeparator from '@/Components/TitleSeparator.vue';
import Dropdown from '@/Components/Dropdown.vue';
import TextareaInput from '@/Components/TextareaInput.vue';

const props = defineProps({
  album: {
    type: Object as PropType<AdminAlbumInterface>,
    required: true
  }
});

const form = useForm({
  _method: 'post',
  title: props.album.title,
  description: props.album.description,
  event_date: props.album.eventDate.split('T')[0]
});

const storeAlbum = () => {
  form
    .transform((data) => ({
      ...(data.title != props.album.title ? { title: data.title } : {}),
      ...(data.description != props.album.description
        ? { description: data.description }
        : {}),
      ...(data.event_date != props.album.eventDate.split('T')[0]
        ? { event_date: data.event_date }
        : {})
    }))
    .patch(route('admin.album.update', { album: props.album.id }));
};

const deleteAlbum = () => {
  router.delete(route('admin.album.destroy', { album: props.album.id }));
};

const deleteAccessCode = (id: number) => {
  router.delete(route('admin.accessCode.destroy', { albumAccessCode: id }));
};

const createAccessCode = () => {
  router.post(route('admin.accessCode.store'), { albumId: props.album.id });
};
</script>

<template>
  <AppLayout title="Album bearbeiten">
    <div class="md:container md:mx-auto my-12 px-6 md:px-0">
      <div class="max-w-5xl md:mx-auto">
        <div class="w-full flex justify-between px-1 md:px-4">
          <Link
            :href="route('admin.album.index')"
            class="text-primary inline-flex py-1 rounded-lg mb-1"
          >
            <i class="mdi mdi-arrow-left" /> Zurück zur Übersicht
          </Link>
          <Dropdown content-classes="bg-footer" width="w-fit">
            <template v-slot:trigger>
              <i class="mdi mdi-dots-vertical text-2xl" />
            </template>
            <template v-slot:content>
              <div class="flex flex-col">
                <Link
                  :href="route('admin.album.destroy', { album: album.id })"
                  method="delete"
                  class="px-8 py-1 md:py-2 text-red-500 bg-transparent hover:text-primary hover:bg-highlight md:rounded-lg text-center"
                >
                  Löschen
                </Link>
              </div>
            </template>
          </Dropdown>
        </div>
        <TitleSeparator :title="`${album.title} - bearbeiten`" />
        <div
          class="container-small mb-6 !pr-0 !pl-0 md:pr-[unset] md:pl-[unset]"
        >
          <form
            @submit.prevent="storeAlbum()"
            class="flex flex-col gap-x-2 gap-y-4 md:gap-8 w-full mb-4"
          >
            <div class="flex flex-col md:flex-row w-full gap-x-2 gap-y-4">
              <div class="flex-1">
                <InputLabel for="title" value="Titel" />
                <TextInput id="title" v-model="form.title" type="text" />
                <InputError class="mt-2" :message="form.errors.title" />
              </div>
              <div class="flex-1">
                <InputLabel for="event_date" value="Veranstaltungsdatum" />
                <TextInput
                  id="event_date"
                  v-model="form.event_date"
                  type="date"
                />
                <InputError class="mt-2" :message="form.errors.event_date" />
              </div>
            </div>
            <div class="col-span-6">
              <InputLabel for="description" value="Beschreibung" />
              <TextareaInput
                id="description"
                v-model="form.description"
                type="textarea"
              />
              <InputError class="mt-2" :message="form.errors.description" />
            </div>
            <div class="col-span-6">
              <div class="h-full place-content-end text-right">
                <PrimaryButton :disabled="form.processing"
                  >Speichern
                </PrimaryButton>
              </div>
            </div>
          </form>

          <!--          AccessCodes-->
          <div class="w-full">
            <InputLabel value="Zugangscodes:" />
            <table class="w-full">
              <thead>
                <tr
                  class="font-semibold border-footer border-b-2 mb-2 text-left"
                >
                  <th class="px-4">ID</th>
                  <th class="px-4">Code</th>
                  <th class="px-4">Usages</th>
                  <th class="px-4">Saves</th>
                  <th class="px-4 text-center">
                    <i
                      class="mdi mdi-plus hover:cursor-pointer"
                      @click="createAccessCode()"
                    />
                  </th>
                </tr>
              </thead>

              <tbody>
                <tr
                  v-if="album.accessCodes"
                  v-for="accessCode in album.accessCodes"
                  class="text-left hover:bg-highlight hover:bg-opacity-25"
                >
                  <td class="px-4">
                    {{ accessCode.id }}
                  </td>
                  <td class="px-4">
                    {{ accessCode.accessCode }}
                  </td>
                  <td class="px-4">
                    {{ accessCode.usages }}
                  </td>
                  <td class="px-4">
                    {{ accessCode.saves }}
                  </td>
                  <td
                    class="px-4 text-center text-red-500 hover:cursor-pointer"
                    @click="deleteAccessCode(accessCode.id)"
                  >
                    <i class="mdi mdi-trash-can" />
                  </td>
                </tr>
                <tr v-else>
                  <td :colspan="4" class="px-4 text-center">
                    Es existiert noch kein Zugangscode zu diesem Album!
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
