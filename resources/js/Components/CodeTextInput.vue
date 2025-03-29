<script setup lang="ts">
import {onMounted, ref} from 'vue';

defineProps({
  id: {type: String, required: true},
  type: {type: String, default: 'text'},
  icon: {type: String, default: null},
  placeholder: {type: String, default: null},
  label: {type: String, default: null},
  hasError: {type: Boolean, default: false},
})

const model = defineModel<string>({required: true});

const input = ref<HTMLInputElement | null>(null);

onMounted(() => {
  if (input.value?.hasAttribute('autofocus')) {
    input.value?.focus();
  }
});

defineExpose({focus: () => input.value?.focus()});
</script>

<template>
  <div
    class="flex items-center border bg-transparent rounded-md px-3 py-2 my-2 w-full"
    :class="hasError ? 'animate-shake text-red-500 border-red-500' : 'focus-within:border-secondary border-gray-500'"
  >
    <i :class="`mdi ${icon} text-2xl ${hasError ? 'text-red-500' : 'text-gray-500'}`"/>
    <div class="w-full h-full relative flex items-center justify-start">
      <input
        :type="type"
        :id="id"
        class="peer transition-all duration-300 ease-in-out w-full bg-transparent border-0 focus:border-0 ring-0 outline-none focus:ring-0 focus:outline-none placeholder-transparent focus:placeholder-gray-500"
        :class="label ? 'placeholder-transparent focus:placeholder-gray-500' : 'placeholder-gray-500'"
        v-model="model"
        :placeholder="placeholder"
        ref="input"
      />
      <label
        v-if="label"
        :for="id"
        class="absolute transition-all duration-300 ease-in-out
         peer-placeholder-shown:text-base peer-placeholder-shown:left-3 peer-placeholder-shown:top-1/2 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:bg-transparent
         peer-focus:text-sm peer-focus:left-0 peer-focus:-top-2 peer-focus:-translate-y-full peer-focus:px-2 peer-focus:bg-footer
         text-sm left-0 -top-2 -translate-y-full px-2 bg-footer"
        :class="hasError ? 'text-red-500 duration-0' : 'peer-focus:text-secondary text-primary'"
        style="line-height: 1px"
      >
        {{ label }}
      </label>
    </div>
  </div>
</template>
