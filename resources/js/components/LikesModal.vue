<script setup lang="ts">
import { ref, watch } from 'vue';
import { X } from 'lucide-vue-next';
import UserAvatar from '@/components/UserAvatar.vue';
import { Link } from '@inertiajs/vue3';
import axios from 'axios';

const props = defineProps<{
    show: boolean;
    postId: number;
}>();

const emit = defineEmits<{
    close: [];
}>();

interface LikeUser {
    id: number;
    username: string;
    name: string;
    avatar?: string | null;
}

const users = ref<LikeUser[]>([]);
const isLoading = ref(false);

const fetchLikes = async () => {
    if (!props.show) return;
    
    isLoading.value = true;
    try {
        const response = await axios.get(`/posts/${props.postId}/likes`);
        users.value = response.data;
    } catch (error) {
        console.error('Failed to fetch likes:', error);
    } finally {
        isLoading.value = false;
    }
};

watch(() => props.show, (newVal) => {
    if (newVal) {
        fetchLikes();
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
                <div class="absolute inset-0 bg-black/60"></div>
                
                <!-- Modal -->
                <div 
                    class="relative bg-white dark:bg-gray-900 rounded-xl shadow-xl w-full max-w-md"
                    @click.stop
                >
                    <!-- Header -->
                    <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-base font-semibold">Likes</h3>
                        <button @click="handleClose" class="hover:opacity-60 transition-opacity">
                            <X :size="24" />
                        </button>
                    </div>
                    
                    <!-- Content -->
                    <div class="overflow-y-auto" style="max-height: 400px;">
                        <div v-if="isLoading" class="flex items-center justify-center py-8">
                            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-gray-900 dark:border-white"></div>
                        </div>
                        
                        <div v-else-if="users.length === 0" class="py-8 text-center text-gray-500">
                            No likes yet
                        </div>
                        
                        <div v-else class="py-2">
                            <Link
                                v-for="user in users"
                                :key="user.id"
                                :href="`/profile/${user.username}`"
                                class="flex items-center gap-3 px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors"
                                @click="handleClose"
                            >
                                <UserAvatar :user="user" size="md" />
                                <div class="flex-1 min-w-0">
                                    <p class="font-semibold text-sm truncate">{{ user.username }}</p>
                                    <p class="text-xs text-gray-500 truncate">{{ user.name }}</p>
                                </div>
                            </Link>
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
