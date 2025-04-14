<script setup lang="ts">
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import TitleSeparator from "@/Components/TitleSeparator.vue";

defineProps<{
  mustVerifyEmail?: boolean;
  status?: string;
}>();
</script>

<template>
  <AppLayout title="Mein Account">
    <div class="md:container md:mx-auto my-12 px-6 md:px-0">
      <div class="max-w-5xl md:mx-auto">
        <TitleSeparator title="Mein Account" />
        <div class="container-small !px-0 md:px-[unset]">


          <div class="bg-footer p-4 shadow rounded-lg md:p-8 mb-2">
            <UpdateProfileInformationForm
              :must-verify-email="mustVerifyEmail"
              :status="status"
            />
          </div>

          <div class="bg-footer p-4 shadow rounded-lg md:p-8 mb-2">
            <UpdatePasswordForm/>
          </div>

          <div class="bg-footer p-4 shadow rounded-lg sm:p-8 mb-2">
            <DeleteUserForm/>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
