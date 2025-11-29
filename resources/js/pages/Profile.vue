<script setup lang="ts">
import InstagramLayout from '@/layouts/InstagramLayout.vue';
import ProfileHeader from '@/components/ProfileHeader.vue';
import PostsGrid from '@/components/PostsGrid.vue';
import { ref } from 'vue';

const user = ref({
    username: 'johndoe',
    name: 'John Doe',
    avatar: 'https://ui-avatars.com/api/?name=John+Doe&background=random&size=150',
    bio: 'Web Developer | Coffee Enthusiast ☕\nLiving life one commit at a time 💻',
    website: 'https://johndoe.com',
    postsCount: 42,
    followersCount: 1234,
    followingCount: 567,
    isOwnProfile: true
});

const posts = ref([
    {
        id: 1,
        image: 'https://images.unsplash.com/photo-1472214103451-9374bd1c798e?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
        likes: 234,
        comments: 12
    },
    {
        id: 2,
        image: 'https://images.unsplash.com/photo-1519389950473-47ba0277781c?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
        likes: 156,
        comments: 8
    },
    {
        id: 3,
        image: 'https://images.unsplash.com/photo-1504609773096-104ff2c73ba4?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
        likes: 892,
        comments: 45
    },
    {
        id: 4,
        image: 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
        likes: 445,
        comments: 23
    },
    {
        id: 5,
        image: 'https://images.unsplash.com/photo-1469474968028-56623f02e42e?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
        likes: 678,
        comments: 34
    },
    {
        id: 6,
        image: 'https://images.unsplash.com/photo-1441974231531-c6227db76b6e?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80',
        likes: 321,
        comments: 19
    }
]);
</script>

<template>
    <InstagramLayout title="Profile">
        <div class="max-w-4xl mx-auto">
            <ProfileHeader :user="user" />
            <PostsGrid :posts="posts" />
        </div>
    </InstagramLayout>
</template>
