<script setup lang="ts">
import InstagramInput from '@/components/InstagramInput.vue';
import InstagramButton from '@/components/InstagramButton.vue';
import InstagramAuthLayout from '@/layouts/InstagramAuthLayout.vue';
import { login } from '@/routes';
import { store } from '@/routes/register';
import { Form, Link } from '@inertiajs/vue3';
</script>

<template>
    <InstagramAuthLayout title="Register">
        <!-- Main Card -->
        <div class="bg-white dark:bg-black border border-gray-300 dark:border-gray-800 flex flex-col items-center p-8 pb-6 rounded-[1px]">
            <h1 class="font-['Grand_Hotel'] text-5xl mb-4 mt-2 dark:text-white">Instagram</h1>
            
            <h2 class="text-gray-500 font-semibold text-center mb-4 text-[17px] leading-5">
                Sign up to see photos and videos from your friends.
            </h2>

            <InstagramButton class="mb-3">
                <span class="flex items-center gap-2">Log in with Facebook</span>
            </InstagramButton>

            <div class="flex items-center gap-4 my-3 w-full">
                <div class="h-[1px] bg-gray-300 dark:bg-gray-700 flex-1"></div>
                <span class="text-xs font-semibold text-gray-500 uppercase">OR</span>
                <div class="h-[1px] bg-gray-300 dark:bg-gray-700 flex-1"></div>
            </div>

            <Form
                v-bind="store.form()"
                :reset-on-success="['password', 'password_confirmation']"
                v-slot="{ errors, processing }"
                class="w-full flex flex-col gap-2"
            >
                <div class="flex flex-col gap-1">
                    <InstagramInput
                        name="email"
                        type="email"
                        required
                        placeholder="Mobile Number or Email"
                    />
                    <div v-if="errors.email" class="text-red-500 text-xs">{{ errors.email }}</div>
                </div>

                <div class="flex flex-col gap-1">
                    <InstagramInput
                        name="name"
                        type="text"
                        required
                        placeholder="Full Name"
                    />
                    <div v-if="errors.name" class="text-red-500 text-xs">{{ errors.name }}</div>
                </div>

                <div class="flex flex-col gap-1">
                    <InstagramInput
                        name="password"
                        type="password"
                        required
                        placeholder="Password"
                    />
                    <div v-if="errors.password" class="text-red-500 text-xs">{{ errors.password }}</div>
                </div>

                <div class="flex flex-col gap-1">
                    <InstagramInput
                        name="password_confirmation"
                        type="password"
                        required
                        placeholder="Confirm Password"
                    />
                    <div v-if="errors.password_confirmation" class="text-red-500 text-xs">{{ errors.password_confirmation }}</div>
                </div>

                <p class="text-xs text-gray-500 text-center my-2">
                    People who use our service may have uploaded your contact information to Instagram. <a href="#" class="font-semibold">Learn More</a>
                </p>
                
                <p class="text-xs text-gray-500 text-center mb-4">
                    By signing up, you agree to our <a href="#" class="font-semibold">Terms</a> , <a href="#" class="font-semibold">Privacy Policy</a> and <a href="#" class="font-semibold">Cookies Policy</a> .
                </p>

                <InstagramButton type="submit" :disabled="processing">
                    Sign up
                </InstagramButton>
            </Form>
        </div>

        <!-- Log in Card -->
        <div class="bg-white dark:bg-black border border-gray-300 dark:border-gray-800 p-5 text-center rounded-[1px]">
            <p class="text-sm text-gray-800 dark:text-gray-200">
                Have an account? 
                <Link :href="login()" class="text-[#0095f6] font-semibold">Log in</Link>
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

