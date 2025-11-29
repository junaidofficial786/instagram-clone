<script setup lang="ts">
import InstagramInput from '@/components/InstagramInput.vue';
import InstagramButton from '@/components/InstagramButton.vue';
import InstagramAuthLayout from '@/layouts/InstagramAuthLayout.vue';
import { login, register } from '@/routes';
import { email } from '@/routes/password';
import { Form, Link } from '@inertiajs/vue3';

defineProps<{
    status?: string;
}>();
</script>

<template>
    <InstagramAuthLayout title="Forgot password">
        <!-- Main Card -->
        <div class="bg-white dark:bg-black border border-gray-300 dark:border-gray-800 flex flex-col items-center p-8 pb-6 rounded-[1px]">
            <div class="flex justify-center mb-4">
                <div class="w-24 h-24 border-2 border-black dark:border-white rounded-full flex items-center justify-center">
                    <svg aria-label="Lock icon" class="_ab6-" color="currentColor" fill="currentColor" height="50" role="img" viewBox="0 0 96 96" width="50"><circle cx="48" cy="48" fill="none" r="47" stroke="currentColor" stroke-miterlimit="10" stroke-width="2"></circle><path d="M66.276 43.988h-2.52v-6.006c0-8.68-7.07-15.75-15.75-15.75s-15.75 7.07-15.75 15.75v6.006h-2.52c-2.485 0-4.5 2.015-4.5 4.5v19.5c0 2.485 2.015 4.5 4.5 4.5h36.54c2.485 0 4.5-2.015 4.5-4.5v-19.5c0-2.485-2.015-4.5-4.5-4.5zm-29.02-6.006c0-5.923 4.827-10.75 10.75-10.75s10.75 4.827 10.75 10.75v6.006h-21.5v-6.006zm28.52 24c0 .27-.23.5-.5.5h-36.54c-.27 0-.5-.23-.5-.5v-19.5c0-.27.23-.5.5-.5h36.54c.27 0 .5.23.5.5v19.5z"></path></svg>
                </div>
            </div>

            <h4 class="font-semibold text-base mb-2 dark:text-white">Trouble logging in?</h4>
            <p class="text-sm text-gray-500 text-center mb-6">
                Enter your email, phone, or username and we'll send you a link to get back into your account.
            </p>

            <div v-if="status" class="mb-4 text-center text-sm font-medium text-green-600">
                {{ status }}
            </div>

            <Form v-bind="email.form()" v-slot="{ errors, processing }" class="w-full flex flex-col gap-3">
                <div class="flex flex-col gap-1">
                    <InstagramInput
                        name="email"
                        type="email"
                        required
                        autofocus
                        placeholder="Email, Phone, or Username"
                    />
                    <div v-if="errors.email" class="text-red-500 text-xs">{{ errors.email }}</div>
                </div>

                <InstagramButton type="submit" :disabled="processing">
                    Send Login Link
                </InstagramButton>
            </Form>

            <div class="flex items-center gap-4 my-4 w-full">
                <div class="h-[1px] bg-gray-300 dark:bg-gray-700 flex-1"></div>
                <span class="text-xs font-semibold text-gray-500 uppercase">OR</span>
                <div class="h-[1px] bg-gray-300 dark:bg-gray-700 flex-1"></div>
            </div>

            <Link :href="register()" class="text-sm font-semibold text-gray-900 dark:text-white hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                Create New Account
            </Link>
        </div>

        <!-- Back to Login -->
        <div class="bg-white dark:bg-black border border-gray-300 dark:border-gray-800 p-4 text-center rounded-[1px] w-full mt-4">
            <Link :href="login()" class="text-sm font-semibold text-gray-900 dark:text-white hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                Back to Login
            </Link>
        </div>
    </InstagramAuthLayout>
</template>

