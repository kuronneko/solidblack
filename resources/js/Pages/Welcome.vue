<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import Welcome from '@/Components/Welcome.vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import moment from "moment";
import { onMounted } from 'vue';
onMounted(() => {
    document.querySelectorAll('oembed[url]').forEach(element => {
        // Create the <a href="..." class="embedly-card"></a> element that Embedly uses
        // to discover the media.
        const anchor = document.createElement('a');

        anchor.setAttribute('href', element.getAttribute('url'));
        anchor.className = 'embedly-card';

        element.appendChild(anchor);
    });
});
defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
    blogs: Array
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

    <div v-for="blog in blogs" :key="blog.id">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-4 sm:px-6 ck-content">
                        <div v-html="blog.content"></div>
                        <p class="text-xs text-right mt-10">{{
                            moment(blog.created_at).format('MMMM Do YYYY, h:mm:ss a')
                        }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

