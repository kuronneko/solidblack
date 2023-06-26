<script setup>
import { ref } from 'vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import { useForm } from '@inertiajs/inertia-vue3';
import { inject } from 'vue'
import ActionSection from '@/Components/ActionSection.vue';
import DangerButton from '@/Components/DangerButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DialogModal from '@/Components/DialogModal.vue';
import InputError from '@/Components/InputError.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Inertia } from "@inertiajs/inertia";

const swal = inject('$swal');
const inputFile = ref(null);
const form = useForm({
    file: null,
})

/* defineProps({
    user: Object,
});
 */
const uploadFile = () => {
    form.post(route('import'), {
        preserveScroll: true,
        onSuccess: () => doneMessage(),
        onError: (errors) => errorMessage(errors),
        onFinish: () => form.reset(),
    });
};

const doneMessage = () => {
    form.reset();
    Toast().fire({
        icon: 'success',
        title: 'Your XLSX file was loaded successfully'
    })
};

const errorMessage = (errors) => {
    form.reset();
    Toast().fire({
        icon: 'error',
        title: errors.error
    })
};

const Toast = () => {
    return swal.mixin({
        toast: true,
        position: 'top',
        showConfirmButton: false,
        timer: 1700,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', swal.stopTimer)
            toast.addEventListener('mouseleave', swal.resumeTimer)
        }
    })
};
</script>

<template>
    <ActionSection>
        <template #title>
            Upload Logotypes
        </template>

        <template #description>
            Upload Logotypes from a file.
        </template>

        <template #content>
            <div class="max-w-xl text-sm text-gray-600">
                Import using your XLSX file (Your current logs will not be overwritten).
            </div>

            <div class="mt-5">
                <div class="flex">
                    <input @input="form.file = $event.target.files[0]"
                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none dark:bg-neutral-800 dark:border-neutral-800 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                        ref="inputFile" type="file">
                    <PrimaryButton :disabled="!form.file" class="py-2 ml-1" @click="uploadFile">
                        Upload
                    </PrimaryButton>
                </div>
                <div class="mt-2">
                    <div v-if="form.progress" class="w-full bg-gray-200 rounded-full h-2.5 mb-4 dark:bg-gray-700">
                        <div class="bg-gray-600 h-2.5 rounded-full dark:bg-gray-300" :value="form.progress.percentage"
                            max="100">
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </ActionSection>
</template>
