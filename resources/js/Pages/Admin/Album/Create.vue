<script setup lang="ts">
import { Link, useForm } from '@inertiajs/vue3';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import TitleSeparator from '@/Components/TitleSeparator.vue';
import TextareaInput from '@/Components/TextareaInput.vue';
import CoverEditor from '@/Pages/Admin/Album/Components/CoverEditor.vue';

const form = useForm({
  _method: 'post',
  title: '',
  description: '',
  event_date: new Date().toISOString().split('T')[0],
  cover: null as File | null,
  existing_cover_id: null as number | null,
  deleteCover: false as boolean
});

const storeAlbum = () => {
  form.post(route('admin.album.store'));
};
</script>

<template>
  <AppLayout title="Neues Album erstellen">
    <div class="md:container md:mx-auto my-12 px-6 md:px-0">
      <div class="max-w-5xl md:mx-auto">
        <Link
          :href="route('admin.album.index')"
          class="text-primary inline-flex ml-1 md:ml-4 py-1 rounded-lg mb-1"
        >
          <i class="mdi mdi-arrow-left" /> Zurück zur Übersicht
        </Link>
        <TitleSeparator title="Alle Alben" />
        <div
          class="container-small mb-6 !pr-0 !pl-0 md:pr-[unset] md:pl-[unset]"
        >
          <form
            @submit.prevent="storeAlbum()"
            class="flex flex-col gap-x-2 gap-y-4 md:gap-8 w-full"
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
            <div class="col-span-3">
              <InputLabel for="imageUpload" value="Cover" class="mb-1" />
              <CoverEditor
                :pre-selected-cover="null"
                v-model:cover="form.cover"
                v-model:existing-cover-id="form.existing_cover_id"
                v-model:delete-cover="form.deleteCover"
                :error="form.errors.cover"
              />
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
                  >Erstellen
                </PrimaryButton>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
