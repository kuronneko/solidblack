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
            <div class="relative max-w-4xl mx-auto flex justify-center space-x-4">
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
            <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <slot />
            </main>
        </div>
    </div>
</template>
