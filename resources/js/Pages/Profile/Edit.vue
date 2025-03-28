<script setup lang="ts">
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import AppLayout from "@/Layouts/AppLayout.vue";
// import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';

defineProps<{
  mustVerifyEmail?: boolean;
  status?: string;
}>();
</script>

<template>
  <AppLayout title="Account">
<!--    <UpdateProfileInformationForm-->
<!--      :must-verify-email="mustVerifyEmail"-->
<!--      :status="status"-->
<!--      class="max-w-xl"-->
<!--    />-->

    <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">
      <UpdatePasswordForm class="max-w-xl" />
    </div>

    <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">
      <DeleteUserForm class="max-w-xl" />
    </div>
  </AppLayout>
</template>
