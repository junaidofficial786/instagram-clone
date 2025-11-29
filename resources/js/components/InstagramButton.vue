<script setup lang="ts">
defineProps<{
    type?: 'button' | 'submit' | 'reset';
    disabled?: boolean;
}>();
</script>

<template>
    <button
        :type="type || 'button'"
        :disabled="disabled"
        class="flex justify-center items-center w-full bg-[#0095f6] hover:bg-[#1877f2] text-white font-semibold py-1.5 px-4 rounded-[4px] text-sm transition-colors disabled:opacity-70 disabled:cursor-not-allowed"
    >
        <slot />
    </button>
</template>
