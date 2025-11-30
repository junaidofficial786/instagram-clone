<script setup lang="ts">
import { Heart, MessageCircle, Send, Bookmark, MoreHorizontal } from 'lucide-vue-next';
import { ref, computed } from 'vue';
import UserAvatar from '@/components/UserAvatar.vue';
import { formatDistanceToNow } from 'date-fns';

const props = defineProps<{
    post: {
        id: number;
        user: {
            username: string;
            name: string;
            avatar?: string | null;
        };
        caption: string;
        location?: string | null;
        created_at: string;
        images: Array<{
            url: string;
        }>;
        comments: Array<{
            id: number;
            user: {
                username: string;
                name: string;
                avatar?: string | null;
            };
            content: string;
        }>;
        likes_count?: number;
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

const postImage = computed(() => {
    if (props.post.images && props.post.images.length > 0) {
        const url = props.post.images[0].url;
        return url.startsWith('http') ? url : `/storage/${url}`;
    }
    return 'https://via.placeholder.com/600';
});

const timeAgo = computed(() => {
    try {
        return formatDistanceToNow(new Date(props.post.created_at), { addSuffix: true });
    } catch (e) {
        return '';
    }
});
</script>

<template>
    <article class="bg-white dark:bg-black border-b border-gray-200 dark:border-gray-800 pb-4 mb-4">
        <!-- Header -->
        <div class="flex items-center justify-between py-3 px-1">
            <div class="flex items-center gap-3">
                <div class="cursor-pointer ring-2 ring-transparent hover:ring-gray-300 transition-all rounded-full">
                    <UserAvatar :user="post.user" size="md" />
                </div>
                <div class="flex flex-col">
                    <div class="flex items-center gap-2">
                        <span class="font-semibold text-sm cursor-pointer hover:opacity-70">{{ post.user.username }}</span>
                        <span class="text-gray-500 text-xs">• {{ timeAgo }}</span>
                    </div>
                    <span v-if="post.location" class="text-xs text-gray-500">{{ post.location }}</span>
                </div>
            </div>
            <button class="text-gray-900 dark:text-white hover:opacity-60">
                <MoreHorizontal :size="20" />
            </button>
        </div>

        <!-- Image -->
        <div class="w-full aspect-square bg-gray-100 dark:bg-gray-900 overflow-hidden rounded-[4px] border border-gray-100 dark:border-gray-800">
            <img :src="postImage" :alt="post.caption" class="w-full h-full object-cover" />
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
            <span class="font-semibold text-sm">{{ (post.likes_count || 0).toLocaleString() }} likes</span>
        </div>

        <!-- Caption -->
        <div class="px-1 mb-2">
            <span class="font-semibold text-sm mr-2">{{ post.user.username }}</span>
            <span class="text-sm">{{ post.caption }}</span>
        </div>

        <!-- Comments -->
        <div class="px-1 mb-2 flex flex-col gap-1">
            <div v-for="comment in post.comments" :key="comment.id" class="flex items-start gap-2">
                <span class="font-semibold text-sm whitespace-nowrap">{{ comment.user.username }}</span>
                <span class="text-sm line-clamp-2">{{ comment.content }}</span>
            </div>
            <button v-if="post.comments.length > 0" class="text-gray-500 text-sm cursor-pointer hover:text-gray-900 dark:hover:text-gray-300 text-left mt-1">
                View all comments
            </button>
        </div>

        <!-- Add Comment -->
        <div class="px-1 flex items-center gap-2 mt-2">
            <UserAvatar :user="$page.props.currentUser" size="sm" />
            <input type="text" placeholder="Add a comment..." class="w-full bg-transparent text-sm border-none focus:ring-0 p-0 placeholder-gray-500" />
            <button class="text-blue-500 font-semibold text-sm hover:text-blue-700 opacity-0 focus:opacity-100 transition-opacity">Post</button>
        </div>
    </article>
</template>
