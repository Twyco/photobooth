<script setup lang="ts">
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import TitleSeparator from "@/Components/TitleSeparator.vue";

defineProps<{
  canResetPassword?: boolean;
  status?: string;
}>();

const form = useForm({
  email: '',
  password: '',
  remember: false
});

const submit = () => {
  form.post(route('login'), {
    onFinish: () => {
      form.reset('password');
    }
  });
};
</script>

<template>
  <AppLayout title="Log in">
    <div class="md:container md:mx-auto my-12 px-6 md:px-0">
      <div class="max-w-5xl md:mx-auto">
        <div class="max-w-lg mx-auto mt-12">
          <TitleSeparator title="Einloggen" />
          <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
            {{ status }}
          </div>
          <form @submit.prevent="submit">
            <div>
              <InputLabel for="email" value="Email" class="ml-2" />

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

            <div class="mt-4">
              <InputLabel for="password" value="Password" class="ml-2" />

              <TextInput
                id="password"
                type="password"
                class="mt-1 block w-full"
                v-model="form.password"
                required
                autocomplete="current-password"
              />

              <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4 block">
              <label class="flex items-center">
                <Checkbox name="remember" v-model:checked="form.remember" />
                <span class="ms-2 text-sm text-primary">Remember me</span>
              </label>
            </div>

            <div class="mt-4 flex items-center justify-end">
              <Link
                v-if="canResetPassword"
                :href="route('password.request')"
                class="rounded-md text-sm text-primary underline hover:text-secondary focus:outline-none focus:ring-0 focus:ring-secondary focus:ring-offset-1"
              >
                Forgot your password?
              </Link>

              <PrimaryButton
                class="ms-4"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
              >
                Log in
              </PrimaryButton>
            </div>
          </form>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
