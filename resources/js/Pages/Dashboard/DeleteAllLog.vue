<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/inertia-vue3';
import { inject } from 'vue'
import ActionSection from '@/Components/ActionSection.vue';
import DangerButton from '@/Components/DangerButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DialogModal from '@/Components/DialogModal.vue';
import InputError from '@/Components/InputError.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';


const confirmingLogDeletion = ref(false);
const passwordInput = ref(null);
const swal = inject('$swal');

const form = useForm({
    password: '',
});

/* defineProps({
    user: Object,
});
 */

const confirmLogDeletion = () => {
    confirmingLogDeletion.value = true;

    setTimeout(() => passwordInput.value.focus(), 250);
};

const deleteLog = () => {
    form.delete(route('delete_all_logs'), {
        preserveScroll: true,
        onSuccess: () => doneMessage(),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingLogDeletion.value = false;
    form.reset();
};

const doneMessage = () => {
    Toast().fire({
        icon: 'success',
        title: 'All Logs was deleted successfully'
    })
    closeModal();
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
            Delete Logs
        </template>

        <template #description>
            Permanently delete all your logs.
        </template>

        <template #content>
            <div class="max-w-xl text-sm text-gray-600">
                Once your logs is deleted, all of its resources and data will be permanently deleted. Before deleting
                your logs, please download any data or information that you wish to retain.
            </div>

            <div class="mt-5">
                <DangerButton class="py-3" @click="confirmLogDeletion">
                    Delete Logs
                </DangerButton>
            </div>

            <!-- Delete Logs Confirmation Modal -->
            <DialogModal :show="confirmingLogDeletion" @close="closeModal">
                <template #title>
                    Delete Logs
                </template>

                <template #content>
                    Are you sure you want to delete your logs? Once your logs is deleted, all of its resources and
                    data will be permanently deleted. Please enter your password to confirm you would like to
                    permanently delete your logs.

                    <div class="mt-4">
                        <TextInput ref="passwordInput" v-model="form.password" type="password" class="mt-1 block w-3/4"
                            placeholder="Password" @keyup.enter="deleteLog" />

                        <InputError :message="form.errors.password" class="mt-2" />
                    </div>
                </template>

                <template #footer>
                    <SecondaryButton @click="closeModal">
                        Cancel
                    </SecondaryButton>

                    <DangerButton class="ml-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                        @click="deleteLog">
                        Delete Logs
                    </DangerButton>
                </template>
            </DialogModal>
        </template>
    </ActionSection>
</template>
