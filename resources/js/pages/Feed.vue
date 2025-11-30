<script setup lang="ts">
import InstagramLayout from '@/Layouts/InstagramLayout.vue';
import StoryRail from '@/Components/StoryRail.vue';
import PostItem from '@/Components/PostItem.vue';
import { ref } from 'vue';

const props = defineProps<{
    currentUser: {
        username: string;
        name: string;
        avatar?: string | null;
    };
    posts: {
        data: Array<{
            id: number;
            user: {
                username: string;
                name: string;
                avatar?: string | null;
            };
            caption: string;
            created_at: string;
            images: Array<{
                url: string;
            }>;
            comments: Array<any>;
            likes_count?: number;
        }>;
    };
}>();
</script>

<template>
    <InstagramLayout title="Feed" :current-user="currentUser">
        <StoryRail :current-user="currentUser" />
        
        <div class="flex flex-col gap-2">
            <PostItem v-for="post in posts.data" :key="post.id" :post="post" />
        </div>
    </InstagramLayout>
</template>
