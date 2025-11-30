<script setup lang="ts">
import InstagramLayout from '@/layouts/InstagramLayout.vue';
import StoryRail from '@/components/StoryRail.vue';
import PostItem from '@/components/PostItem.vue';
import { ref, onMounted } from 'vue';
import axios from 'axios';

const props = defineProps<{
    currentUser: {
        username: string;
        name: string;
        avatar?: string | null;
    };
    posts: {
        data: Array<any>;
        next_page_url: string | null;
    };
}>();

const allPosts = ref(props.posts.data);
const nextPageUrl = ref(props.posts.next_page_url);
const isLoading = ref(false);
const loadMoreTrigger = ref<HTMLElement | null>(null);

const loadMorePosts = async () => {
    if (isLoading.value || !nextPageUrl.value) return;

    isLoading.value = true;
    try {
        const response = await axios.get(nextPageUrl.value);
        allPosts.value = [...allPosts.value, ...response.data.data];
        nextPageUrl.value = response.data.next_page_url;
    } catch (error) {
        console.error('Error loading more posts:', error);
    } finally {
        isLoading.value = false;
    }
};

onMounted(() => {
    const observer = new IntersectionObserver((entries) => {
        if (entries[0].isIntersecting) {
            loadMorePosts();
        }
    }, {
        root: null,
        rootMargin: '100px',
        threshold: 0.1
    });

    if (loadMoreTrigger.value) {
        observer.observe(loadMoreTrigger.value);
    }
});
</script>

<template>
    <InstagramLayout title="Feed" :current-user="currentUser">
        <StoryRail :current-user="currentUser" />
        
        <div class="flex flex-col gap-2">
            <PostItem v-for="post in allPosts" :key="post.id" :post="post" />
            
            <!-- Infinite Scroll Trigger & Loading Indicator -->
            <div ref="loadMoreTrigger" class="h-10 flex items-center justify-center my-4">
                <div v-if="isLoading" class="animate-spin rounded-full h-6 w-6 border-b-2 border-gray-900 dark:border-white"></div>
            </div>
        </div>
    </InstagramLayout>
</template>
