<template>
    <Head title="Blog" />
    <div class="mb-3">
        <div class="absolute top-0 right-0 px-6 py-4 sm:block">
    <Link :href="route('welcome')">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
        class="w-6 h-6 text-gray-700 dark:text-gray-500">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
    </svg>
    </Link>
</div>
<div class="absolute top-0 left-0 px-6 py-4 sm:block text-gray-700 dark:text-gray-500">
    <button id="toggle-dark-mode" @click="toggle">
        <div v-if="this.style == 'dark'">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6 text-gray-700 dark:text-gray-500">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
            </svg>
        </div>
        <div v-if="this.style == 'light'">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6 text-gray-700 dark:text-gray-500">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" />
            </svg>
        </div>
    </button>
</div>
    </div>
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-neutral-900 dark:text-neutral-200 overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-4 sm:px-6 ck-content">
                <h2>{{ blog.name }}</h2>
                <div v-html="blog.content"></div>
                <p class="text-xs italic text-right mt-10">Published at {{
                    moment(blog.published_at).format('MMMM Do YYYY, h:mm:ss a')
                }}</p>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';
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
},
data() {
    return {
        moment: moment,
        style: localStorage.theme,
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
    PrimaryButton,
    TextInput,
    InputLabel,
    Link,
    Fancybox,
    Head,
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
