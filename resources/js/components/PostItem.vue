<script setup lang="ts">
import { Heart, MessageCircle, Send, Bookmark, MoreHorizontal } from 'lucide-vue-next';
import { ref } from 'vue';

const props = defineProps<{
    post: {
        id: number;
        username: string;
        userImage: string;
        image: string;
        likes: number;
        caption: string;
        time: string;
        comments: number;
    };
}>();

const isLiked = ref(false);
const isSaved = ref(false);

const toggleLike = () => {
    isLiked.value = !isLiked.value;
};

const toggleSave = () => {
    isSaved.value = !isSaved.value;
};
</script>

<template>
    <article class="bg-white dark:bg-black border-b border-gray-200 dark:border-gray-800 pb-4 mb-4">
        <!-- Header -->
        <div class="flex items-center justify-between py-3 px-1">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-gray-200 overflow-hidden cursor-pointer ring-2 ring-transparent hover:ring-gray-300 transition-all">
                    <img :src="post.userImage" :alt="post.username" class="w-full h-full object-cover" />
                </div>
                <div class="flex items-center gap-2">
                    <span class="font-semibold text-sm cursor-pointer hover:opacity-70">{{ post.username }}</span>
                    <span class="text-gray-500 text-xs">• {{ post.time }}</span>
                </div>
            </div>
            <button class="text-gray-900 dark:text-white hover:opacity-60">
                <MoreHorizontal :size="20" />
            </button>
        </div>

        <!-- Image -->
        <div class="w-full aspect-square bg-gray-100 dark:bg-gray-900 overflow-hidden rounded-[4px] border border-gray-100 dark:border-gray-800">
            <img :src="post.image" :alt="post.caption" class="w-full h-full object-cover" />
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-between py-3 px-1">
            <div class="flex items-center gap-4">
                <button @click="toggleLike" class="hover:opacity-60 transition-opacity">
                    <Heart :size="24" :class="{ 'fill-red-500 text-red-500': isLiked, 'text-black dark:text-white': !isLiked }" />
                </button>
                <button class="hover:opacity-60 transition-opacity text-black dark:text-white">
                    <MessageCircle :size="24" class="-rotate-90" />
                </button>
                <button class="hover:opacity-60 transition-opacity text-black dark:text-white">
                    <Send :size="24" />
                </button>
            </div>
            <button @click="toggleSave" class="hover:opacity-60 transition-opacity text-black dark:text-white">
                <Bookmark :size="24" :class="{ 'fill-black dark:fill-white': isSaved }" />
            </button>
        </div>

        <!-- Likes -->
        <div class="px-1 mb-2">
            <span class="font-semibold text-sm">{{ post.likes.toLocaleString() }} likes</span>
        </div>

        <!-- Caption -->
        <div class="px-1 mb-2">
            <span class="font-semibold text-sm mr-2">{{ post.username }}</span>
            <span class="text-sm">{{ post.caption }}</span>
        </div>

        <!-- Comments -->
        <div class="px-1 mb-2">
            <button class="text-gray-500 text-sm cursor-pointer hover:text-gray-900 dark:hover:text-gray-300">
                View all {{ post.comments }} comments
            </button>
        </div>

        <!-- Add Comment -->
        <div class="px-1 flex items-center gap-2">
            <input type="text" placeholder="Add a comment..." class="w-full bg-transparent text-sm border-none focus:ring-0 p-0 placeholder-gray-500" />
            <button class="text-blue-500 font-semibold text-sm hover:text-blue-700 opacity-0 focus:opacity-100 transition-opacity">Post</button>
        </div>
    </article>
</template>
