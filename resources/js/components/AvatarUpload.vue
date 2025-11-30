<script setup lang="ts">
import { ref, computed } from 'vue';
import { Camera, X } from 'lucide-vue-next';

const props = defineProps<{
    currentAvatar?: string | null;
    modelValue?: File | null;
}>();

const emit = defineEmits<{
    'update:modelValue': [value: File | null];
}>();

const fileInput = ref<HTMLInputElement | null>(null);
const previewUrl = ref<string | null>(props.currentAvatar || null);
const isDragging = ref(false);

const displayAvatar = computed(() => {
    return previewUrl.value || props.currentAvatar || 'https://ui-avatars.com/api/?name=User&background=random&size=200';
});

const handleFileSelect = (event: Event) => {
    const target = event.target as HTMLInputElement;
    if (target.files && target.files[0]) {
        processFile(target.files[0]);
    }
};

const handleDrop = (event: DragEvent) => {
    isDragging.value = false;
    if (event.dataTransfer?.files && event.dataTransfer.files[0]) {
        processFile(event.dataTransfer.files[0]);
    }
};

const processFile = (file: File) => {
    // Validate file type
    if (!file.type.startsWith('image/')) {
        alert('Please select an image file');
        return;
    }

    // Validate file size (2MB)
    if (file.size > 2 * 1024 * 1024) {
        alert('Image size must be less than 2MB');
        return;
    }

    // Create preview URL
    const reader = new FileReader();
    reader.onload = (e) => {
        previewUrl.value = e.target?.result as string;
    };
    reader.readAsDataURL(file);

    // Emit the file
    emit('update:modelValue', file);
};

const openFileDialog = () => {
    fileInput.value?.click();
};

const removeAvatar = () => {
    previewUrl.value = null;
    emit('update:modelValue', null);
    if (fileInput.value) {
        fileInput.value.value = '';
    }
};

const handleDragOver = (event: DragEvent) => {
    event.preventDefault();
    isDragging.value = true;
};

const handleDragLeave = () => {
    isDragging.value = false;
};
</script>

<template>
    <div class="flex flex-col items-center gap-4">
        <!-- Avatar Preview -->
        <div 
            class="relative group cursor-pointer"
            @click="openFileDialog"
            @drop.prevent="handleDrop"
            @dragover.prevent="handleDragOver"
            @dragleave="handleDragLeave"
        >
            <div 
                class="w-32 h-32 rounded-full overflow-hidden border-4 transition-all"
                :class="isDragging ? 'border-blue-500 scale-105' : 'border-gray-200 dark:border-gray-700'"
            >
                <img 
                    :src="displayAvatar" 
                    alt="Profile Picture"
                    class="w-full h-full object-cover"
                />
            </div>

            <!-- Overlay on hover -->
            <div class="absolute inset-0 bg-black bg-opacity-50 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                <div class="text-white text-center">
                    <Camera :size="32" class="mx-auto mb-1" />
                    <span class="text-xs font-semibold">Change Photo</span>
                </div>
            </div>

            <!-- Remove button -->
            <button
                v-if="previewUrl"
                type="button"
                @click.stop="removeAvatar"
                class="absolute -top-2 -right-2 bg-red-500 hover:bg-red-600 text-white rounded-full p-1.5 transition-colors shadow-lg"
            >
                <X :size="16" />
            </button>
        </div>

        <!-- File Input (Hidden) -->
        <input
            ref="fileInput"
            type="file"
            accept="image/jpeg,image/jpg,image/png"
            class="hidden"
            @change="handleFileSelect"
        />

        <!-- Instructions -->
        <p class="text-sm text-gray-500 dark:text-gray-400 text-center">
            Click to upload or drag and drop<br>
            JPG, JPEG, PNG (max 2MB)
        </p>
    </div>
</template>
