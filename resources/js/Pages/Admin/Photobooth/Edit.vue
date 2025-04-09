<script setup lang="ts">
import { Link, useForm } from '@inertiajs/vue3';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import TitleSeparator from '@/Components/TitleSeparator.vue';
import { AdminAlbumInterface } from '@/types/album-interface';
import { computed, PropType } from 'vue';
import SelectInput from '@/Components/SelectInput.vue';
import { Photobooth } from '@/types/photobooth-interface';

const props = defineProps({
  photobooth: {
    type: Object as PropType<Photobooth>,
    required: true
  },
  albums: {
    type: Array<AdminAlbumInterface>,
    default: []
  }
});

const selectValues = computed(() => {
  return [
    { value: null, label: 'Bitte wähle ein Album aus' },
    ...props.albums.map(function (album: AdminAlbumInterface) {
      return { value: album.id, label: album.title };
    })
  ];
});

const form = useForm({
  _method: 'post',
  name: props.photobooth.name,
  activeAlbum: props.photobooth.active_album?.id ?? null
});

const storePhotobooth = () => {
  form.patch(
    route('admin.photobooth.update', {
      photobooth: props.photobooth.id
    }),
    {
      errorBag: 'updatePhotobooth'
    }
  );
};
</script>

<template>
  <AppLayout :title="`${photobooth.name} bearbeiten`">
    <div class="md:container md:mx-auto my-12 px-6 md:px-0">
      <div class="max-w-5xl md:mx-auto">
        <Link
          :href="route('admin.photobooth.index')"
          class="text-primary inline-flex ml-1 md:ml-4 py-1 rounded-lg mb-1"
        >
          <i class="mdi mdi-arrow-left" /> Zurück zur Übersicht
        </Link>
        <TitleSeparator :title="`${photobooth.name} bearbeiten`" />
        <div
          class="container-small mb-6 !pr-0 !pl-0 md:pr-[unset] md:pl-[unset]"
        >
          <form
            @submit.prevent="storePhotobooth()"
            class="flex flex-col gap-x-2 gap-y-4 md:gap-8 w-full"
          >
            <div class="flex flex-col md:flex-row w-full gap-x-2 gap-y-4">
              <div class="flex-1">
                <InputLabel for="title" value="Titel" />
                <TextInput id="title" v-model="form.name" type="text" />
                <InputError class="mt-2" :message="form.errors.name" />
              </div>
              <div class="flex-1">
                <InputLabel for="activeAlbum" value="Aktives Album" />
                <SelectInput
                  id="activeAlbum"
                  :options="selectValues"
                  v-model="form.activeAlbum"
                />
                <InputError class="mt-2" :message="form.errors.activeAlbum" />
              </div>
            </div>
            <div class="col-span-6">
              <div class="h-full place-content-end text-right">
                <PrimaryButton :disabled="form.processing"
                  >Speichern
                </PrimaryButton>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
