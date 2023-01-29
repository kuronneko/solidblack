<template>
    <AppLayout title="Blog - Show">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Blog Show
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-4 sm:px-6">
                        <div>{{ moment(blog.created_at).format('MMMM Do YYYY, h:mm:ss a') }}</div>
                        <div>{{ blog.title }}</div>
                        <div v-html="blog.content"></div>
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
import moment from "moment";

export default {
    props: {
        blog: Object,
    },
    data() {
        return {
            moment: moment,
        };
    },
    components: {
        AppLayout,
        PrimaryButton,
        TextInput,
        InputLabel,
    },
    methods: {

    },
};
</script>

