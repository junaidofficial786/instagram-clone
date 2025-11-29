<script setup lang="ts">
import { onMounted, ref } from 'vue';

const model = defineModel<string>();

const input = ref<HTMLInputElement | null>(null);

onMounted(() => {
    if (input.value?.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value?.focus() });
</script>

<template>
    <input
        class="w-full bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-700 rounded-[3px] px-2 py-[9px] text-xs focus:ring-0 focus:border-gray-400 dark:focus:border-gray-600 dark:text-white placeholder-gray-500 dark:placeholder-gray-400"
        v-model="model"
        ref="input"
    />
</template>
