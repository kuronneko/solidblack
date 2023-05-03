<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { Head, Link } from '@inertiajs/inertia-vue3';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import Banner from '@/Components/Banner.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';

import { onMounted } from 'vue'
import {
    initAccordions,
    initCarousels,
    initCollapses,
    initDials,
    initDismisses,
    initDrawers,
    initDropdowns,
    initModals,
    initPopovers,
    initTabs,
    initTooltips
} from 'flowbite'
onMounted(() => {
    if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark')
        localStorage.theme = "dark";
    } else {
        document.documentElement.classList.remove('dark')
        localStorage.theme = "light";
    }
    initAccordions();
    initCarousels();
    initCollapses();
    initDials();
    initDismisses();
    initDrawers();
    initDropdowns();
    initModals();
    initPopovers();
    initTabs();
    initTooltips();
})
defineProps({
    title: String,
});

const style = ref(localStorage.theme || 'light');

const toggle = () => {
    style.value = style.value === 'dark' ? 'light' : 'dark';
    localStorage.theme = style.value;

    if (style.value === 'dark') {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
};

const showingNavigationDropdown = ref(false);

const switchToTeam = (team) => {
    Inertia.put(route('current-team.update'), {
        team_id: team.id,
    }, {
        preserveState: false,
    });
};

const logout = () => {
    Inertia.post(route('logout'));
};
</script>

<template>
    <Head :title="title" />

    <div class="relative max-w-4xl mx-auto py-2 flex justify-between">
        <div class="absolute top-0 left-0 px-6 py-2 sm:block text-gray-700 dark:text-gray-500 inset-0">
            <div class="relative max-w-4xl mx-auto flex justify-center space-x-1">


                            <button id="toggle-dark-mode" @click="toggle" class="inline-flex items-center px-4 border border-transparent text-sm leading-4 font-medium rounded-md">
                                <div v-if="style === 'dark'">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                                    </svg>
                                </div>
                                <div v-if="style === 'light'">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" />
                                    </svg>
                                </div>
                            </button>


                <NavLink :href="route('welcome')"
                    class="flex items-center p-2 text-base font-normal rounded-lg text-gray-700 dark:text-gray-500 hover:bg-gray-100 dark:hover:bg-neutral-800 dark:hover:text-white">
                    <ApplicationMark
                        class="w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" />
                    <span class="ml-3"></span>
                </NavLink>
                <NavLink :href="route('dashboard')" :active="route().current('dashboard')"
                    class="flex items-center p-2 text-base font-normal rounded-lg text-gray-700 dark:text-gray-500 hover:bg-gray-100 dark:hover:bg-neutral-800 dark:hover:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75" />
                    </svg>
                    <span class="ml-3"></span>
                </NavLink>
                <NavLink :href="route('blog.index')" :active="route().current().startsWith('blog')"
                    class="flex items-center p-2 text-base font-normal rounded-lg text-gray-700 dark:text-gray-500 hover:bg-gray-100 dark:hover:bg-neutral-800 dark:hover:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                    <span class="flex-1 ml-3 whitespace-nowrap"></span>
                </NavLink>

                <div class="flex items-center">
                    <div class="flex items-center">
                        <div>
                            <button aria-expanded="false" data-dropdown-toggle="dropdown-user" type="button"
                                :class="[route().current('profile.show') ? 'bg-gray-100 dark:bg-neutral-800 dark:text-white text-sm font-medium leading-5 text-gray-900' : '', 'inline-flex items-center py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-700 dark:text-gray-500 hover:text-gray-800 dark:hover:text-white focus:outline-none']">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                </svg>
                                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                        <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow  dark:bg-neutral-900 dark:divide-neutral-900"
                            id="dropdown-user">
                            <div class="px-4 py-3" role="none">
                                <p class="text-sm font-medium text-gray-700 dark:text-gray-500 truncate " role="none">
                                    {{ $page.props.user.email }}
                                </p>
                            </div>
                            <ul class="py-1" role="none">
                                <li>
                                    <Link :href="route('profile.show')"
                                        class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-400 hover:bg-gray-100  dark:hover:bg-neutral-700 dark:hover:text-white"
                                        role="menuitem">Profile</Link>
                                </li>
                                <li>
                                    <!-- Authentication -->
                                    <form @submit.prevent="logout">
                                        <DropdownLink as="button">
                                            Log out
                                        </DropdownLink>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="sm:ml-64 md:ml-64 lg:ml-auto">
        <div class="mt-14">
            <!-- Page Heading -->
            <header v-if="$slots.header" class="text-gray-700 dark:text-gray-500">
                <div class="max-w-4xl mx-auto px-6 sm:px-6 lg:px-12">
                    <slot name="header" />
                </div>
            </header>
            <!-- Page Content -->
            <main class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <slot />
            </main>
        </div>
    </div>
</template>
