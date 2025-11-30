<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

defineProps<{
    currentUser?: {
        username: string;
        name: string;
        avatar?: string | null;
    };
}>();

const suggestions = [
    { id: 1, username: 'suggested_user_1', subtitle: 'New to Instagram' },
    { id: 2, username: 'suggested_user_2', subtitle: 'Followed by user_3' },
    { id: 3, username: 'suggested_user_3', subtitle: 'Suggested for you' },
    { id: 4, username: 'suggested_user_4', subtitle: 'Follows you' },
    { id: 5, username: 'suggested_user_5', subtitle: 'New to Instagram' },
];
</script>

<template>
    <div class="flex flex-col gap-4">
        <!-- User Profile Summary -->
        <div class="flex items-center justify-between mb-2">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-full bg-gray-200 overflow-hidden">
                    <img 
                        :src="currentUser?.avatar || `https://ui-avatars.com/api/?name=${currentUser?.username || 'User'}&background=random&size=100`" 
                        alt="Profile" 
                        class="w-full h-full object-cover" 
                    />
                </div>
                <div class="flex flex-col">
                    <span class="font-semibold text-sm">{{ currentUser?.username || 'current_user' }}</span>
                    <span class="text-gray-500 text-sm">{{ currentUser?.name || 'Current User' }}</span>
                </div>
            </div>
            <Link href="#" class="text-xs font-semibold text-blue-500 hover:text-blue-700">Switch</Link>
        </div>

        <!-- Suggestions Header -->
        <div class="flex items-center justify-between mb-2">
            <span class="text-sm font-semibold text-gray-500">Suggested for you</span>
            <Link href="#" class="text-xs font-semibold text-gray-900 dark:text-white hover:text-gray-500">See All</Link>
        </div>

        <!-- Suggestions List -->
        <div class="flex flex-col gap-3">
            <div v-for="user in suggestions" :key="user.id" class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-gray-200 overflow-hidden">
                        <img :src="`https://ui-avatars.com/api/?name=${user.username}&background=random`" alt="Profile" class="w-full h-full object-cover" />
                    </div>
                    <div class="flex flex-col">
                        <Link href="#" class="font-semibold text-sm hover:underline">{{ user.username }}</Link>
                        <span class="text-xs text-gray-500">{{ user.subtitle }}</span>
                    </div>
                </div>
                <button class="text-xs font-semibold text-blue-500 hover:text-blue-700">Follow</button>
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-8 text-xs text-gray-400">
            <nav class="flex flex-wrap gap-1 mb-4">
                <a href="#" class="hover:underline">About</a> &middot;
                <a href="#" class="hover:underline">Help</a> &middot;
                <a href="#" class="hover:underline">Press</a> &middot;
                <a href="#" class="hover:underline">API</a> &middot;
                <a href="#" class="hover:underline">Jobs</a> &middot;
                <a href="#" class="hover:underline">Privacy</a> &middot;
                <a href="#" class="hover:underline">Terms</a> &middot;
                <a href="#" class="hover:underline">Locations</a> &middot;
                <a href="#" class="hover:underline">Language</a> &middot;
                <a href="#" class="hover:underline">Meta Verified</a>
            </nav>
            <span>&copy; 2025 INSTAGRAM FROM META</span>
        </div>
    </div>
</template>
