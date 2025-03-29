<script setup lang="ts">

import {useForm} from "@inertiajs/vue3";
import CodeTextInput from "@/Components/CodeTextInput.vue";
import {ref} from "vue";


const form = useForm({
  accessCode: '',
})

const hasError = ref<boolean>(false);
const useCode = () => {
  form.post(route('accessCode.use'), {
    errorBag: 'useAlbumAccessCode',
    onError: () => {
      hasError.value = true;
      setTimeout(() => (hasError.value = false), 1000);
    }
  })
}

</script>

<template>
  <div class="rounded-lg border-secondary border-2 px-8 py-6 flex flex-col items-center justify-center shadow-xl">
    <span class="text-3xl mb-4 text-secondary font-bold">
      Code eingeben
    </span>
    <form class="w-full flex flex-col items-center justify-center" @submit.prevent="useCode">
      <CodeTextInput
        v-model="form.accessCode"
        :error="form.errors.accessCode"
        :hasError="hasError"
        id="accessCode"
        icon="mdi-lock-outline"
        placeholder="XXXXX-XXXXX-XXXXX-XXXXX-XXXXX"
        label="Albumcode hier eingeben"
      />
      <button
        type="submit"
        class="mt-3 px-4 py-2 rounded-lg block text-md bg-secondary text-primary"
      >
        Album anzeigen
      </button>
    </form>
  </div>
</template>