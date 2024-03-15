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
        <div class="flex items-center justify-center">
            <div class="px-5 py-5" id="logo-container">
                <img :src="randomImage" alt="" class="w-32 h-auto">
            </div>
        </div>

        <div class="pt-3 mb-6">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-neutral-900 dark:text-neutral-200 overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-4 sm:px-6 ck-content">
                        <Link>
                        <h3 class=" hover:text-blue-800 dark:hover:text-red-600">{{ blog.name }}</h3>
                        </Link>
                        <div v-html="blog.content"></div>
                        <p
                            class="text-xs italic text-right mt-10 text-neutral-600 hover:text-blue-800 dark:hover:text-red-600">
                            Published at {{
            moment(blog.published_at).format('MMMM Do YYYY, h:mm:ss a')
                            }}</p>
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
        randomImage() {
            const index = Math.floor(Math.random() * this.images.length)
            return this.images[index]
        }
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
