<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import NavLink from '@/Components/NavLink.vue';
</script>

<template>
    <Head title="Admin - Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Admin - Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <NavLink
                            class="mr-8"
                            :href="route('admin.albums.index')"
                        >
                            Alle Alben anzeigen
                        </NavLink>
                        <NavLink :href="route('admin.albums.create')">
                            Album erstellen
                        </NavLink>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
