<script setup lang="ts">
import { ref, computed } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';
import InstagramLayout from '@/layouts/InstagramLayout.vue';
import AvatarUpload from '@/components/AvatarUpload.vue';
import { ArrowLeft, Loader2 } from 'lucide-vue-next';

const props = defineProps<{
    user: {
        id: number;
        username: string;
        name: string;
        email: string;
        avatar?: string | null;
        bio?: string | null;
        website?: string | null;
        gender?: string | null;
    };
}>();

const form = useForm({
    name: props.user.name,
    username: props.user.username,
    email: props.user.email,
    bio: props.user.bio || '',
    website: props.user.website || '',
    gender: props.user.gender || '',
    avatar: null as File | null,
});

const isSubmitting = ref(false);

const handleSubmit = () => {
    isSubmitting.value = true;
    
    form.post('/profile/update', {
        forceFormData: true,
        preserveScroll: true,
        onSuccess: () => {
            isSubmitting.value = false;
        },
        onError: () => {
            isSubmitting.value = false;
        },
    });
};

const goBack = () => {
    router.visit('/profile');
};
</script>

<template>
    <InstagramLayout title="Edit Profile">
        <div class="max-w-2xl mx-auto py-8 px-4">
            <!-- Header -->
            <div class="flex items-center gap-4 mb-8">
                <button 
                    @click="goBack"
                    class="p-2 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-full transition-colors"
                >
                    <ArrowLeft :size="24" />
                </button>
                <h1 class="text-2xl font-semibold">Edit Profile</h1>
            </div>

            <!-- Form -->
            <form @submit.prevent="handleSubmit" class="space-y-8">
                <!-- Avatar Upload -->
                <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-6">
                    <AvatarUpload 
                        :current-avatar="user.avatar" 
                        v-model="form.avatar"
                    />
                </div>

                <!-- Personal Information -->
                <div class="space-y-6">
                    <h2 class="text-lg font-semibold">Personal Information</h2>

                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium mb-2">
                            Full Name <span class="text-red-500">*</span>
                        </label>
                        <input
                            id="name"
                            v-model="form.name"
                            type="text"
                            class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                            :class="{ 'border-red-500': form.errors.name }"
                            placeholder="Enter your full name"
                        />
                        <p v-if="form.errors.name" class="mt-1.5 text-sm text-red-500">
                            {{ form.errors.name }}
                        </p>
                    </div>

                    <!-- Username -->
                    <div>
                        <label for="username" class="block text-sm font-medium mb-2">
                            Username <span class="text-red-500">*</span>
                        </label>
                        <input
                            id="username"
                            v-model="form.username"
                            type="text"
                            class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                            :class="{ 'border-red-500': form.errors.username }"
                            placeholder="username"
                        />
                        <p v-if="form.errors.username" class="mt-1.5 text-sm text-red-500">
                            {{ form.errors.username }}
                        </p>
                        <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400">
                            Letters, numbers, dashes and underscores only
                        </p>
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium mb-2">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input
                            id="email"
                            v-model="form.email"
                            type="email"
                            class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                            :class="{ 'border-red-500': form.errors.email }"
                            placeholder="your.email@example.com"
                        />
                        <p v-if="form.errors.email" class="mt-1.5 text-sm text-red-500">
                            {{ form.errors.email }}
                        </p>
                    </div>

                    <!-- Gender -->
                    <div>
                        <label for="gender" class="block text-sm font-medium mb-2">
                            Gender
                        </label>
                        <select
                            id="gender"
                            v-model="form.gender"
                            class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                            :class="{ 'border-red-500': form.errors.gender }"
                        >
                            <option value="">Prefer not to say</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                            <option value="prefer_not_to_say">Prefer not to say</option>
                        </select>
                        <p v-if="form.errors.gender" class="mt-1.5 text-sm text-red-500">
                            {{ form.errors.gender }}
                        </p>
                    </div>
                </div>

                <!-- Profile Details -->
                <div class="space-y-6">
                    <h2 class="text-lg font-semibold">Profile Details</h2>

                    <!-- Bio -->
                    <div>
                        <label for="bio" class="block text-sm font-medium mb-2">
                            Bio
                        </label>
                        <textarea
                            id="bio"
                            v-model="form.bio"
                            rows="4"
                            class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all resize-none"
                            :class="{ 'border-red-500': form.errors.bio }"
                            placeholder="Tell us about yourself..."
                            maxlength="500"
                        ></textarea>
                        <div class="flex justify-between mt-1.5">
                            <p v-if="form.errors.bio" class="text-sm text-red-500">
                                {{ form.errors.bio }}
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 ml-auto">
                                {{ form.bio?.length || 0 }}/500
                            </p>
                        </div>
                    </div>

                    <!-- Website -->
                    <div>
                        <label for="website" class="block text-sm font-medium mb-2">
                            Website
                        </label>
                        <input
                            id="website"
                            v-model="form.website"
                            type="url"
                            class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                            :class="{ 'border-red-500': form.errors.website }"
                            placeholder="https://example.com"
                        />
                        <p v-if="form.errors.website" class="mt-1.5 text-sm text-red-500">
                            {{ form.errors.website }}
                        </p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-3 pt-4 border-t border-gray-200 dark:border-gray-800">
                    <button
                        type="button"
                        @click="goBack"
                        class="flex-1 px-6 py-2.5 border border-gray-300 dark:border-gray-700 rounded-lg font-semibold hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors"
                        :disabled="isSubmitting"
                    >
                        Cancel
                    </button>
                    <button
                        type="submit"
                        class="flex-1 px-6 py-2.5 bg-blue-500 hover:bg-blue-600 text-white rounded-lg font-semibold transition-colors disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2"
                        :disabled="isSubmitting || form.processing"
                    >
                        <Loader2 v-if="isSubmitting || form.processing" :size="20" class="animate-spin" />
                        <span>{{ isSubmitting || form.processing ? 'Saving...' : 'Save Changes' }}</span>
                    </button>
                </div>
            </form>
        </div>
    </InstagramLayout>
</template>
