<template>

    <Head :title="setting.status" />

    <AppLayoutPublic :section="section" :canLogin="canLogin">
        <div class="flex items-center justify-center">
            <div class="mt-10 rounded-lg dark:text-white" id="logo-container">
                {{ setting.status }}
            </div>
        </div>
        <!--          <div class="flex items-center justify-center">
            <div class="px-5 py-5" id="logo-container">
                <img :src="randomImage" alt="" class="w-32 h-auto">
            </div>
        </div> -->

        <div class="pt-3 mb-6" id="blogs-container">
            <div v-for="blog in blogs" :key="blog.id">
                <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 pb-2">
                    <div
                        class="border-gray-300 dark:border-neutral-700 dark:text-neutral-200 overflow-hidden sm:border-gray-300 sm:dark:border-neutral-700 sm:rounded-sm sm:border-t-0 sm:border-b-1 sm:border-l-0 sm:border-r-0 sm:border rounded-sm border-t-0 border-b-1 border-l-0 border-r-0 border">
                        <div class="p-4 pt-2 sm:px-6 ck-content">
                            <Link :href="route('blog.show.with.slug', [blog.slug])">
                            <div class="mb-3">
                                <p class="hover:text-red-500 dark:hover:text-red-400 text-xl font-bold">>> {{ blog.name
                                    }}</p>
                                <p class="text-xxs italic text-left text-neutral-600 ">
                                    Published at {{
                                        blog.published_at
                                    }} by {{ blog.user.name }}
                                </p>
                            </div>
                            </Link>
                            <div v-html="blog.content.slice(0, 300) + (blog.content.length > 300 ? '...' : '')"></div>
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
        canLogin: Boolean,
        canRegister: Boolean,
        laravelVersion: String,
        phpVersion: String,
        setting: Object,
        localCategory: {
            type: String,
            required: false,
            default: null
        },
    },
    data() {
        return {
            localCategory: null, // Add this line
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
            blogs: [],
            moment: moment,
            start: 6,
            take: 6,
            stop: false,
            isLoading: false,
            style: localStorage.theme,
            section: 'welcome'
        };
    },
    beforeMount() {
        // Get category from route parameters
        this.localCategory = this.$page.url.split('/').filter(Boolean)[0];

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
        AppLayoutPublic,
        PrimaryButton,
        TextInput,
        InputLabel,
        Link,
        Fancybox,
        Head,
    },
    computed: {
        /*          randomImage() {
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
        getInitialBlogs() {
            // Build URL with template literal
            const url = `/blog/search/all?skip=${0}&take=${this.take}${this.localCategory ? `&category=${this.localCategory}` : ''}`;

            this.axios.get(url).then((response) => {
                this.blogs = response.data.blogs;
            }).catch(error => {
                console.error('Error fetching blogs:', error);
            });
        },
        getNextBlog() {
            window.onscroll = () => {
                const blogsContainer = document.getElementById("blogs-container");
                let bottomOfblogsContainer = window.innerHeight + window.pageYOffset >= blogsContainer.offsetTop + blogsContainer.offsetHeight;

                if (bottomOfblogsContainer && !this.stop && !this.isLoading) {
                    this.isLoading = true;
                    setTimeout(() => {
                        // Build URL with template literal
                        const url = `/blog/search/all?skip=${this.start}&take=${this.take}${this.localCategory ? `&category=${this.localCategory}` : ''}`;

                        axios.get(url).then(response => {
                            this.blogs.push(...response.data.blogs);
                            this.start = this.start + this.take;
                            if (response.data.blogs.length === 0) {
                                this.stop = true;
                            }
                            this.isLoading = false;
                        });
                    }, Math.floor(Math.random() * (800 - 300 + 1) + 300))
                }
            }
        }
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
