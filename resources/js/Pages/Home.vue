<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const form = useForm({
    _method: 'POST',
    accessCode: '',
});

const showAlbum = () => {
    form.post(route('accessCode.use'), {
        errorBag: 'useAlbumAccessCode',
    });
};
</script>

<template>
    <Head title="Dashboard" />
    <div class="w-full grid place-items-center text-center">
        <div class="pt-8 px-8 w-1/2">
            <form @submit.prevent="showAlbum">
                <InputLabel for="accessCode" value="Albumcode" />
                <TextInput
                    id="accessCode"
                    v-model="form.accessCode"
                    placeholder="Album Code hier eingeben"
                    type="text"
                />
                <InputError class="mt-2" :message="form.errors.accessCode" />
                <PrimaryButton class="mt-2">Album Anzeigen</PrimaryButton>
            </form>
        </div>
    </div>
</template>
