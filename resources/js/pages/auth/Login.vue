<script setup lang="ts">
import InstagramInput from '@/components/InstagramInput.vue';
import InstagramButton from '@/components/InstagramButton.vue';
import InstagramAuthLayout from '@/layouts/InstagramAuthLayout.vue';
import { register } from '@/routes';
import { store } from '@/routes/login';
import { request } from '@/routes/password';
import { Form, Link } from '@inertiajs/vue3';

defineProps<{
    status?: string;
    canResetPassword: boolean;
    canRegister: boolean;
}>();
</script>

<template>
    <InstagramAuthLayout title="Log in">
        <!-- Main Card -->
        <div class="bg-white dark:bg-black border border-gray-300 dark:border-gray-800 flex flex-col items-center p-8 pb-6 rounded-[1px]">
            <h1 class="font-['Grand_Hotel'] text-5xl mb-8 mt-2 dark:text-white">Instagram</h1>
            
            <div v-if="status" class="mb-4 text-center text-sm font-medium text-green-600">
                {{ status }}
            </div>

            <Form
                v-bind="store.form()"
                :reset-on-success="['password']"
                v-slot="{ errors, processing }"
                class="w-full flex flex-col gap-3"
            >
                <div class="flex flex-col gap-2">
                    <InstagramInput
                        name="email"
                        type="email"
                        required
                        autofocus
                        placeholder="Phone number, username, or email"
                    />
                    <div v-if="errors.email" class="text-red-500 text-xs">{{ errors.email }}</div>
                </div>

                <div class="flex flex-col gap-2">
                    <InstagramInput
                        name="password"
                        type="password"
                        required
                        placeholder="Password"
                    />
                    <div v-if="errors.password" class="text-red-500 text-xs">{{ errors.password }}</div>
                </div>

                <InstagramButton type="submit" :disabled="processing" class="mt-1">
                    Log in
                </InstagramButton>

                <div class="flex items-center gap-4 my-3 w-full">
                    <div class="h-[1px] bg-gray-300 dark:bg-gray-700 flex-1"></div>
                    <span class="text-xs font-semibold text-gray-500 uppercase">OR</span>
                    <div class="h-[1px] bg-gray-300 dark:bg-gray-700 flex-1"></div>
                </div>

                <div class="flex justify-center">
                    <button type="button" class="flex items-center gap-2 text-[#385185] font-semibold text-sm">
                        <span class="text-xs">Log in with Facebook</span>
                    </button>
                </div>

                <div class="flex justify-center mt-2" v-if="canResetPassword">
                    <Link :href="request()" class="text-xs text-[#00376b]">
                        Forgot password?
                    </Link>
                </div>
            </Form>
        </div>

        <!-- Sign up Card -->
        <div class="bg-white dark:bg-black border border-gray-300 dark:border-gray-800 p-5 text-center rounded-[1px]" v-if="canRegister">
            <p class="text-sm text-gray-800 dark:text-gray-200">
                Don't have an account? 
                <Link :href="register()" class="text-[#0095f6] font-semibold">Sign up</Link>
            </p>
        </div>

        <!-- Get the app -->
        <div class="text-center space-y-4">
            <p class="text-sm text-gray-800 dark:text-gray-200">Get the app.</p>
            <div class="flex justify-center gap-2">
                <div class="h-10 w-32 bg-black rounded border border-gray-700 flex items-center justify-center text-white text-xs">
                    <span class="font-semibold">Google Play</span>
                </div>
                <div class="h-10 w-32 bg-black rounded border border-gray-700 flex items-center justify-center text-white text-xs">
                    <span class="font-semibold">Microsoft</span>
                </div>
            </div>
        </div>
    </InstagramAuthLayout>
</template>

