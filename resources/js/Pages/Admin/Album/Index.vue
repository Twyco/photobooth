<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { AdminAlbumInterface } from '@/types/album-interface';
import NavLink from '@/Components/NavLink.vue';

defineProps({
    albums: Array<AdminAlbumInterface>,
});
</script>

<template>
    <Head title="Alben - Übersicht" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Admin - Alben - Übersicht
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <ul>
                            <li v-for="(album, index) in albums" :key="index">
                                <NavLink
                                    :href="
                                        route('admin.albums.show', {
                                            album: album.id,
                                        })
                                    "
                                >
                                    Show: {{ album.title }}
                                </NavLink>
                                <NavLink
                                    :href="
                                        route('admin.albums.edit', {
                                            album: album.id,
                                        })
                                    "
                                >
                                    Edit: {{ album.title }}
                                </NavLink>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
