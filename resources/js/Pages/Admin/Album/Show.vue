<script setup lang="ts">

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head} from "@inertiajs/vue3";
import {PropType} from "vue";
import {AdminAlbumInterface} from "@/types/album-interface";

defineProps({
    album: {
        type: Object as PropType<AdminAlbumInterface>,
        required: true,
    }
});

</script>

<template>
    <Head title="Album ansicht"/>

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Admin - Album - Ansicht
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900">
                        <ul>
                            <li><b>ID:</b> {{ album.id }}</li>
                            <li><b>Titel:</b> {{ album.title }}</li>
                            <li><b>Slug:</b> {{ album.slug }}</li>
                            <li><b>Beschreibung:</b> {{ album.description }}</li>
                            <li><b>Veranstaltungsdatum:</b> {{ album.eventDate }}</li>
                            <li><b>UUID:</b> {{ album.uuid }}</li>
                            <li>
                                <b>Codes:</b>
                                <ul class="ml-2">
                                    <li v-for="accessCode in album.accessCodes">
                                        <b>Code:</b> {{accessCode.accessCode}} - <b>Usages:</b> {{accessCode.usages}} - <b>Saves:</b> {{ accessCode.saves}}
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
