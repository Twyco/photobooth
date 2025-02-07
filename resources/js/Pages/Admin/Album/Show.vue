<script setup lang="ts">

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import NavLink from "@/Components/NavLink.vue";
import {Head} from "@inertiajs/vue3";
import {PropType} from "vue";

defineProps({
    album: Object as PropType<any>
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
                        <NavLink
                            :href="route('admin.dashboard')"
                        >
                            Dashboard
                        </NavLink>
                        {{ album }}
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
