<script setup lang="ts">
import { Heart, MessageCircle, Send, Bookmark, MoreHorizontal, Trash2, Link as LinkIcon, BookmarkPlus } from 'lucide-vue-next';
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { router } from '@inertiajs/vue3';
import UserAvatar from '@/components/UserAvatar.vue';
import LikesModal from '@/components/LikesModal.vue';
import { formatDistanceToNow } from 'date-fns';
import axios from 'axios';

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
        is_liked_by_current_user?: boolean;
        is_own_post?: boolean;
    };
}>();

const emit = defineEmits<{
    postDeleted: [postId: number];
}>();

const isLiked = ref(props.post.is_liked_by_current_user || false);
const isSaved = ref(false);
const likesCount = ref(props.post.likes_count || 0);
const showMenu = ref(false);
const isDeleting = ref(false);
const showLikesModal = ref(false);

const toggleLike = async () => {
    const previousState = isLiked.value;
    const previousCount = likesCount.value;
    
    // Optimistic update
    isLiked.value = !isLiked.value;
    likesCount.value += isLiked.value ? 1 : -1;
    
    try {
        if (isLiked.value) {
            await axios.post(`/posts/${props.post.id}/like`);
        } else {
            await axios.delete(`/posts/${props.post.id}/like`);
        }
    } catch (error) {
        // Revert on error
        isLiked.value = previousState;
        likesCount.value = previousCount;
        console.error('Failed to toggle like:', error);
    }
};

const toggleSave = () => {
    isSaved.value = !isSaved.value;
};

const deletePost = async () => {
    if (!confirm('Are you sure you want to delete this post?')) {
        return;
    }
    
    isDeleting.value = true;
    showMenu.value = false;
    
    try {
        await axios.delete(`/posts/${props.post.id}`);
        
        // Emit event to parent to remove post from list
        emit('postDeleted', props.post.id);
        
        // Show success message
        const toast = document.createElement('div');
        toast.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
        toast.textContent = 'Post deleted successfully';
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.remove();
        }, 3000);
    } catch (error) {
        console.error('Failed to delete post:', error);
        alert('Failed to delete post');
        isDeleting.value = false;
    }
};

const copyLink = () => {
    const url = `${window.location.origin}/posts/${props.post.id}`;
    navigator.clipboard.writeText(url);
    showMenu.value = false;
    alert('Link copied to clipboard!');
};

const savePost = () => {
    // TODO: Implement save post functionality
    showMenu.value = false;
    alert('Save post feature coming soon!');
};

// Close menu when clicking outside
const menuRef = ref<HTMLElement | null>(null);

const handleClickOutside = (event: MouseEvent) => {
    if (menuRef.value && !menuRef.value.contains(event.target as Node)) {
        showMenu.value = false;
    }
};

onMounted(() => {
    document.addEventListener('click', handleClickOutside);
});

onUnmounted(() => {
    document.removeEventListener('click', handleClickOutside);
});

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
            <div ref="menuRef" class="relative">
                <button @click.stop="showMenu = !showMenu" class="text-gray-900 dark:text-white hover:opacity-60">
                    <MoreHorizontal :size="20" />
                </button>
                
                <!-- Dropdown Menu -->
                <div v-if="showMenu" class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-900 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 py-2 z-50">
                    <!-- Delete (only for own posts) -->
                    <button 
                        v-if="post.is_own_post"
                        @click="deletePost"
                        :disabled="isDeleting"
                        class="flex items-center gap-3 px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors w-full text-left text-red-500"
                    >
                        <Trash2 :size="20" />
                        <span class="text-sm font-semibold">{{ isDeleting ? 'Deleting...' : 'Delete' }}</span>
                    </button>
                    
                    <!-- Divider -->
                    <div v-if="post.is_own_post" class="h-px bg-gray-200 dark:bg-gray-700 my-1"></div>
                    
                    <!-- Save Post -->
                    <button 
                        @click="savePost"
                        class="flex items-center gap-3 px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors w-full text-left"
                    >
                        <BookmarkPlus :size="20" />
                        <span class="text-sm">Save Post</span>
                    </button>
                    
                    <!-- Copy Link -->
                    <button 
                        @click="copyLink"
                        class="flex items-center gap-3 px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors w-full text-left"
                    >
                        <LinkIcon :size="20" />
                        <span class="text-sm">Copy Link</span>
                    </button>
                </div>
            </div>
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
            <button 
                @click="showLikesModal = true"
                class="font-semibold text-sm hover:opacity-70 transition-opacity"
            >
                {{ likesCount.toLocaleString() }} likes
            </button>
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
        
        <!-- Likes Modal -->
        <LikesModal 
            :show="showLikesModal" 
            :post-id="post.id" 
            @close="showLikesModal = false"
        />
    </article>
</template>
