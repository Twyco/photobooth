<script setup lang="ts">
import {Head, useForm} from '@inertiajs/vue3';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import AdminLayout from "@/Layouts/AdminLayout.vue";

const form = useForm({
  _method: 'post',
  title: '',
  description: '',
  event_date: new Date().toISOString().split('T')[0],
});

const storeAlbum = () => {
  form.post(route('admin.albums.store'));
};
</script>

<template>
  <Head title="Album bearbeiten"/>

  <AdminLayout>
    <form
      @submit.prevent="storeAlbum()"
      class="py-6 px-12 grid grid-cols-6 gap-8 w-full"
    >
      <div class="col-span-3">
        <InputLabel for="title" value="Titel"/>
        <TextInput
          id="title"
          v-model="form.title"
          type="text"
        />
        <InputError
          class="mt-2"
          :message="form.errors.title"
        />
      </div>
      <div class="col-span-3">
        <InputLabel
          for="event_date"
          value="Veranstaltungsdatum"
        />
        <TextInput
          id="event_date"
          v-model="form.event_date"
          type="date"
        />
        <InputError
          class="mt-2"
          :message="form.errors.event_date"
        />
      </div>
      <div class="col-span-6">
        <InputLabel
          for="description"
          value="Beschreibung"
        />
        <TextInput
          id="description"
          v-model="form.description"
          type="text"
        />
        <InputError
          class="mt-2"
          :message="form.errors.description"
        />
      </div>
      <div class="col-span-6">
        <div class="h-full place-content-end text-right">
          <PrimaryButton :disabled="form.processing"
          >Speichern
          </PrimaryButton
          >
        </div>
      </div>
    </form>
  </AdminLayout>
</template>
