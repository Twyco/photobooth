<script setup lang="ts">
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import TitleSeparator from "@/Components/TitleSeparator.vue";

defineProps<{
  status?: string;
}>();

const form = useForm({
  email: ''
});

const submit = () => {
  form.post(route('password.email'));
};
</script>

<template>
  <AppLayout title="Passwort zurücksetzen">
    <div class="md:container md:mx-auto my-12 px-6 md:px-0">
      <div class="max-w-5xl md:mx-auto">
        <div class="max-w-lg mx-auto mt-12">
          <TitleSeparator title="Passwort vergessen?" />

            <div class="mb-4 text-base text-primary">
              <p>
                Kein Problem!
              </p>
              <p>
                Gib einfach deine E-Mail-Adresse an und wir schicken dir einen Link,
                mit dem du ein neues Passwort festlegen kannst.
              </p>
            </div>

            <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
              {{ status }}
            </div>

          <form @submit.prevent="submit">
            <div>
              <InputLabel for="email" value="Email" />

              <TextInput
                id="email"
                type="email"
                class="mt-1 block w-full"
                v-model="form.email"
                required
                autofocus
                autocomplete="username"
              />

              <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4 flex items-center justify-end">
              <PrimaryButton
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
              >
                Passwort zurücksetzen
              </PrimaryButton>
            </div>
          </form>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
