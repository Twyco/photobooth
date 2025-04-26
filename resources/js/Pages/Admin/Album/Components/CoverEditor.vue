<script setup lang="ts">
import { ImageSystemImage } from '@twyco/vue-image-system';
import CropperModal from '@/Pages/Admin/Album/Components/CropperModal.vue';
import ImagePickerModal from '@/Pages/Admin/Album/Components/ImagePickerModal.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import { ref } from 'vue';
import { useVModel } from '@/Helpers/useVModel';

const props = defineProps<{
  preSelectedCover: ImageSystemImage | null;
  cover: File | null,
  existingCoverId: number | null,
  deleteCover: boolean,
  error: string | undefined,
}>();

const emit = defineEmits([
  'update:cover',
  'update:existingCoverId',
  'update:deleteCover',
]);

const coverVModel = useVModel(props, 'cover', emit);
const existingCoverIdVModel = useVModel(props, 'existingCoverId', emit);
const deleteCoverVModel = useVModel(props, 'deleteCover', emit);

const cropper = ref();
const showCropper = ref<boolean>(false);
const showImagePicker = ref<boolean>(false);

const imageUpload = ref<HTMLInputElement | null>(null);
const image = ref<string | null>(props.preSelectedCover?.url ?? null);
const coverPreviewUrl = ref<string | null>(props.preSelectedCover?.url ?? null);
const selectedCover = ref<ImageSystemImage | null>(props.preSelectedCover ?? null);

const onFileChange = (e: Event) => {
  const file = (e.target as HTMLInputElement).files?.[0];
  image.value = !!file ? URL.createObjectURL(file) : null;
  coverPreviewUrl.value = null;
  coverVModel.value = null;
  existingCoverIdVModel.value = null;
  deleteCoverVModel.value = !file;
  selectedCover.value = null;
  cropper.value?.resetCanvas();
  showCropper.value = !!file;
};

const onCropped = (newCover: File | null) => {
  if (!newCover) return;
  deleteCoverVModel.value = false;
  existingCoverIdVModel.value = null;
  selectedCover.value = null;
}

const onSelectedCoverChange = (newCover: ImageSystemImage | null) => {
  if (!newCover) {
    delCover();
    return;
  }
  if(imageUpload.value?.value) imageUpload.value.value = '';
  deleteCoverVModel.value = false;
  coverVModel.value = null;
  existingCoverIdVModel.value = newCover.id;
  image.value = newCover.url;
  coverPreviewUrl.value = newCover.url;
  cropper.value?.resetCanvas();
}

const delCover = () => {
  deleteCoverVModel.value = true;
  coverVModel.value = null;
  existingCoverIdVModel.value = null;
  image.value = null;
  coverPreviewUrl.value = null;
  selectedCover.value = null;
  cropper.value?.resetCanvas();
};
</script>

<template>
  <CropperModal
    ref="cropper"
    :image="image"
    v-model:show="showCropper"
    v-model:cropped-img-url="coverPreviewUrl"
    v-model:cropped-img-file="coverVModel"
    @update:cropped-img-file="onCropped"
  />
  <ImagePickerModal
    v-model:show="showImagePicker"
    v-model:selected-image="selectedCover"
    @update:selected-image="onSelectedCoverChange"
  />
  <div class="flex flex-col-reverse md:flex-row gap-y-4">
    <div class="flex flex-col gap-y-2 md:gap-y-4">
      <input
        ref="imageUpload"
        id="imageUpload"
        type="file"
        accept="image/*"
        @change="onFileChange"
      />
      <InputError class="mt-2" :message="error" />

      <SecondaryButton
        v-if="image"
        class="w-fit"
        @click="image && (showCropper = true)"
      >
        Zuschneiden
      </SecondaryButton>

      <DangerButton
        v-if="!deleteCoverVModel && coverPreviewUrl"
        class="w-fit"
        type="button"
        @click="delCover()"
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
</template>