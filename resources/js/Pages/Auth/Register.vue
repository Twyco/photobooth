<script setup lang="ts">
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import TitleSeparator from '@/Components/TitleSeparator.vue';

const form = useForm({
  name: '',
  email: '',
  password: '',
  password_confirmation: ''
});

const submit = () => {
  form.post(route('register'), {
    onFinish: () => {
      form.reset('password', 'password_confirmation');
    }
  });
};
</script>

<template>
  <AppLayout title="Register">
    <div class="md:container md:mx-auto my-12 px-6 md:px-0">
      <div class="max-w-5xl md:mx-auto">
        <div class="max-w-lg mx-auto mt-12">
          <TitleSeparator title="Konto erstellen" />
          <form @submit.prevent="submit">
            <div>
              <InputLabel for="name" value="Name" class="ml-2" />

              <TextInput
                id="name"
                type="text"
                class="mt-1 block w-full"
                v-model="form.name"
                required
                autofocus
                autocomplete="name"
              />

              <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="mt-4">
              <InputLabel for="email" value="Email" class="ml-2" />

              <TextInput
                id="email"
                type="email"
                class="mt-1 block w-full"
                v-model="form.email"
                required
                autocomplete="username"
              />

              <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
              <InputLabel for="password" value="Password" class="ml-2" />

              <TextInput
                id="password"
                type="password"
                class="mt-1 block w-full"
                v-model="form.password"
                required
                autocomplete="new-password"
              />

              <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
              <InputLabel
                for="password_confirmation"
                value="Confirm Password"
                class="ml-2"
              />

              <TextInput
                id="password_confirmation"
                type="password"
                class="mt-1 block w-full"
                v-model="form.password_confirmation"
                required
                autocomplete="new-password"
              />

              <InputError
                class="mt-2"
                :message="form.errors.password_confirmation"
              />
            </div>

            <div class="mt-4 flex items-center justify-end">
              <Link
                :href="route('login')"
                class="rounded-md text-sm text-primary underline hover:text-secondary focus:outline-none focus:ring-0 focus:ring-secondary focus:ring-offset-1"
              >
                Bereits ein Konto? Jetzt einloggen.
              </Link>

              <PrimaryButton
                class="ms-4"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
              >
                Register
              </PrimaryButton>
            </div>
          </form>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
