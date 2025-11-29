<script setup lang="ts">
import Sidebar from '@/Components/Sidebar.vue';
import RightSidebar from '@/Components/RightSidebar.vue';
import { Head } from '@inertiajs/vue3';

defineProps<{
    title?: string;
}>();
</script>

<template>
    <Head :title="title" />

    <div class="flex min-h-screen bg-white dark:bg-black text-black dark:text-white">
        <!-- Left Sidebar -->
        <Sidebar class="hidden md:flex w-[72px] xl:w-[244px] flex-col fixed h-screen border-r border-gray-100 dark:border-gray-800 z-50 bg-white dark:bg-black" />

        <!-- Main Content -->
        <main class="flex-1 flex justify-center w-full md:pl-[72px] xl:pl-[244px]">
            <div class="w-full max-w-[630px] pt-8 px-4 pb-20 md:pb-0">
                <slot />
            </div>
        </main>

        <!-- Right Sidebar (Hidden on smaller screens) -->
        <div class="hidden lg:block w-[380px] pl-16 pt-8 pr-4">
            <RightSidebar />
        </div>

        <!-- Mobile Bottom Nav (Visible only on small screens) -->
        <div class="md:hidden fixed bottom-0 w-full bg-white dark:bg-black border-t border-gray-100 dark:border-gray-800 flex justify-around items-center h-12 z-50 px-4">
            <!-- Icons placeholders for now, can reuse Sidebar icons logic later -->
            <div class="w-6 h-6 bg-gray-200 dark:bg-gray-800 rounded-full"></div>
            <div class="w-6 h-6 bg-gray-200 dark:bg-gray-800 rounded-full"></div>
            <div class="w-6 h-6 bg-gray-200 dark:bg-gray-800 rounded-full"></div>
            <div class="w-6 h-6 bg-gray-200 dark:bg-gray-800 rounded-full"></div>
            <div class="w-6 h-6 bg-gray-200 dark:bg-gray-800 rounded-full"></div>
        </div>
    </div>
</template>
