<script setup lang="ts">

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, router, useForm} from "@inertiajs/vue3";
import {PropType} from "vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {AdminAlbumInterface} from "@/types/album-interface";
import DangerButton from "@/Components/DangerButton.vue";

const props = defineProps({
    album: {
        type: Object as PropType<AdminAlbumInterface>,
        required: true,
    },
});

const form = useForm({
    _method: "post",
    title: props.album.title,
    description: props.album.description,
    event_date: props.album.eventDate.split('T')[0],
})

const storeAlbum = () => {
    form
        .transform((data) => ({
            ...(data.title != props.album.title ? {title: data.title} : {}),
            ...(data.description != props.album.description ? {description: data.description} : {}),
            ...(data.event_date != props.album.eventDate.split('T')[0] ? {event_date: data.event_date} : {})
        }))
        .patch(route('admin.albums.update', {album: props.album.id}))
}

const deleteAlbum = () => {
    router.delete(route('admin.albums.destroy', {album: props.album.id}))
}

const deleteAccessCode = (id: number) => {
    router.delete(route('admin.accessCode.destroy', {albumAccessCode: id}))
}

const createAccessCode = () => {
    router.post(route('admin.accessCode.store'), {albumId: props.album.id})
}

</script>

<template>
    <Head title="Album bearbeiten"/>

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Album bearbeiten
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >
                    <form
                        @submit.prevent="storeAlbum()"
                        class="py-6 px-12 grid grid-cols-6 gap-8 w-full"
                    >
                        <div class="col-span-3">
                            <InputLabel for="title" value="Titel"/>
                            <TextInput
                                id="title"
                                v-model="form.title"
                                type="text"
                            />
                            <InputError class="mt-2" :message="form.errors.title"/>
                        </div>
                        <div class="col-span-3">
                            <InputLabel for="event_date" value="Veranstaltungsdatum"/>
                            <TextInput
                                id="event_date"
                                v-model="form.event_date"
                                type="date"
                            />
                            <InputError class="mt-2" :message="form.errors.event_date"/>
                        </div>
                        <div class="col-span-6">
                            <InputLabel for="description" value="Beschreibung"/>
                            <TextInput
                                id="description"
                                v-model="form.description"
                                type="text"
                            />
                            <InputError class="mt-2" :message="form.errors.description"/>
                        </div>
                        <div class="col-span-6">
                            <div class="h-full place-content-end text-right">
                                <DangerButton
                                    class="mr-2"
                                    type="button"
                                    :disabled="form.processing"
                                    @click="deleteAlbum()"
                                >Löschen
                                </DangerButton>
                                <PrimaryButton :disabled="form.processing">Speichern</PrimaryButton>
                            </div>
                        </div>
                    </form>
                    <div class="py-6 px-12 grid grid-cols-6 gap-8 w-full">
                        <div class="col-span-6">
                            Zugangscodes:
                            <!--Paginated Table:-->
                            <table>
                                <thead>
                                <tr class="bg-gray-100 border-b-2 border-black">
                                    <th class="px-4">ID</th>
                                    <th class="px-4">Code</th>
                                    <th class="px-4">Anzahl der Benutzungen</th>
                                    <th class="px-4">Anzahl der Speicherungen</th>
                                    <th class="px-4"><i class="mdi mdi-plus hover:cursor-pointer" @click="createAccessCode()"/></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-if="album.accessCodes"
                                    v-for="accessCode in album.accessCodes"
                                    class="even:bg-gray-100 odd:bg-white"
                                >
                                    <td class="px-4 text-center">{{ accessCode.id }}</td>
                                    <td class="px-4 text-center">{{ accessCode.accessCode }}</td>
                                    <td class="px-4 text-center">{{ accessCode.usages }}</td>
                                    <td class="px-4 text-center">{{ accessCode.saves }}</td>
                                    <td class="px-4 text-center text-red-500 hover:cursor-pointer"
                                        @click="deleteAccessCode(accessCode.id)"><i class="mdi mdi-trash-can"/></td>
                                </tr>
                                <tr v-else>
                                    <td :colspan="4" class="px-4 text-center">Es existiert noch kein Zugangscode zu diesem Album!</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
