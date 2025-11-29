<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { defineProps } from 'vue';
import { login, register } from '@/routes';
import InstagramAuthLayout from '@/layouts/InstagramAuthLayout.vue';
import InstagramButton from '@/components/InstagramButton.vue';

defineProps<{
    canLogin?: boolean;
    canRegister?: boolean;
    laravelVersion?: string;
    phpVersion?: string;
}>();
</script>

<template>
    <InstagramAuthLayout title="Instagram">
        <!-- Main Card -->
        <div class="bg-white dark:bg-black border border-gray-300 dark:border-gray-800 flex flex-col items-center p-8 pb-6 rounded-[1px]">
            <h1 class="font-['Grand_Hotel'] text-5xl mb-8 mt-2 dark:text-white">Instagram</h1>
            
            <div class="w-full flex flex-col gap-3">
                <Link :href="login()" class="w-full">
                    <InstagramButton>Log in</InstagramButton>
                </Link>

                <div class="flex items-center gap-4 my-3 w-full">
                    <div class="h-[1px] bg-gray-300 dark:bg-gray-700 flex-1"></div>
                    <span class="text-xs font-semibold text-gray-500 uppercase">OR</span>
                    <div class="h-[1px] bg-gray-300 dark:bg-gray-700 flex-1"></div>
                </div>

                <Link
                    v-if="canRegister"
                    :href="register()"
                    class="flex justify-center items-center w-full text-[#0095f6] font-semibold text-sm hover:text-[#00376b] transition-colors"
                >
                    Sign up
                </Link>
            </div>
        </div>

        <!-- Sign up Card -->
        <div class="bg-white dark:bg-black border border-gray-300 dark:border-gray-800 p-5 text-center rounded-[1px]">
            <p class="text-sm text-gray-800 dark:text-gray-200">
                Don't have an account? 
                <Link :href="register()" class="text-[#0095f6] font-semibold">Sign up</Link>
            </p>
        </div>

        <!-- Get the app -->
        <div class="text-center space-y-4">
            <p class="text-sm text-gray-800 dark:text-gray-200">Get the app.</p>
            <div class="flex justify-center gap-2">
                <div class="h-10 w-32 bg-black rounded border border-gray-700 flex items-center justify-center text-white text-xs">
                    <span class="font-semibold">Google Play</span>
                </div>
                <div class="h-10 w-32 bg-black rounded border border-gray-700 flex items-center justify-center text-white text-xs">
                    <span class="font-semibold">Microsoft</span>
                </div>
            </div>
        </div>
    </InstagramAuthLayout>
</template>
