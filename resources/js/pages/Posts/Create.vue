<script setup lang="ts">
import InstagramLayout from '@/layouts/InstagramLayout.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Image as ImageIcon, X, MapPin } from 'lucide-vue-next';

defineProps<{}>();

const form = useForm({
    caption: '',
    location: '',
    images: [] as File[],
});

const imagePreview = ref<string | null>(null);
const fileInput = ref<HTMLInputElement | null>(null);

const handleFileSelect = (event: Event) => {
    const target = event.target as HTMLInputElement;
    if (target.files && target.files.length > 0) {
        const file = target.files[0];
        form.images = [file]; // Currently handling single image
        
        // Create preview
        const reader = new FileReader();
        reader.onload = (e) => {
            imagePreview.value = e.target?.result as string;
        };
        reader.readAsDataURL(file);
    }
};

const triggerFileInput = () => {
    fileInput.value?.click();
};

const removeImage = () => {
    form.images = [];
    imagePreview.value = null;
    if (fileInput.value) {
        fileInput.value.value = '';
    }
};

const submit = () => {
    form.post('/posts', {
        forceFormData: true,
    });
};
</script>

<template>
    <InstagramLayout title="Create new post">
        <div class="max-w-2xl mx-auto bg-white dark:bg-black border border-gray-200 dark:border-gray-800 rounded-xl overflow-hidden mt-8">
            <div class="border-b border-gray-200 dark:border-gray-800 p-3 flex items-center justify-between">
                <h1 class="font-semibold text-center flex-1">Create new post</h1>
                <button 
                    v-if="imagePreview" 
                    @click="submit" 
                    class="text-blue-500 font-semibold text-sm hover:text-blue-700 disabled:opacity-50"
                    :disabled="form.processing"
                >
                    Share
                </button>
            </div>

            <div class="flex flex-col md:flex-row h-[600px]">
                <!-- Image Upload Area -->
                <div class="flex-1 bg-gray-50 dark:bg-gray-900 flex items-center justify-center relative border-r border-gray-200 dark:border-gray-800">
                    <div v-if="!imagePreview" class="text-center p-8">
                        <ImageIcon :size="64" class="mx-auto text-gray-400 mb-4" />
                        <p class="text-xl mb-6">Drag photos and videos here</p>
                        <button 
                            @click="triggerFileInput"
                            class="bg-[#0095f6] hover:bg-[#1877f2] text-white font-semibold py-1.5 px-4 rounded text-sm transition-colors"
                        >
                            Select from computer
                        </button>
                        <input 
                            ref="fileInput"
                            type="file" 
                            accept="image/*" 
                            class="hidden" 
                            @change="handleFileSelect"
                        />
                        <div v-if="form.errors.images" class="text-red-500 text-sm mt-4">
                            {{ form.errors.images }}
                        </div>
                    </div>

                    <div v-else class="relative w-full h-full bg-black flex items-center justify-center">
                        <img :src="imagePreview" class="max-w-full max-h-full object-contain" />
                        <button 
                            @click="removeImage"
                            class="absolute top-4 right-4 bg-black/50 text-white p-1 rounded-full hover:bg-black/70 transition-colors"
                        >
                            <X :size="20" />
                        </button>
                    </div>
                </div>

                <!-- Caption Area -->
                <div v-if="imagePreview" class="w-full md:w-[340px] flex flex-col bg-white dark:bg-black">
                    <div class="p-4 flex items-center gap-3">
                        <div class="w-7 h-7 rounded-full bg-gray-200 overflow-hidden">
                            <img 
                                :src="$page.props.currentUser?.avatar ? ($page.props.currentUser.avatar.startsWith('http') ? $page.props.currentUser.avatar : `/storage/${$page.props.currentUser.avatar}`) : `https://ui-avatars.com/api/?name=${$page.props.currentUser?.username}&background=random`" 
                                class="w-full h-full object-cover"
                            />
                        </div>
                        <span class="font-semibold text-sm">{{ $page.props.currentUser?.username }}</span>
                    </div>
                    
                    <div class="px-4 flex-1 flex flex-col">
                        <textarea 
                            v-model="form.caption"
                            class="w-full flex-1 border-none resize-none focus:ring-0 p-0 text-sm bg-transparent"
                            placeholder="Write a caption..."
                            maxlength="2200"
                        ></textarea>

                        <!-- Location Input -->
                        <div class="border-t border-gray-200 dark:border-gray-800 py-3">
                            <div class="flex items-center justify-between">
                                <input 
                                    v-model="form.location"
                                    type="text" 
                                    placeholder="Add location" 
                                    class="w-full border-none bg-transparent p-0 text-sm focus:ring-0 placeholder-gray-500"
                                />
                                <MapPin :size="16" class="text-gray-400" />
                            </div>
                        </div>
                    </div>

                    <div class="p-4 border-t border-gray-200 dark:border-gray-800 flex justify-between items-center text-gray-400 text-xs">
                        <span v-if="form.errors.caption" class="text-red-500">{{ form.errors.caption }}</span>
                        <span class="ml-auto">{{ form.caption.length }}/2,200</span>
                    </div>
                </div>
            </div>
        </div>
    </InstagramLayout>
</template>
