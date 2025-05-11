<script setup>
import { ref, onMounted } from 'vue';
import { useForm } from '@inertiajs/inertia-vue3';
import { inject } from 'vue';
import ActionSection from '@/Components/ActionSection.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DialogModal from '@/Components/DialogModal.vue';
import InputError from '@/Components/InputError.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import JetPrimaryButton from "@/Components/PrimaryButton.vue";
import JetDangerButton from "@/Components/DangerButton.vue";

const categories = ref([]);
const error = ref(null);
const swal = inject('$swal');
const isLoading = ref(true);
const showModal = ref(false);
const editMode = ref(false);

const form = useForm({
    id: null,
    name: '',
    slug: '',
    status: 1,
});

const getCategories = async () => {
    try {
        const response = await axios.get('/admin/categories');
        categories.value = response.data;
        error.value = null;
    } catch (err) {
        error.value = err.message;
        showToast('Error', 'Failed to load categories', 'error');
    } finally {
        isLoading.value = false;
    }
};

onMounted(() => {
    getCategories();
});

const refreshCategories = () => {
    isLoading.value = true;
    getCategories();
};

// Update the openModal function
const openModal = (category = null) => {
    if (category) {
        editMode.value = true;
        form.id = category.id;
        form.name = category.name;
        form.slug = category.slug;
        form.status = category.status;
    } else {
        editMode.value = false;
        form.reset();
        form.clearErrors();
        // Ensure all fields are cleared
        form.id = null;
        form.name = '';
        form.slug = '';
        form.status = true;
    }
    showModal.value = true;
};

const submitForm = () => {
    if (editMode.value) {
        form.put(route('categories.update', form.id), {
            preserveScroll: true,
            onSuccess: () => {
                showModal.value = false;
                showToast('Success', 'Category updated');
                refreshCategories();
                form.reset();
                form.clearErrors();
            },
            onError: () => {
                showToast('Error', 'Something went wrong', 'error');
            },
            onFinish: () => {
                form.reset();
                isLoading.value = false;
            }
        });
    } else {
        form.post(route('categories.store'), {
            preserveScroll: true,
            onSuccess: () => {
                showModal.value = false;
                showToast('Success', 'Category created');
                refreshCategories();
                form.reset();
                form.clearErrors();
            },
            onError: () => {
                showToast('Error', 'Something went wrong', 'error');
            },
            onFinish: () => {
                form.reset();
                isLoading.value = false;
            }
        });
    }
};

const deleteCategory = (id) => {
    swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        background: '#fff',
        color: '#00000',
        width: 400,
        position: 'center',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#212529',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            form.delete(route('categories.destroy', id), {
                preserveScroll: true,
                onSuccess: () => {
                    swal.fire({
                        position: 'center',
                        color: '#00000',
                        width: 400,
                        background: '#fff',
                        icon: 'success',
                        title: 'Category deleted successfully',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    refreshCategories();
                },
                onError: (errors) => {
                    swal.fire({
                        position: 'center',
                        color: '#00000',
                        width: 400,
                        background: '#fff',
                        icon: 'error',
                        title: errors.error || 'Cannot delete category. It has associated blogs.',
                        showConfirmButton: true,
                        confirmButtonColor: '#212529',
                    });
                }
            });
        }
    });
};

const toggleStatus = (category) => {
    setTimeout(() => {
        form.put(route('categories.toggle.status', category.id), {
            preserveScroll: true,
            onSuccess: () => {
                const Toast = swal.mixin({
                    toast: true,
                    position: 'top',
                    showConfirmButton: false,
                    timer: 1700,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', swal.stopTimer)
                        toast.addEventListener('mouseleave', swal.resumeTimer)
                    }
                });

                Toast.fire({
                    icon: 'success',
                    title: category.status ? 'Category inactive' : 'Category active'
                });
                refreshCategories();
            }
        });
    }, 500);
};

const showToast = (title, message, icon = 'success') => {
    const Toast = swal.mixin({
        toast: true,
        position: 'top',
        showConfirmButton: false,
        timer: 1700,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', swal.stopTimer)
            toast.addEventListener('mouseleave', swal.resumeTimer)
        }
    });

    Toast.fire({
        icon,
        title: message
    });
};
</script>

