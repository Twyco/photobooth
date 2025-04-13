<script setup lang="ts">
import { computed } from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Link, useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import TitleSeparator from "@/Components/TitleSeparator.vue";

const props = defineProps<{
  status?: string;
}>();

const form = useForm({});

const submit = () => {
  form.post(route('verification.send'));
};

const verificationLinkSent = computed(
  () => props.status === 'verification-link-sent'
);
</script>

<template>
  <AppLayout title="Email bestätigen">
    <div class="md:container md:mx-auto my-12 px-6 md:px-0">
      <div class="max-w-5xl md:mx-auto">
        <div class="max-w-lg mx-auto mt-12">
        <TitleSeparator title="Danke fürs Registrieren" />

          <div class="mb-4 text-base text-primary">
            Bevor du loslegen kannst, bestätige bitte deine E-Mail-Adresse über den Link,
            den wir dir gerade geschickt haben.
          </div>

          <div
            class="mb-4 text-sm font-medium text-green-600"
            v-if="verificationLinkSent"
          >
            Wir haben dir gerade einen neuen Bestätigungslink an deine E-Mail geschickt,
            falls du keine E-Mail erhalten hast, überprüfe auch deinen Spam-Ordner.
          </div>

          <form @submit.prevent="submit">
            <div class="mt-4 flex items-center justify-between">
              <PrimaryButton
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
              >
                Bestätigungs-Email erneut senden
              </PrimaryButton>

              <Link
                :href="route('logout')"
                method="post"
                as="button"
                class="rounded-md text-sm text-primary underline hover:text-secondary focus:outline-none focus:ring-2 focus:ring-secondary focus:ring-offset-2"
                >Ausloggen</Link
              >
            </div>
          </form>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
