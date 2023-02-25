<template>
    <AppLayout title="Blog">
        <template #header>
            <div class="flex">
                <div>
                    <h2 class="font-semibold text-xl leading-tight">
                        Blog
                    </h2>
                </div>
                <div class="ml-auto">
                    <Link :href="route('blog.create')">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    </Link>
                </div>
            </div>
        </template>

        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-zinc-900 overflow-hidden shadow-sm sm:rounded-md">
                <div class="p-4 sm:px-6">

                    <form method="get" class="flex mt-2" @submit.prevent="searchBlog">

                        <jet-input v-model="form.search" id="search" class="w-full" @keydown.delete="clearKeyDown()"
                            placeholder="Search by name" type="text" />
                        <jet-primary-button type="submit" class="ml-1">Search
                        </jet-primary-button>
                        <jet-primary-button v-if="$page.props.search" @click="clear()" class="ml-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                            </svg>
                        </jet-primary-button>
                    </form>

                    <div class="py-3">
                        <div class='overflow-x-auto w-full'>
                            <table
                                class='mx-auto max-w-7x1 w-full whitespace-nowrap rounded-lg bg-white dark:bg-zinc-900 divide-y divide-gray-300 dark:divide-zinc-900 overflow-hidden'>
                                <thead class="bg-gray-800 dark:bg-gray-800">
                                    <tr class="text-gray-200 dark:text-gray-200 text-left">
                                        <th class="font-semibold text-sm uppercase px-6 py-4"> ID </th>
                                        <th class="font-semibold text-sm uppercase px-6 py-4"> Name </th>
                                        <th class="font-semibold text-sm uppercase px-6 py-4"> Date/Time </th>
                                        <th class="font-semibold text-sm uppercase px-6 py-4"> Status </th>
                                        <th class="font-semibold text-sm uppercase px-6 py-4"> Options</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700 dark:text-gray-200">
                                    <tr v-for="blog in blogs.data" :key="blog.id">
                                        <td class="px-6 py-4">
                                            <p class=""> {{ blog.id }} </p>
                                        </td>
                                        <td class="px-6 py-4">
                                            <p class=""> {{ blog.name }} </p>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center space-x-3">
                                                <div>
                                                    <p> {{ moment(blog.updated_at).format('MMMM Do YYYY, h:mm:ss a') }}
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">

                                                <div preserve-scroll v-if="blog.status === 1"
                                                    @click.once="toggleStatus(blog)" for="default-toggle"
                                                    class="inline-flex relative items-center cursor-pointer">
                                                    <input type="checkbox" value="" id="default-toggle"
                                                        class="sr-only peer">
                                                    <div
                                                        class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-gray-300 dark:peer-focus:ring-gray-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-gray-600">
                                                    </div>
                                                </div>
                                                <div preserve-scroll v-else
                                                    @click.once="toggleStatus(blog)" for="checked-toggle"
                                                    class="inline-flex relative items-center cursor-pointer">
                                                    <input type="checkbox" value="" id="checked-toggle"
                                                        class="sr-only peer" checked>
                                                    <div
                                                        class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-gray-300 dark:peer-focus:ring-gray-800 dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-gray-600">
                                                    </div>
                                                </div>

                                        </td>
                                        <td class="px-6 py-4">
                                            <!--                                             <jet-primary-button>
                                                <Link :href="
                                                    route('logger.show', {
                                                        logger: logger,
                                                    })
                                                ">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                </Link>
                                            </jet-primary-button> -->
                                            <!--                                             <Link method="DELETE" :href="
                                                route('logger.destroy', {
                                                    logger: logger,
                                                })
                                            "><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                            </svg>
                                            </Link> -->
                                            <jet-primary-button @click="showBlog(blog)" class="ml-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m5.231 13.481L15 17.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v16.5c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9zm3.75 11.625a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                                </svg>
                                            </jet-primary-button>
                                            <jet-primary-button @click="editBlog(blog)" class="ml-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                </svg>
                                            </jet-primary-button>
                                            <jet-danger-button @click="deleteBlog(blog)" class="ml-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                </svg>
                                            </jet-danger-button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <paginator class="mt-3" :paginator="blogs" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import { Inertia } from "@inertiajs/inertia";

import AppLayout from "@/Layouts/AppLayout.vue";

//import JetDialogModal from "@/Components/DialogModal";
import JetPrimaryButton from "@/Components/PrimaryButton.vue";
import JetDangerButton from "@/Components/DangerButton.vue";
import JetInput from "@/Components/Input.vue";
import { Link } from "@inertiajs/inertia-vue3";
import Paginator from "@/Components/Paginator.vue";
import moment from "moment";

export default {
    props: {
        blogs: Object,
        //blog: Object,
        search: String,
    },
    data() {
        return {
            form: {
                search: this.search,
            },
            moment: moment,
        };
    },
    components: {
        AppLayout,
        //JetDialogModal,
        JetPrimaryButton,
        JetDangerButton,
        //JetButton,
        JetInput,
        Paginator,
        Link,
    },
    methods: {
        showBlog: function (blog) {
            Inertia.get(route("blog.show", blog));
        },
        editBlog: function (blog) {
            Inertia.get(route("blog.edit", blog));
        },
        deleteBlog: function (blog) {
            this.$swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                background: '#fff',
                color: '#00000',
                width: 400,
                position: 'center',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#212529',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    Inertia.delete(route("blog.destroy", blog));
                    this.$swal({
                        position: 'center',
                        color: '#00000',
                        width: 400,
                        background: '#fff',
                        icon: 'success',
                        title: 'Blog deleted successfully',
                        showConfirmButton: false,
                        timer: 1500
                    }
                    )
                }
            })
        },
        searchBlog: function () {
            if (this.form.search !== '') {
                Inertia.get(route("blog.index", this.form));
            }
        },
        clearKeyDown: function () {
            if (this.form.search == '') {
                Inertia.get(route("blog.index"));
            }
        },
        clear: function () {
            this.form.search = '';
            Inertia.get(route("blog.index"));
        },
        toggleStatus: function (blog) {
            setTimeout(() => {
                Inertia.post(route("blog.toggle.status", blog),
                    {
                        _method: 'put',
                    });
                if (blog.status == 1) {
                    //message is inverse because "blog that come here is the same previious edit"
                    this.Toast().fire({
                        icon: 'success',
                        title: 'Blog active'
                    })
                } else {
                    this.Toast().fire({
                        icon: 'success',
                        title: 'Blog inactive'
                    })
                }
            }, 500)
        },
        Toast() {
            return this.$swal.mixin({
                toast: true,
                position: 'top',
                showConfirmButton: false,
                timer: 1700,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', this.$swal.stopTimer)
                    toast.addEventListener('mouseleave', this.$swal.resumeTimer)
                }
            })
        },
    },
};
</script>
