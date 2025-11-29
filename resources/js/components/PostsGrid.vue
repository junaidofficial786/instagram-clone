<script setup lang="ts">
import { Grid3x3, Bookmark, UserSquare2, Heart, MessageCircle } from 'lucide-vue-next';
import { ref } from 'vue';

defineProps<{
    posts?: Array<{
        id: number;
        image: string;
        likes: number;
        comments: number;
    }>;
}>();

const activeTab = ref('posts');
</script>

<template>
    <div class="flex flex-col">
        <!-- Tabs -->
        <div class="border-t border-gray-200 dark:border-gray-800 flex justify-center gap-16 mb-4">
            <button 
                @click="activeTab = 'posts'"
                class="flex items-center gap-2 py-3 border-t border-transparent -mt-px transition-colors"
                :class="activeTab === 'posts' ? 'border-black dark:border-white font-semibold' : 'text-gray-500'"
            >
                <Grid3x3 :size="12" />
                <span class="text-xs uppercase tracking-wider">Posts</span>
            </button>
            <button 
                @click="activeTab = 'saved'"
                class="flex items-center gap-2 py-3 border-t border-transparent -mt-px transition-colors"
                :class="activeTab === 'saved' ? 'border-black dark:border-white font-semibold' : 'text-gray-500'"
            >
                <Bookmark :size="12" />
                <span class="text-xs uppercase tracking-wider">Saved</span>
            </button>
            <button 
                @click="activeTab = 'tagged'"
                class="flex items-center gap-2 py-3 border-t border-transparent -mt-px transition-colors"
                :class="activeTab === 'tagged' ? 'border-black dark:border-white font-semibold' : 'text-gray-500'"
            >
                <UserSquare2 :size="12" />
                <span class="text-xs uppercase tracking-wider">Tagged</span>
            </button>
        </div>

        <!-- Posts Grid -->
        <div v-if="activeTab === 'posts'" class="grid grid-cols-3 gap-1 md:gap-4">
            <div 
                v-for="post in posts" 
                :key="post.id"
                class="relative aspect-square bg-gray-100 dark:bg-gray-900 overflow-hidden cursor-pointer group"
            >
                <img :src="post.image" :alt="`Post ${post.id}`" class="w-full h-full object-cover" />
                
                <!-- Hover Overlay -->
                <div class="absolute inset-0 bg-black bg-opacity-40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-6 text-white">
                    <div class="flex items-center gap-2">
                        <Heart :size="24" class="fill-white" />
                        <span class="font-semibold">{{ post.likes }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <MessageCircle :size="24" class="fill-white" />
                        <span class="font-semibold">{{ post.comments }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Empty State -->
        <div v-if="!posts || posts.length === 0" class="flex flex-col items-center justify-center py-16">
            <div class="w-16 h-16 border-2 border-black dark:border-white rounded-full flex items-center justify-center mb-4">
                <Grid3x3 :size="32" />
            </div>
            <h3 class="text-2xl font-light mb-2">No Posts Yet</h3>
        </div>

        <!-- Saved Tab Content -->
        <div v-if="activeTab === 'saved'" class="flex flex-col items-center justify-center py-16">
            <div class="w-16 h-16 border-2 border-black dark:border-white rounded-full flex items-center justify-center mb-4">
                <Bookmark :size="32" />
            </div>
            <h3 class="text-2xl font-light mb-2">No Saved Posts</h3>
        </div>

        <!-- Tagged Tab Content -->
        <div v-if="activeTab === 'tagged'" class="flex flex-col items-center justify-center py-16">
            <div class="w-16 h-16 border-2 border-black dark:border-white rounded-full flex items-center justify-center mb-4">
                <UserSquare2 :size="32" />
            </div>
            <h3 class="text-2xl font-light mb-2">No Tagged Posts</h3>
        </div>
    </div>
</template>
