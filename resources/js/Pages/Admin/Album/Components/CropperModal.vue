<script setup lang="ts">

import { nextTick, ref, watch } from 'vue';
import { Cropper, type Coordinates } from 'vue-advanced-cropper';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Modal from '@/Components/Modal.vue';
import { useVModel } from '@/Helpers/useVModel';

const props = defineProps<{
  show: Boolean,
  image: String | null,
  croppedImgFile: File | null,
  croppedImgUrl: String | null,
}>();

const emit = defineEmits([
  'update:show',
  'update:croppedImgFile',
  'update:croppedImgUrl'
]);

const show = useVModel(props, 'show', emit);
const croppedImgFile = useVModel(props, 'croppedImgFile', emit);
const croppedImgUrl = useVModel(props, 'croppedImgUrl', emit);

const cropper = ref();
const canvas = ref<HTMLCanvasElement | null>(null);
const coordinates = ref<Coordinates | null>(null);

const onCropChange = ({
  coordinates: coords,
  canvas: canv
}: {
  coordinates: Coordinates;
  canvas: HTMLCanvasElement;
}) => {
  canvas.value = canv;
  coordinates.value = coords;
  updateCroppedImg();
};

const updateCroppedImg = async () => {
  if(coordinates.value && canvas.value) {
    croppedImgUrl.value = canvas.value.toDataURL('image/jpeg')
    try {
      const timestamp = Date.now();
      const fileName = `cropped_${timestamp}.jpeg`;
      const blob: Blob = await canvasToBlob(canvas.value);
      croppedImgFile.value = new File([blob], fileName, {
        type: 'image/jpeg',
      });
    }catch(e) {
      console.error('Error while creating Cover', e);
    }
  }
};

const canvasToBlob = (canvas: HTMLCanvasElement): Promise<Blob> => {
  return new Promise((resolve, reject) => {
    canvas.toBlob((blob) => {
      if (blob) {
        resolve(blob);
      } else {
        reject(new Error('Blob creation failed'));
      }
    }, 'image/jpeg');
  });
};


watch(show, async (newValue) => {
  if(newValue && coordinates.value) {
    await nextTick();
    cropper.value.setCoordinates(coordinates.value);
  }
});

const resetCanvas = () => {
  canvas.value = null;
  coordinates.value = null;
};

defineExpose({
  resetCanvas,
});
</script>

<template>
  <Modal
    slotClass="bg-footer p-4"
    :show="show"
    max-width="2xl"
    closeable
    @close="show = false"
  >
    <div class="w-full">
      <Cropper
        v-if="image"
        ref="cropper"
        :src="image"
        :stencil-props="{ aspectRatio: 1 }"
        @change="onCropChange"
      />
    </div>
    <div class="w-full flex justify-end items-center mt-4">
      <PrimaryButton type="button" @click="show = false"> Ok</PrimaryButton>
    </div>
  </Modal>
</template>
