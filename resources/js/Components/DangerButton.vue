<script setup>
defineProps({
    type: {
        type: String,
        default: 'button',
    },
});
</script>

<template>
    <button :type="type" class="inline-flex items-center justify-center px-4 py-2 focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-smdark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
        <slot />
    </button>
</template>
