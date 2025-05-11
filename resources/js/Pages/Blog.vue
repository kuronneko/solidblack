<template>

    <Head>
        <title>{{ blog.name }}</title>
    </Head>

    <AppLayoutPublic :section="section">
        <div class="flex items-center justify-center">
            <div class="mt-10 rounded-lg dark:text-white" id="logo-container">
                {{ setting.status }}
            </div>
        </div>
        <!--         <div class="flex items-center justify-center">
            <div class="px-5 py-5" id="logo-container">
                <img :src="randomImage" alt="" class="w-32 h-auto">
            </div>
        </div> -->

        <div class="pt-3 mb-6">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="border-gray-300 dark:border-neutral-700 dark:text-neutral-200 overflow-hidden sm:border-gray-300 sm:dark:border-neutral-700 sm:rounded-sm sm:border-t-0 sm:border-b-1 sm:border-l-0 sm:border-r-0 sm:border rounded-sm border-t-0 border-b-1 border-l-0 border-r-0 border">
                    <div class="p-4 pt-2 sm:px-6 ck-content">
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
    </AppLayoutPublic>

</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import AppLayoutPublic from '@/Layouts/AppLayoutPublic.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
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
        setting: Object,
    },
    data() {
        return {
            images: [
                '/img/banner (1).png',
                '/img/banner (2).png',
                '/img/banner (3).png',
                '/img/banner (4).png',
                '/img/banner (5).png',
                '/img/banner (6).png',
                '/img/banner (7).png',
                '/img/banner (8).png',
                '/img/banner (9).png',
                '/img/banner (10).png',
                '/img/banner (11).png',
                '/img/banner (12).png',
                '/img/banner (13).png',
                '/img/banner (14).png',
                '/img/banner (15).png',
                '/img/banner (16).png',
                '/img/banner (17).png',
                '/img/banner (18).png',
                '/img/banner (19).png',
            ],
            moment: moment,
            style: localStorage.theme,
            section: 'blog'
        };
    },
    mounted() {
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
            localStorage.theme = "dark";
            this.style = localStorage.theme
        } else {
            document.documentElement.classList.remove('dark')
            localStorage.theme = "light";
            this.style = localStorage.theme
        }
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
        AppLayoutPublic,
        PrimaryButton,
        TextInput,
        InputLabel,
        Link,
        Fancybox,
        Head,
    },
    computed: {
        /*         randomImage() {
                    const index = Math.floor(Math.random() * this.images.length)
                    return this.images[index]
                } */
    },
    methods: {
        toggle() {
            if (localStorage.theme === "dark") {
                localStorage.theme = "light";
                this.style = localStorage.theme
                document.documentElement.classList.remove("dark");
            } else {
                localStorage.theme = "dark";
                this.style = localStorage.theme
                document.documentElement.classList.add("dark");
            }
        },
    },
};
</script>
