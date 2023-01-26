<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import Welcome from '@/Components/Welcome.vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import moment from "moment";
defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});
</script>

<template>
    <Head title="Welcome" />
    <div v-if="canLogin" class="absolute top-0 right-0 px-6 py-4 sm:block">
        <Link v-if="$page.props.user" :href="route('dashboard')" class="text-md text-gray-700 dark:text-gray-500">
        Dashboard</Link>

        <template v-else>
            <Link :href="route('login')" class="text-md text-gray-700 dark:text-gray-500">Log in
            </Link>

            <Link v-if="canRegister" :href="route('register')" class="ml-4 text-md text-gray-700 dark:text-gray-500">
            Register</Link>
        </template>
    </div>
    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 sm:px-20">
                <div>
                    <ApplicationLogo class="block h-12 w-auto" />
                </div>
                <div class="mt-8 text-2xl">
                    Welcome to Solid Black Blog System
                </div>
            </div>
        </div>
    </div>
</template>
