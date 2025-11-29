<script setup lang="ts">
import InstagramInput from '@/components/InstagramInput.vue';
import InstagramButton from '@/components/InstagramButton.vue';
import InstagramAuthLayout from '@/layouts/InstagramAuthLayout.vue';
import { update } from '@/routes/password';
import { Form, Head } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps<{
    token: string;
    email: string;
}>();

const inputEmail = ref(props.email);
</script>

<template>
    <InstagramAuthLayout title="Reset password">
        <!-- Main Card -->
        <div class="bg-white dark:bg-black border border-gray-300 dark:border-gray-800 flex flex-col items-center p-8 pb-6 rounded-[1px]">
            <h1 class="font-['Grand_Hotel'] text-5xl mb-8 mt-2 dark:text-white">Instagram</h1>
            
            <h4 class="font-semibold text-base mb-2 dark:text-white">Create A Strong Password</h4>
            <p class="text-sm text-gray-500 text-center mb-6">
                Your password must be at least 6 characters and should include a combination of numbers, letters and special characters.
            </p>

            <Form
                v-bind="update.form()"
                :transform="(data) => ({ ...data, token, email })"
                :reset-on-success="['password', 'password_confirmation']"
                v-slot="{ errors, processing }"
                class="w-full flex flex-col gap-3"
            >
                <div class="flex flex-col gap-1">
                    <InstagramInput
                        name="email"
                        type="email"
                        v-model="inputEmail"
                        readonly
                        placeholder="Email"
                        class="bg-gray-100 dark:bg-gray-800 text-gray-500"
                    />
                    <div v-if="errors.email" class="text-red-500 text-xs">{{ errors.email }}</div>
                </div>

                <div class="flex flex-col gap-1">
                    <InstagramInput
                        name="password"
                        type="password"
                        required
                        autofocus
                        placeholder="New Password"
                    />
                    <div v-if="errors.password" class="text-red-500 text-xs">{{ errors.password }}</div>
                </div>

                <div class="flex flex-col gap-1">
                    <InstagramInput
                        name="password_confirmation"
                        type="password"
                        required
                        placeholder="New Password Confirmation"
                    />
                    <div v-if="errors.password_confirmation" class="text-red-500 text-xs">{{ errors.password_confirmation }}</div>
                </div>

                <InstagramButton type="submit" :disabled="processing">
                    Reset Password
                </InstagramButton>
            </Form>
        </div>
    </InstagramAuthLayout>
</template>

