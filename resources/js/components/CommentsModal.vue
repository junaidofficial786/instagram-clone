<script setup lang="ts">
import { ref, watch, nextTick } from 'vue';
import { X, Send } from 'lucide-vue-next';
import UserAvatar from '@/components/UserAvatar.vue';
import { Link } from '@inertiajs/vue3';
import axios from 'axios';

const props = defineProps<{
    show: boolean;
    postId: number;
    postImage?: string;
    postCaption?: string;
    postUser?: {
        username: string;
        avatar?: string | null;
    };
}>();

const emit = defineEmits<{
    close: [];
    commentAdded: [];
}>();

interface Comment {
    id: number;
    content: string;
    created_at: string;
    user: {
        id: number;
        username: string;
        name: string;
        avatar?: string | null;
    };
}

const comments = ref<Comment[]>([]);
const isLoading = ref(false);
const newComment = ref('');
const isSubmitting = ref(false);
const commentsContainer = ref<HTMLElement | null>(null);

const fetchComments = async () => {
    if (!props.show) return;
    
    isLoading.value = true;
    try {
        const response = await axios.get(`/posts/${props.postId}/comments`);
        comments.value = response.data;
        
        // Scroll to bottom after comments load
        await nextTick();
        if (commentsContainer.value) {
            commentsContainer.value.scrollTop = commentsContainer.value.scrollHeight;
        }
    } catch (error) {
        console.error('Failed to fetch comments:', error);
    } finally {
        isLoading.value = false;
    }
};

const submitComment = async () => {
    if (!newComment.value.trim() || isSubmitting.value) return;
    
    isSubmitting.value = true;
    try {
        const response = await axios.post(`/posts/${props.postId}/comments`, {
            content: newComment.value.trim(),
        });
        
        comments.value.unshift(response.data);
        newComment.value = '';
        emit('commentAdded');
        
        // Scroll to top to show new comment
        await nextTick();
        if (commentsContainer.value) {
            commentsContainer.value.scrollTop = 0;
        }
    } catch (error) {
        console.error('Failed to post comment:', error);
        alert('Failed to post comment');
    } finally {
        isSubmitting.value = false;
    }
};

watch(() => props.show, (newVal) => {
    if (newVal) {
        fetchComments();
    } else {
        newComment.value = '';
    }
});

const handleClose = () => {
    emit('close');
};
</script>

<template>
    <Teleport to="body">
        <Transition name="modal">
            <div v-if="show" class="fixed inset-0 z-50 flex items-center justify-center p-4" @click="handleClose">
                <!-- Backdrop -->
                <div class="absolute inset-0 bg-black/80"></div>
                
                <!-- Modal -->
                <div 
                    class="relative bg-white dark:bg-black rounded-lg shadow-xl w-full max-w-5xl h-[90vh] flex overflow-hidden"
                    @click.stop
                >
                    <!-- Left Side - Image -->
                    <div class="hidden md:flex md:w-3/5 bg-black items-center justify-center">
                        <img 
                            v-if="postImage" 
                            :src="postImage" 
                            alt="Post" 
                            class="max-w-full max-h-full object-contain"
                        />
                    </div>
                    
                    <!-- Right Side - Comments -->
                    <div class="flex flex-col w-full md:w-2/5 border-l border-gray-200 dark:border-gray-800">
                        <!-- Header -->
                        <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-800">
                            <div class="flex items-center gap-3">
                                <UserAvatar :user="postUser" size="sm" />
                                <Link 
                                    :href="`/profile/${postUser?.username}`"
                                    class="font-semibold text-sm hover:opacity-70"
                                >
                                    {{ postUser?.username }}
                                </Link>
                            </div>
                            <button @click="handleClose" class="hover:opacity-60 transition-opacity">
                                <X :size="24" />
                            </button>
                        </div>
                        
                        <!-- Comments List -->
                        <div ref="commentsContainer" class="flex-1 overflow-y-auto p-4 space-y-4">
                            <!-- Post Caption as First Comment -->
                            <div v-if="postCaption" class="flex gap-3">
                                <UserAvatar :user="postUser" size="sm" />
                                <div class="flex-1">
                                    <div class="flex items-baseline gap-2">
                                        <Link 
                                            :href="`/profile/${postUser?.username}`"
                                            class="font-semibold text-sm hover:opacity-70"
                                        >
                                            {{ postUser?.username }}
                                        </Link>
                                        <span class="text-sm">{{ postCaption }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Loading State -->
                            <div v-if="isLoading" class="flex items-center justify-center py-8">
                                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-gray-900 dark:border-white"></div>
                            </div>
                            
                            <!-- Comments -->
                            <div v-else-if="comments.length === 0 && !postCaption" class="py-8 text-center text-gray-500">
                                No comments yet. Be the first to comment!
                            </div>
                            
                            <div v-else v-for="comment in comments" :key="comment.id" class="flex gap-3">
                                <UserAvatar :user="comment.user" size="sm" />
                                <div class="flex-1">
                                    <div class="flex items-baseline gap-2 mb-1">
                                        <Link 
                                            :href="`/profile/${comment.user.username}`"
                                            class="font-semibold text-sm hover:opacity-70"
                                        >
                                            {{ comment.user.username }}
                                        </Link>
                                        <span class="text-sm">{{ comment.content }}</span>
                                    </div>
                                    <div class="text-xs text-gray-500">{{ comment.created_at }}</div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Add Comment -->
                        <div class="border-t border-gray-200 dark:border-gray-800 p-4">
                            <form @submit.prevent="submitComment" class="flex items-center gap-3">
                                <input 
                                    v-model="newComment"
                                    type="text" 
                                    placeholder="Add a comment..." 
                                    class="flex-1 bg-transparent text-sm border-none focus:ring-0 p-0 placeholder-gray-500"
                                    :disabled="isSubmitting"
                                />
                                <button 
                                    type="submit"
                                    :disabled="!newComment.trim() || isSubmitting"
                                    class="text-blue-500 font-semibold text-sm hover:text-blue-700 disabled:opacity-30 disabled:cursor-not-allowed transition-opacity"
                                >
                                    <Send :size="20" />
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </Transition>
    </Teleport>
</template>

<style scoped>
.modal-enter-active,
.modal-leave-active {
    transition: opacity 0.2s ease;
}

.modal-enter-from,
.modal-leave-to {
    opacity: 0;
}

.modal-enter-active .relative,
.modal-leave-active .relative {
    transition: transform 0.2s ease;
}

.modal-enter-from .relative,
.modal-leave-to .relative {
    transform: scale(0.95);
}
</style>
