<script setup lang="ts">
import { computed } from 'vue';

const props = defineProps<{
    user: {
        username: string;
        name?: string;
        avatar?: string | null;
    };
    size?: 'sm' | 'md' | 'lg' | 'xl';
}>();

const initials = computed(() => {
    const name = props.user.name || props.user.username;
    return name
        .split(' ')
        .map((n) => n[0])
        .join('')
        .toUpperCase()
        .slice(0, 2);
});

const sizeClasses = computed(() => {
    switch (props.size) {
        case 'sm':
            return 'w-6 h-6 text-xs';
        case 'lg':
            return 'w-10 h-10 text-sm';
        case 'xl':
            return 'w-14 h-14 text-base';
        case 'md':
        default:
            return 'w-8 h-8 text-xs';
    }
});
</script>

<template>
    <div
        class="rounded-full overflow-hidden flex items-center justify-center bg-gray-200 dark:bg-gray-800 text-gray-600 dark:text-gray-300 font-semibold ring-1 ring-gray-200 dark:ring-gray-700"
        :class="sizeClasses"
    >
        <img
            v-if="user.avatar"
            :src="user.avatar.startsWith('http') ? user.avatar : `/storage/${user.avatar}`"
            :alt="user.username"
            class="w-full h-full object-cover"
        />
        <span v-else>{{ initials }}</span>
    </div>
</template>
