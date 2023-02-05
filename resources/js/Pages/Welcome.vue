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

    </div>

    <div v-for="blog in blogs" :key="blog.id">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-4 sm:px-6 ck-content">
                        <div v-html="blog.content.slice(0, 2000) + (blog.content.length > 2000 ? '...' : '')"></div>
                        <div class="text-center mt-5">
                            <Link :href="route('blog.show.with.slug', blog)" class="">
                            <span class="text-black text-sm hover:text-blue-600">Continue
                                reading the
                                article</span>
                            </Link>
                        </div>
                        <p class="text-xs italic text-right mt-10">Last modified at {{
                            moment(blog.updated_at).format('MMMM Do YYYY, h:mm:ss a')
                        }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

