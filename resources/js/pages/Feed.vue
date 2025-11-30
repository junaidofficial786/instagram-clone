<script setup lang="ts">
import InstagramLayout from '@/Layouts/InstagramLayout.vue';
import StoryRail from '@/Components/StoryRail.vue';
import PostItem from '@/Components/PostItem.vue';
import { ref } from 'vue';

defineProps<{
    currentUser: {
        username: string;
        name: string;
        avatar?: string | null;
    };
}>();

const posts = ref([
    {
        id: 1,
        username: 'nature_lover',
        userImage: 'https://ui-avatars.com/api/?name=Nature+Lover&background=random',
        image: 'https://images.unsplash.com/photo-1472214103451-9374bd1c798e?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80',
        likes: 1234,
        caption: 'Beautiful sunset!',
        time: '2h',
        comments: 45
    },
    {
        id: 2,
        username: 'tech_guru',
        userImage: 'https://ui-avatars.com/api/?name=Tech+Guru&background=random',
        image: 'https://images.unsplash.com/photo-1519389950473-47ba0277781c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80',
        likes: 856,
        caption: 'Coding setup for the day 💻',
        time: '5h',
        comments: 23
    },
    {
        id: 3,
        username: 'travel_addict',
        userImage: 'https://ui-avatars.com/api/?name=Travel+Addict&background=random',
        image: 'https://images.unsplash.com/photo-1504609773096-104ff2c73ba4?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80',
        likes: 2451,
        caption: 'Missing this place...',
        time: '1d',
        comments: 112
    }
]);
</script>

<template>
    <InstagramLayout title="Feed" :current-user="currentUser">
        <StoryRail :current-user="currentUser" />
        
        <div class="flex flex-col gap-2">
            <PostItem v-for="post in posts" :key="post.id" :post="post" />
        </div>
    </InstagramLayout>
</template>
