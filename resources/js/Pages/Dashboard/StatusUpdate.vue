<script setup>
import { ref, reactive, onMounted } from 'vue';
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

import JetPrimaryButton from "@/Components/PrimaryButton.vue";
import JetInput from "@/Components/Input.vue";

import { Inertia } from "@inertiajs/inertia";

const swal = inject('$swal');
const isLoading = ref(false);
const status = ref([]);
const error = ref(null);

defineProps({
    //user: Object,
});

const updateStatus = () => {
  isLoading.value = true;
  setTimeout(() => {
    isLoading.value = false;
    Inertia.post(
      route("dashboard.update.status"),
      {
        status: status.value,
        _method: "put",
      },
      {
        preserveScroll: true,
        onSuccess: doneMessage,
        onError: errorMessage,
      }
    );
  }, 1300, 2300);
};


const doneMessage = () => {
    Toast().fire({
        icon: 'success',
        title: 'Status updated'
    })
    console.log('asd');
    getStatus();
};

const errorMessage = () => {
    Toast().fire({
        icon: 'error',
        title: 'Error'
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

const getStatus = async () => {
    try {
      const response = await axios.get('/admin/dashboard/get-status');
      status.value = response.data.status
    } catch (err) {
      error.value = err.message;
    }
};

onMounted(() => {
      getStatus();
});

</script>

<template>
    <ActionSection>
        <template #title>
            Update status
        </template>

        <template #description>
            Update status.
        </template>

        <template #content>
            <div class="max-w-xl text-sm text-gray-600 dark:text-gray-400">
                Update status.
            </div>

            <div class="mt-5">
                <div class="flex mt-2">
                    <jet-input v-model="status" id="status" class="w-full" placeholder="" type="text" />
                    <PrimaryButton v-if="isLoading === false" type="submit" class="ml-1" @click="updateStatus">
                        <span>Update</span>
                    </PrimaryButton>
                    <jet-primary-button v-if="isLoading === true" :disabled="isLoading === true" type="submit" class="ml-1" @click="updateStatus"><span>Update</span>
                        <svg class="inline ml-2 w-3 h-3 text-gray-200 animate-spin dark:text-gray-600 fill-gray-600 dark:fill-gray-300"
                            viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                fill="currentColor" />
                            <path
                                d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                fill="currentFill" />
                        </svg>
                    </jet-primary-button>
                </div>
            </div>

        </template>
    </ActionSection>
</template>
