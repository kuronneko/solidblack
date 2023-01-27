<template>
    <AppLayout title="Blog - Create">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Blog Create
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-4 sm:px-6">
                        <form @submit.prevent="submitForm">
                            <div class="mb-2">
                                <InputLabel for="title" value="Title" />
                                <TextInput v-model="form.title" type="text" class="mt-1 block w-md"
                                    :class="v$.form.title.$error === true ? 'border-gray-300 focus:border-red-300 focus:ring focus:ring-red-200 focus:ring-opacity-50 rounded-md shadow-sm' : ''" />
                                <span class="text-red-600 small" v-for="error of v$.form.title.$errors"
                                    :key="error.$uid">
                                    {{ error.$message }}
                                </span>
                            </div>
                            <ckeditor :config="config" :editor="editor" v-model="form.content"
                                :class="v$.form.content.$error === true ? 'border-gray-300 focus:border-red-300 focus:ring focus:ring-red-200 focus:ring-opacity-50 rounded-md shadow-sm' : ''">
                            </ckeditor>
                            <span class="text-red-600 small" v-for="error of v$.form.content.$errors" :key="error.$uid">
                                {{ error.$message }}
                            </span>
                            <PrimaryButton v-if="isLoading === false" type="submit" id="submitBtn"
                                class="w-full rounded-none justify-center">
                                Post
                            </PrimaryButton>
                            <PrimaryButton v-if="isLoading === true" :disabled="isLoading === true" type="submit"
                                id="submitBtn" class="w-full rounded-none justify-center">
                                Posting
                                <svg class="inline ml-2 w-3 h-3 text-gray-200 animate-spin dark:text-gray-600 fill-gray-600 dark:fill-gray-300"
                                    viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                        fill="currentColor" />
                                    <path
                                        d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                        fill="currentFill" />
                                </svg>
                            </PrimaryButton>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import { Inertia } from "@inertiajs/inertia";
import useVuelidate from '@vuelidate/core'
import { required, url } from '@vuelidate/validators'

export default {
    setup() {
        return { v$: useVuelidate() }
    },
    data() {
        return {
            form: {
                title: '',
                content: ''
            },
            isLoading: false,
            isButtonDisabled: true,
            editor: ClassicEditor,
            config: {

            },
        };
    },
    validations() {
        return {
            form: {
                title: { required, $autoDirty: true },
                content: { required, $autoDirty: true },
            }
        }
    },
    components: {
        AppLayout,
        PrimaryButton,
        TextInput,
        InputLabel,
    },
    methods: {
        submitForm() {
            this.isLoading = true;
            document.getElementById("submitBtn").disabled = true;
            setTimeout(() => {
                this.v$.$touch();
                if (!this.v$.$error) {
                    setTimeout(() => {
                        this.Toast().fire({
                            icon: 'success',
                            title: 'Blog created'
                        })
                        this.isLoading = false;
                        Inertia.post(route("blog.store", { 'title': this.form.title, 'content': this.form.content }));
                    }, 1000)
                } else {
                    this.isLoading = false;
                    document.getElementById("submitBtn").disabled = false;
                }
            }, 1000)
        },
        Toast() {
            return this.$swal.mixin({
                toast: true,
                position: 'top',
                showConfirmButton: false,
                timer: 1700,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', this.$swal.stopTimer)
                    toast.addEventListener('mouseleave', this.$swal.resumeTimer)
                }
            })
        },
    },
};
</script>

<style>
.ck-editor__editable {
    min-height: 500px;
}
</style>
