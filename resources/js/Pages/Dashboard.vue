<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import ClearBlogs from '@/Pages/Dashboard/ClearBlogs.vue';
import UploadLogo from '@/Pages/Dashboard/UploadLogo.vue';
import SectionBorder from '@/Components/SectionBorder.vue';
import StatusUpdate from './Dashboard/StatusUpdate.vue';
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <ClearBlogs></ClearBlogs>

                    <SectionBorder />

                    <UploadLogo class="mt-10 sm:mt-0"></UploadLogo>

                    <SectionBorder />

                    <StatusUpdate class="mt-10 sm:mt-0"></StatusUpdate>
            </div>
        </div>
    </AppLayout>
</template>
