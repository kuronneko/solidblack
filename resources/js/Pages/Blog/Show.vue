<template>
    <AppLayout title="Blog - Show">
        <template #header>
            <div class="flex">
                <div>
                    <h2 class="font-semibold text-xl leading-tight">
                        Blog preview
                    </h2>
                </div>
                <div class="ml-auto">
                    <Link :href="route('blog.index')">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                    </svg>
                    </Link>
                </div>
            </div>
        </template>

        <div class="py-7">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-neutral-900 dark:text-neutral-200 overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-4 sm:px-6 ck-content">
                        <div class="mb-3">
                            <p class="text-xl font-bold">>> {{ blog.name }}</p>
                            <p class="text-xxs italic text-left text-neutral-600">
                                Published at {{
                                    blog.published_at
                                }} by {{ blog.user.name }}
                            </p>
                            <p v-if="blog.categories && blog.categories.length"
                                class="text-xxs italic text-left text-neutral-600">
                                <span>Categories: </span>
                                <span v-for="(category, index) in blog.categories" :key="category.id">
                                    {{ category.name }}{{ index !== blog.categories.length - 1 ? ', ' : '' }}
                                </span>
                            </p>
                        </div>

                        <div v-html="blog.content"></div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from "@inertiajs/inertia-vue3";
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import { Inertia } from "@inertiajs/inertia";
import useVuelidate from '@vuelidate/core'
import { required, url } from '@vuelidate/validators'
import moment from "moment";
import { Fancybox } from "@fancyapps/ui";
import "@fancyapps/ui/dist/fancybox.css";

export default {
    props: {
        blog: Object,
        categories: Object,
    },
    data() {
        return {
            moment: moment,
        };
    },
    mounted() {
        Fancybox.bind('[data-fancybox="images"]', {
            Toolbar: {
                display: [
                    "close",
                ],
            },
        });
        //encapsule <a data-fancybox='images'> on <img> tag
        const imgs = document.querySelectorAll('img');
        imgs.forEach(img => {
            //replace thumb with a original img url
            const newSrc = img.src.replace('_thumb', '');
            const a = document.createElement('a');
            a.setAttribute('href', newSrc);
            a.setAttribute('data-fancybox', 'images');
            const parent = img.parentNode;
            parent.insertBefore(a, img);
            a.appendChild(img);
        });

        document.querySelectorAll('oembed[url]').forEach(element => {
            // Create the <a href="..." class="embedly-card"></a> element that Embedly uses
            // to discover the media.
            const anchor = document.createElement('a');

            anchor.setAttribute('href', element.getAttribute('url'));
            anchor.className = 'embedly-card';

            element.appendChild(anchor);
        });
    },
    components: {
        AppLayout,
        PrimaryButton,
        TextInput,
        InputLabel,
        Link,
        Fancybox,
    },
    methods: {

    },
};
</script>

