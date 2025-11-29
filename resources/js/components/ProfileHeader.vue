<script setup lang="ts">
import { Settings } from 'lucide-vue-next';
import { Link } from '@inertiajs/vue3';

defineProps<{
    user?: {
        username: string;
        name: string;
        avatar?: string;
        bio?: string;
        website?: string;
        postsCount: number;
        followersCount: number;
        followingCount: number;
        isOwnProfile: boolean;
    };
}>();
</script>

<template>
    <div class="flex flex-col gap-8 pb-8">
        <!-- Profile Info Section -->
        <div class="flex gap-8 md:gap-16 items-start">
            <!-- Profile Picture -->
            <div class="flex-shrink-0">
                <div class="w-20 h-20 md:w-36 md:h-36 rounded-full overflow-hidden bg-gray-200 border border-gray-300 dark:border-gray-700">
                    <img 
                        :src="user?.avatar || `https://ui-avatars.com/api/?name=${user?.username || 'User'}&background=random&size=150`" 
                        :alt="user?.username"
                        class="w-full h-full object-cover"
                    />
                </div>
            </div>

            <!-- Profile Details -->
            <div class="flex-1">
                <!-- Username and Actions -->
                <div class="flex items-center gap-4 mb-5">
                    <h2 class="text-xl font-light">{{ user?.username || 'username' }}</h2>
                    
                    <button 
                        v-if="user?.isOwnProfile"
                        class="bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 px-4 py-1.5 rounded-lg font-semibold text-sm transition-colors"
                    >
                        Edit profile
                    </button>
                    <button 
                        v-else
                        class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-1.5 rounded-lg font-semibold text-sm transition-colors"
                    >
                        Follow
                    </button>

                    <button 
                        v-if="user?.isOwnProfile"
                        class="bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 px-4 py-1.5 rounded-lg font-semibold text-sm transition-colors"
                    >
                        View archive
                    </button>

                    <button 
                        v-if="user?.isOwnProfile"
                        class="hover:opacity-70 transition-opacity"
                    >
                        <Settings :size="24" />
                    </button>
                </div>

                <!-- Stats -->
                <div class="flex gap-8 mb-5">
                    <div class="flex gap-1">
                        <span class="font-semibold">{{ user?.postsCount || 0 }}</span>
                        <span class="text-gray-600 dark:text-gray-400">posts</span>
                    </div>
                    <button class="flex gap-1 hover:opacity-70 transition-opacity">
                        <span class="font-semibold">{{ user?.followersCount || 0 }}</span>
                        <span class="text-gray-600 dark:text-gray-400">followers</span>
                    </button>
                    <button class="flex gap-1 hover:opacity-70 transition-opacity">
                        <span class="font-semibold">{{ user?.followingCount || 0 }}</span>
                        <span class="text-gray-600 dark:text-gray-400">following</span>
                    </button>
                </div>

                <!-- Name and Bio -->
                <div class="text-sm">
                    <div class="font-semibold mb-1">{{ user?.name || 'Full Name' }}</div>
                    <div v-if="user?.bio" class="whitespace-pre-wrap mb-1">{{ user.bio }}</div>
                    <a 
                        v-if="user?.website" 
                        :href="user.website" 
                        target="_blank"
                        class="text-blue-900 dark:text-blue-400 hover:underline font-semibold"
                    >
                        {{ user.website }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Highlights (Stories) Placeholder -->
        <div class="border-t border-gray-200 dark:border-gray-800 pt-4">
            <div class="flex gap-8 overflow-x-auto pb-2">
                <!-- Placeholder for story highlights -->
            </div>
        </div>
    </div>
</template>
