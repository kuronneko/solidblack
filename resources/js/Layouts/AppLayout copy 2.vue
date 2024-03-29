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
    <nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 dark:bg-neutral-900 dark:border-neutral-700">
        <div class="px-3 py-3 lg:px-5 lg:pl-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-start">
                    <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar"
                        aria-controls="logo-sidebar" type="button"
                        class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-neutral-800 dark:focus:ring-gray-600">
                        <span class="sr-only">Open sidebar</span>
                        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path clip-rule="evenodd" fill-rule="evenodd"
                                d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                            </path>
                        </svg>
                    </button>

                    <div class="shrink-0 flex items-center">
                        <div class="hidden md:block">
                            <Link :href="route('welcome')" class="flex ml-2 md:mr-24">
                            <ApplicationMark class="block h-9 w-auto text-gray-700 dark:text-gray-500" />
                            <span
                                class="self-center text-lg font-semibold sm:text-2x2 whitespace-nowrap text-gray-700 dark:text-gray-500 ml-2">
                                SolidBlack Demo
                            </span>
                            </Link>
                        </div>
                    </div>

                </div>
                <div class="flex items-center">
                    <div class="flex items-center ml-3">
                        <div>
                            <button aria-expanded="false" data-dropdown-toggle="dropdown-user" type="button"
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md
                                text-gray-700 dark:text-gray-500 bg-white  dark:bg-neutral-900 hover:text-gray-500 dark:hover:text-white focus:outline-none">
                                {{ $page.props.user.name }}

                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                        <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow  dark:bg-neutral-800 dark:divide-neutral-900"
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
    </nav>

    <aside id="logo-sidebar"
        class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-neutral-900 dark:border-neutral-700"
        aria-label="Sidebar">
        <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-neutral-900">
            <ul class="space-y-2">
                <li class="lg:hidden md:hidden">
                    <NavLink :href="route('welcome')"
                        class="flex items-center p-2 text-base font-normal rounded-lg text-gray-700 dark:text-gray-500 hover:bg-gray-100 dark:hover:bg-neutral-800 dark:hover:text-white">
                        <ApplicationMark class="w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" />
                    <span class="ml-3">Welcome</span>
                    </NavLink>
                </li>
                <li>
                    <NavLink  :href="route('dashboard')" :active="route().current('dashboard')"
                        class="flex items-center p-2 text-base font-normal rounded-lg text-gray-700 dark:text-gray-500 hover:bg-gray-100 dark:hover:bg-neutral-800 dark:hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75" />
                        </svg>
                    <span class="ml-3">Dashboard</span>
                    </NavLink >
                </li>
                <li>
                    <NavLink  :href="route('blog.index')" :active="route().current().startsWith('blog')"
                        class="flex items-center p-2 text-base font-normal rounded-lg text-gray-700 dark:text-gray-500 hover:bg-gray-100 dark:hover:bg-neutral-800 dark:hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                        </svg>
                    <span class="flex-1 ml-3 whitespace-nowrap">Blog</span>
                    </NavLink >
                </li>
            </ul>
        </div>
    </aside>

    <div class="sm:ml-64 md:ml-64 lg:ml-auto">
        <div class="mt-14">
            <!-- Page Heading -->
            <header v-if="$slots.header"
                class="bg-white dark:bg-neutral-900 text-gray-700 dark:text-gray-500 border-b border-gray-200 dark:border-neutral-700 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot />
            </main>
        </div>
    </div>

</template>
