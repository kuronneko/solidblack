<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps({
    href: String,
    active: Boolean,
});

const classes = computed(() => {
    return props.active
        ? 'bg-gray-100 dark:bg-neutral-800 dark:text-white text-sm font-medium leading-5 text-gray-900'
        : 'text-sm font-medium leading-5 text-gray-500';
});
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
