<script setup lang="ts">
import { Head } from '@inertiajs/vue3';

defineProps<{
    title?: string;
}>();
</script>

<template>
    <Head :title="title || ''">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Grand+Hotel&display=swap" rel="stylesheet">
    </Head>

    <div class="min-h-screen bg-gray-50 flex items-center justify-center p-4 dark:bg-black">
        <div class="flex w-full max-w-[850px] items-center justify-center gap-8">
            
            <!-- Phone Mockup (Hidden on mobile) -->
            <div class="hidden md:block relative w-[380px] h-[580px]">
                <div class="absolute inset-0 bg-black rounded-[2.5rem] border-[8px] border-gray-800 overflow-hidden shadow-2xl">
                    <!-- Screen Content -->
                    <div class="w-full h-full bg-white dark:bg-gray-900 flex flex-col relative">
                        <!-- Status Bar -->
                        <div class="h-6 bg-transparent w-full flex justify-between px-6 items-center text-xs font-semibold text-black dark:text-white z-10 mt-2">
                            <span>9:41</span>
                            <div class="flex gap-1">
                                <div class="w-4 h-2.5 bg-current rounded-[1px]"></div>
                                <div class="w-2.5 h-2.5 bg-current rounded-full"></div>
                            </div>
                        </div>

                        <!-- App Header -->
                        <div class="h-12 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between px-4 shrink-0">
                            <span class="font-['Grand_Hotel'] text-2xl mt-1 dark:text-white">Instagram</span>
                            <div class="w-6 h-6 rounded-full border-2 border-black dark:border-white"></div>
                        </div>

                        <!-- Feed Placeholder -->
                        <div class="flex-1 overflow-hidden p-0 space-y-4">
                            <!-- Story Bubbles -->
                            <div class="flex gap-3 p-3 overflow-x-hidden border-b border-gray-100 dark:border-gray-800">
                                <div v-for="i in 4" :key="i" class="flex flex-col items-center gap-1">
                                    <div class="w-14 h-14 rounded-full ring-2 ring-pink-500 p-0.5">
                                        <div class="w-full h-full bg-gray-200 dark:bg-gray-800 rounded-full"></div>
                                    </div>
                                    <div class="w-10 h-2 bg-gray-100 dark:bg-gray-800 rounded"></div>
                                </div>
                            </div>
                            <!-- Post -->
                            <div class="pb-4">
                                <div class="flex items-center gap-2 px-3 mb-2">
                                    <div class="w-8 h-8 rounded-full bg-gray-200 dark:bg-gray-800"></div>
                                    <div class="w-24 h-3 bg-gray-100 dark:bg-gray-800 rounded"></div>
                                </div>
                                <div class="w-full aspect-square bg-gray-100 dark:bg-gray-800 mb-2"></div>
                                <div class="px-3 space-y-2">
                                    <div class="flex gap-3">
                                        <div class="w-6 h-6 bg-gray-200 dark:bg-gray-800 rounded-full"></div>
                                        <div class="w-6 h-6 bg-gray-200 dark:bg-gray-800 rounded-full"></div>
                                        <div class="w-6 h-6 bg-gray-200 dark:bg-gray-800 rounded-full"></div>
                                    </div>
                                    <div class="w-32 h-3 bg-gray-100 dark:bg-gray-800 rounded"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Bottom Nav -->
                        <div class="h-12 border-t border-gray-100 dark:border-gray-800 flex justify-around items-center px-2 shrink-0 pb-2">
                            <div v-for="i in 5" :key="i" class="w-6 h-6 bg-gray-200 dark:bg-gray-800 rounded-md"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side: Auth Card -->
            <div class="flex flex-col gap-4 w-[350px]">
                <slot />
            </div>

        </div>
        
        <!-- Footer -->
        <div class="fixed bottom-0 w-full p-4 bg-gray-50 dark:bg-black text-center">
             <div class="flex flex-wrap justify-center gap-x-4 gap-y-2 text-xs text-gray-500">
                <span>Meta</span>
                <span>About</span>
                <span>Blog</span>
                <span>Jobs</span>
                <span>Help</span>
                <span>API</span>
                <span>Privacy</span>
                <span>Terms</span>
                <span>Locations</span>
                <span>Instagram Lite</span>
                <span>Threads</span>
                <span>Contact Uploading & Non-Users</span>
                <span>Meta Verified</span>
            </div>
            <div class="mt-4 text-xs text-gray-500">
                © 2024 Instagram from Meta
            </div>
        </div>
    </div>
</template>

<style>
/* Custom Scrollbar for the stories */
::-webkit-scrollbar {
    width: 0px;
    background: transparent;
}
</style>
