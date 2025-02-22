<script setup lang="ts">
import { Head, usePage } from '@inertiajs/vue3';
import { PageProps } from '@/Types';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';

defineProps({
  header: String
});

const pageProps = usePage<PageProps>().props;
const isAuthenticated = !!pageProps.auth.user;
</script>

<template>
  <Head :title="header" />
  <AuthenticatedLayout v-if="isAuthenticated">
    <slot name="default" />
  </AuthenticatedLayout>
  <GuestLayout v-else>
    <slot name="default" />
  </GuestLayout>
</template>
