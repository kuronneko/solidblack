<template>
    <Head title="Welcome" />

    <div class="mb-3">
        <div v-if="canLogin" class="absolute top-0 right-0 px-6 py-4 sm:block">
            <Link v-if="$page.props.user" :href="route('dashboard')" class="text-md text-gray-700 dark:text-gray-500">
            Dashboard</Link>
        </div>

        <div class="absolute top-0 left-0 px-6 py-4 sm:block text-gray-700 dark:text-gray-500">
            <button id="toggle-dark-mode" @click="toggle">
                <div v-if="this.style == 'dark'">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                    </svg>
                </div>
                <div v-if="this.style == 'light'">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" />
                    </svg>
                </div>
            </button>
        </div>
    </div>

    <div class="pt-12" id="blogs-container">
        <div v-for="blog in blogs" :key="blog.id">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 pb-6">
                <div class="bg-white dark:bg-neutral-900 dark:text-neutral-200 overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-4 sm:px-6 ck-content">
                        <h2>{{ blog.name }}</h2>
                        <!--                         <div v-html="blog.content.slice(0, 2000) + (blog.content.length > 2000 ? '...' : '')"></div> -->
                        <div class="text-center mt-5">
                            <Link :href="route('blog.show.with.slug', [blog.id, blog.slug])" class="">
                            <span
                                class="text-gray-700 hover:text-gray-600 dark:text-indigo-300 text-sm dark:hover:text-indigo-400">Continue
                                reading the
                                article</span>
                            </Link>
                        </div>
                        <p class="text-xs italic text-right mt-10">Published at {{
                            moment(blog.published_at).format('MMMM Do YYYY, h:mm:ss a')
                        }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div v-if="!stop && isLoading" role="status" class="flex justify-center ... mb-10">
        <div role="status">
            <svg aria-hidden="true"
                class="inline w-8 h-8 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-gray-600 dark:fill-gray-300"
                viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                    fill="currentColor" />
                <path
                    d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                    fill="currentFill" />
            </svg>
            <span class="sr-only">Loading...</span>
        </div>
        <span class="sr-only">Loading...</span>
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
        canLogin: Boolean,
        canRegister: Boolean,
        laravelVersion: String,
        phpVersion: String,
    },
    data() {
        return {
            blogs: [],
            moment: moment,
            start: 3,
            stop: false,
            isLoading: false,
            style: localStorage.theme,
        };
    },
    beforeMount() {
        this.getInitialBlogs();
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

        this.getNextBlog();

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
        getInitialBlogs() {
            this.axios.get(`blogs/all?skip=${0}&take=${this.start}`).then((response) => {
                this.blogs = response.data.blogs;
            });
        },
        getNextBlog() {
            window.onscroll = () => {
                this.isLoading = true;
                //const blogsContainer = document.getElementById("blogs-container");
                //let bottomOfblogsContainer = window.innerHeight + window.pageYOffset >= blogsContainer.offsetTop + blogsContainer.offsetHeight;
                let bottomOfWindow = document.documentElement.scrollTop + window.innerHeight === document.documentElement.offsetHeight;
                if (bottomOfWindow) {
                    if (this.stop == false) {
                        setTimeout(() => {
                            axios.get(`blogs/all?skip=${this.start}&take=${1}`).then(response => {
                                //this.blogs = [];
                                this.blogs.push(...response.data.blogs);
                                this.start = this.start + 1;
                                this.isLoading = false;
                                if (response.data.blogs.length == 0) {
                                    this.stop = true;
                                }
                            });
                        }, Math.floor(Math.random() * (800 - 300 + 1) + 300))
                    }
                }
            }
        },
    },
};
</script>

<!-- <script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import Welcome from '@/Components/Welcome.vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import moment from "moment";
import { onMounted } from 'vue';
onMounted(() => {

});
defineProps({
   canLogin: Boolean,
   canRegister: Boolean,
   laravelVersion: String,
   phpVersion: String,
});
</script>
-->
