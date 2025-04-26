<script setup lang="ts">
import { Link, router, useForm } from '@inertiajs/vue3';
import { PropType, ref } from 'vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { AdminAlbumInterface } from '@/types/album-interface';
import AppLayout from '@/Layouts/AppLayout.vue';
import TitleSeparator from '@/Components/TitleSeparator.vue';
import Dropdown from '@/Components/Dropdown.vue';
import TextareaInput from '@/Components/TextareaInput.vue';
import 'vue-advanced-cropper/dist/style.css';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import { ImageSystemImage } from '@twyco/vue-image-system';
import CropperModal from '@/Pages/Admin/Album/Components/CropperModal.vue';
import ImagePickerModal from '@/Pages/Admin/Album/Components/ImagePickerModal.vue';

const props = defineProps({
  album: {
    type: Object as PropType<AdminAlbumInterface>,
    required: true
  }
});
const cropper = ref();
const showCropper = ref<boolean>(false);
const showImagePicker = ref<boolean>(false);

const imageUpload = ref<HTMLInputElement | null>(null);
const image = ref<string | null>(props.album?.cover?.url ?? null);
const coverPreviewUrl = ref<string | null>(props.album?.cover?.url ?? null);
const selectedCover = ref<ImageSystemImage | null>(props.album?.cover ?? null);

const form = useForm({
  _method: 'put',
  title: props.album.title,
  description: props.album.description,
  event_date: props.album.eventDate.split('T')[0],
  cover: null as File | null,
  existing_cover_id: props.album?.cover?.id ?? null,
  deleteCover: false as boolean
});

const onFileChange = (e: Event) => {
  const file = (e.target as HTMLInputElement).files?.[0];
  image.value = !!file ? URL.createObjectURL(file) : null;
  coverPreviewUrl.value = null;
  form.cover = null;
  form.existing_cover_id = null;
  form.deleteCover = !file;
  selectedCover.value = null;
  cropper.value?.resetCanvas();
  showCropper.value = !!file;
};

const onCropped = (newCover: File | null) => {
  if (!newCover) return;
  form.deleteCover = false;
  form.existing_cover_id = null;
  selectedCover.value = null;
}

const onSelectedCoverChange = (newCover: ImageSystemImage | null) => {
  if (!newCover) {
    deleteCover();
    return;
  }
  if(imageUpload.value?.value) imageUpload.value.value = '';
  form.deleteCover = false;
  form.cover = null;
  form.existing_cover_id = newCover.id;
  image.value = newCover.url;
  coverPreviewUrl.value = newCover.url;
  cropper.value?.resetCanvas();
}

const deleteCover = () => {
  form.deleteCover = true;
  form.cover = null;
  form.existing_cover_id = null;
  image.value = null;
  coverPreviewUrl.value = null;
  selectedCover.value = null;
  cropper.value?.resetCanvas();
};

const deleteAccessCode = (id: number) => {
  router.delete(route('admin.accessCode.destroy', { albumAccessCode: id }));
};

const createAccessCode = () => {
  router.post(route('admin.accessCode.store'), { albumId: props.album.id });
};

const storeAlbum = async () => {
  form.post(route('admin.album.update', { album: props.album.id }));
};
</script>

<template>
  <CropperModal
    ref="cropper"
    :image="image"
    v-model:show="showCropper"
    v-model:cropped-img-url="coverPreviewUrl"
    v-model:cropped-img-file="form.cover"
    @update:cropped-img-file="onCropped"
  />
  <ImagePickerModal
    v-model:show="showImagePicker"
    v-model:selected-image="selectedCover"
    @update:selected-image="onSelectedCoverChange"
  />
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
          <div class="pb-2">
            <p>
              <span class="select-none font-bold">UUID: </span>{{ album.uuid }}
            </p>
          </div>
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
            <div class="col-span-3">
              <InputLabel for="imageUpload" value="Cover" class="mb-1" />
              <div class="flex flex-col-reverse md:flex-row gap-y-4">
                <div class="flex flex-col gap-y-2 md:gap-y-4">
                  <input
                    ref="imageUpload"
                    id="imageUpload"
                    type="file"
                    accept="image/*"
                    @change="onFileChange"
                  />
                  <InputError class="mt-2" :message="form.errors.cover" />

                  <SecondaryButton
                    v-if="image"
                    class="w-fit"
                    @click="image && (showCropper = true)"
                  >
                    Zuschneiden
                  </SecondaryButton>

                  <DangerButton
                    v-if="!form.deleteCover && coverPreviewUrl"
                    class="w-fit"
                    type="button"
                    @click="deleteCover()"
                  >
                    Cover Löschen
                  </DangerButton>

                  <PrimaryButton
                    type="button"
                    class="w-fit"
                    @click="showImagePicker = true"
                  >
                    Vorhandenes Cover auswählen
                  </PrimaryButton>
                </div>
                <img
                  v-if="coverPreviewUrl"
                  :src="coverPreviewUrl"
                  class="w-64 object-contain"
                  alt="cover"
                />
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