<template>
    <ActionSection>
        <template #title>
            Categories Management
        </template>

        <template #description>
            Manage your categories here. You can create, edit, delete, and toggle the status of categories.
        </template>

        <template #content>
            <div class="space-y-6">
                <div class="flex justify-end">
                    <PrimaryButton @click="openModal()">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                    </PrimaryButton>
                </div>

                <!-- Categories Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-800 dark:bg-neutral-800">
                            <tr class="text-gray-200 dark:text-gray-200 text-left">
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-semibold uppercase tracking-wider border-b border-gray-700">
                                    Name
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-semibold uppercase tracking-wider border-b border-gray-700">
                                    Slug
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-semibold uppercase tracking-wider border-b border-gray-700">
                                    Status
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-semibold uppercase tracking-wider border-b border-gray-700">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y  divide-gray-200 dark:divide-gray-700 dark:text-gray-200">
                            <template v-if="isLoading">
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center">
                                        <div class="flex justify-center">
                                            <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-gray-900">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                            <template v-else-if="error">
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-red-600">
                                        {{ error }}
                                    </td>
                                </tr>
                            </template>
                            <template v-else-if="categories.length === 0">
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                        No categories found
                                    </td>
                                </tr>
                            </template>
                            <template v-else>
                                <tr v-for="category in categories" :key="category.id">
                                    <td class="px-6 py-4 whitespace-nowrap">{{ category.name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ category.slug }}</td>
<!-- Replace the existing toggle switch section with this -->
<td class="px-6 py-4">
    <div preserve-scroll v-if="!category.status" @click.once="toggleStatus(category)"
        class="inline-flex relative items-center cursor-pointer">
        <input type="checkbox" class="sr-only peer">
        <div class="w-11 h-6 bg-gray-600 peer-focus:outline-none peer-focus:ring-4
            peer-focus:ring-gray-300 dark:peer-focus:ring-neutral-800
            rounded-full peer dark:bg-neutral-800 peer-checked:after:translate-x-full
            peer-checked:after:border-white after:content-[''] after:absolute
            after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300
            dark:after:bg-neutral-700 dark:after:border-neutral-700 after:border
            after:rounded-full after:h-5 after:w-5 after:transition-all
            dark:border-neutral-600 peer-checked:bg-gray-200">
        </div>
    </div>
    <div preserve-scroll v-else @click.once="toggleStatus(category)"
        class="inline-flex relative items-center cursor-pointer">
        <input type="checkbox" class="sr-only peer" checked>
        <div class="w-11 h-6 bg-gray-200 rounded-full peer
            peer-focus:ring-4 peer-focus:ring-gray-300
            dark:peer-focus:ring-neutral-800 dark:bg-neutral-800
            peer-checked:after:translate-x-full peer-checked:after:border-white
            after:content-[''] after:absolute after:top-0.5 after:left-[2px]
            after:bg-white after:border-gray-300 after:border after:rounded-full
            after:h-5 after:w-5 after:transition-all dark:border-neutral-600
            peer-checked:bg-gray-600">
        </div>
    </div>
</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <JetPrimaryButton @click="openModal(category)" class="ml-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                            </svg>
                                        </JetPrimaryButton>
                                        <JetDangerButton @click="deleteCategory(category.id)" class="ml-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                            </svg>
                                        </JetDangerButton>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Replace the existing DialogModal section with this: -->
            <DialogModal :show="showModal" @close="showModal = false">
                <template #title>
                    {{ editMode ? 'Edit Category' : 'Create Category' }}
                </template>

                <template #content>
                    <div class="grid gap-4">
                        <!-- Name Field -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Name
                            </label>
                            <TextInput id="name" v-model="form.name" type="text" class="mt-1 block w-full"
                                placeholder="Category name" required />
                            <InputError :message="form.errors.name" class="mt-2" />
                        </div>

                        <!-- Slug Field -->
                        <div>
                            <label for="slug" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Slug
                            </label>
                            <TextInput id="slug" v-model="form.slug" type="text" class="mt-1 block w-full"
                                placeholder="category-slug" />
                            <InputError :message="form.errors.slug" class="mt-2" />
                        </div>


                    </div>
                </template>

                <template #footer>
                    <SecondaryButton @click="showModal = false">
                        Cancel
                    </SecondaryButton>

                    <PrimaryButton class="ml-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                        @click="submitForm">
                        {{ editMode ? 'Update' : 'Create' }}
                    </PrimaryButton>
                </template>
            </DialogModal>

        </template>
    </ActionSection>
</template>
