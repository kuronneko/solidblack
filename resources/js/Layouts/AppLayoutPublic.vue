<script>
import { Head, Link } from '@inertiajs/inertia-vue3';
import { Inertia } from "@inertiajs/inertia";

export default {
    props: {
        blog: Object,
        setting: Object,
        section: String,
        canLogin: String
    },
    data() {
        return {
            style: localStorage.theme,
            currentYear: null
        };
    },
    mounted() {
        this.getCurrentYear();
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
            localStorage.theme = "dark";
            this.style = localStorage.theme
        } else {
            document.documentElement.classList.remove('dark')
            localStorage.theme = "light";
            this.style = localStorage.theme
        }
    },
    components: {
        Link,
        Head,
    },
    methods: {
        getCurrentYear() {
            const date = new Date();
            this.currentYear = date.getFullYear();
        },
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


<template>
    <div v-if="section === 'welcome'" class="relative max-w-4xl mx-auto py-2">
        <div v-if="canLogin" class="absolute top-0 right-0 px-6 py-4 sm:block">
            <Link v-if="$page.props.user" :href="route('dashboard')" class="text-md text-gray-700 dark:text-gray-500">
            Dashboard
            </Link>
        </div>

        <div class="absolute top-0 left-0 px-6 py-4 sm:block text-gray-700 dark:text-gray-500 inset-0">
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
    <div v-if="section === 'blog'" class="relative max-w-4xl mx-auto py-2">
        <div class="absolute top-0 right-0 px-6 py-4 sm:block">
            <Link :href="route('welcome')">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6 text-gray-700 dark:text-gray-500">
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

    <main>
        <slot />
    </main>

    <footer class="text-neutral-600 pb-4">
    <div class="container mx-auto">
        <div class="flex justify-center items-center flex-col">
            <p class="text-xs">2023-{{ currentYear }}</p>
            <p class="text-xs text-secondary mt-2">This website is powered by <a class="text-secondary" href="https://cyberpunkwaifus.xyz" target="_blank">CBPW Technologies.</a></p>
        </div>
    </div>
</footer>
</template>
