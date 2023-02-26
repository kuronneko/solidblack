<template>
    <nav v-if="paginator !== undefined" class="flex items-center justify-between" role="navigation">
        <div class="flex justify-between flex-1 sm:hidden">
            <span v-if="onFirstPage" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-neutral-500 bg-neutral-100 border border-neutral-300 cursor-default leading-5 rounded-md
        dark:bg-neutral-800 dark:text-neutral-100">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path clip-rule="evenodd"
                        d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                        fill-rule="evenodd" />
                </svg>
            </span>

            <Link v-else :href="previousPageUrl"
                class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-neutral-700 bg-white border border-neutral-300 leading-5 rounded-md hover:text-neutral-500 focus:outline-none focus:ring ring-neutral-300 focus:border-neutral-300 active:bg-neutral-100 active:text-neutral-700
        dark:bg-neutral-800 dark:text-neutral-100 dark:border-neutral-600 dark:hover:text-neutral-500 dark:focus:ring-neutral-600 dark:focus:border-neutral-600 dark:active:bg-neutral-700 dark:active:text-neutral-300">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path clip-rule="evenodd"
                    d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                    fill-rule="evenodd" />
            </svg>
            </Link>


            <Link v-if="hasMorePages" :href="nextPageUrl"
                class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-neutral-700 bg-white border border-neutral-300 leading-5 rounded-md hover:text-neutral-500 focus:outline-none focus:ring ring-neutral-300 focus:border-neutral-300 active:bg-neutral-100 active:text-neutral-700
        dark:bg-neutral-800 dark:text-neutral-100 dark:border-neutral-600 dark:hover:text-neutral-500 dark:focus:ring-neutral-600 dark:focus:border-neutral-600 dark:active:bg-neutral-700 dark:active:text-neutral-300">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path clip-rule="evenodd"
                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                    fill-rule="evenodd" />
            </svg>
            </Link>

            <span v-else
                class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-neutral-500 bg-neutral-100 border border-neutral-300 cursor-default leading-5 rounded-md dark:bg-neutral-700">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path clip-rule="evenodd"
                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                        fill-rule="evenodd" />
                </svg>
            </span>

        </div>

        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-neutral-700 dark:text-neutral-400 leading-5">
                    Showing
                    <span class="font-medium" v-text="firstItem"></span>
                    to
                    <span class="font-medium" v-text="lastItem"></span>
                    of
                    <span class="font-medium" v-text="total"></span>
                    results
                </p>
            </div>

            <div>
                <span class="relative z-0 inline-flex shadow-sm rounded-md">
                    <span v-if="onFirstPage" aria-disabled="true" aria-hidden="true" class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-neutral-500 bg-neutral-100 border border-neutral-300 cursor-default rounded-l-md leading-5
                 dark:text-neutral-400 dark:bg-neutral-700 dark:border-neutral-600">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path clip-rule="evenodd"
                                d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                fill-rule="evenodd" />
                        </svg>
                    </span>

                    <Link v-else :href="previousPageUrl"
                        class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-neutral-500 dark:text-neutral-400 bg-white dark:bg-neutral-800 border border-neutral-300 dark:border-neutral-700 rounded-l-md leading-5 hover:text-neutral-400 focus:z-10 focus:outline-none focus:ring ring-neutral-300 dark:ring-neutral-600 focus:border-neutral-300 dark:focus:border-neutral-600 active:bg-neutral-100 dark:active:bg-neutral-700 active:text-neutral-500"
                        rel="prev">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path clip-rule="evenodd"
                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                            fill-rule="evenodd" />
                    </svg>
                    </Link>

                    <div v-for="link, index in paginator.links" :key="index">
                        <Link v-if="!isFirstOrLastOrDots(index, paginator.links.length, link.label)"
                            :class="{ 'bg-neutral-200 dark:bg-neutral-900': link.active === true }" :href="link.url"
                            class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-neutral-700 dark:text-neutral-300 bg-white dark:bg-neutral-800 border border-neutral-300 dark:border-neutral-700 leading-5 hover:text-neutral-500 dark:hover:text-neutral-300 focus:z-10 focus:outline-none focus:ring ring-neutral-300 dark:ring-neutral-600 focus:border-neutral-300 active:bg-neutral-100 dark:active:bg-neutral-700 active:text-neutral-700 dark:active:text-neutral-300">
                        {{ link.label }}
                        </Link>

                        <span v-else-if="link.label === '...'" aria-disabled="true"
                            class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-neutral-700 bg-white border border-neutral-300 cursor-default leading-5 dark:text-white dark:bg-neutral-800">
                            {{ link.label }}
                        </span>

                    </div>
                    <Link v-if="hasMorePages" :href="nextPageUrl"
                        class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-neutral-500 dark:text-neutral-400 bg-white dark:bg-neutral-800 border border-neutral-300 dark:border-neutral-700 rounded-l-md leading-5 hover:text-neutral-400 focus:z-10 focus:outline-none focus:ring ring-neutral-300 dark:ring-neutral-600 focus:border-neutral-300 dark:focus:border-neutral-600 active:bg-neutral-100 dark:active:bg-neutral-700 active:text-neutral-500">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path clip-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            fill-rule="evenodd" />
                    </svg>
                    </Link>

                    <span v-else aria-disabled="true" aria-hidden="true"
                        class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-neutral-500 bg-neutral-100 dark:bg-neutral-700 border border-neutral-300 dark:border-neutral-600 cursor-default rounded-r-md leading-5">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path clip-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                fill-rule="evenodd" />
                        </svg>
                    </span>

                </span>
            </div>
        </div>
    </nav>
</template>

<script>
import TermsOfService from "@/Pages/TermsOfService.vue";
import { Link } from '@inertiajs/inertia-vue3'
export default {
    name: "Paginator",
    components: { TermsOfService, Link },
    props: {
        paginator: {
            current_page: Number,
            data: Array,
            first_page_url: String,
            from: Number,
            last_page: Number,
            last_page_url: String,
            links: Array,
            next_page_url: String,
            path: String,
            per_page: Number,
            prev_page_url: String,
            to: Number,
            total: Number,
        }
    },
    methods: {
        isFirstOrLastOrDots(index, links_length, label) {
            return index === 0 || index === links_length - 1 || label.includes('...')
        },
    },
    computed: {
        onFirstPage() {
            return this.paginator.current_page === 1;
        },
        hasMorePages() {
            return this.paginator.current_page < this.paginator.last_page;
        },
        nextPageUrl() {
            return this.paginator.next_page_url;
        },
        previousPageUrl() {
            return this.paginator.prev_page_url;
        },
        firstItem() {
            return this.paginator.from;
        },
        lastItem() {
            return this.paginator.to;
        },
        total() {
            return this.paginator.total;
        },
    }
}
</script>
