<script setup lang="ts">
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Modal from '@/Components/Modal.vue';
import { useVModel } from '@/Helpers/useVModel';
import { ImageSystemImage } from '@twyco/vue-image-system';

const props = defineProps<{
  show: Boolean;
  selectedImage: ImageSystemImage | null;
}>();

const emit = defineEmits(['update:show', 'update:selectedImage']);

const show = useVModel(props, 'show', emit);
const selectedImage = useVModel(props, 'selectedImage', emit);
</script>

<template>
  <Modal
    slotClass="bg-footer p-4"
    :show="show"
    max-width="2xl"
    closeable
    @close="show = false"
  >
    <ImagePicker v-model="selectedImage" />
    <div class="w-full flex justify-end items-center pt-4">
      <PrimaryButton type="button" @click="show = false"> Ok</PrimaryButton>
    </div>
  </Modal>
</template>
