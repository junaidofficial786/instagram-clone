<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Home, Search, Compass, Clapperboard, MessageCircle, Heart, PlusSquare, Menu } from 'lucide-vue-next';

const navItems = [
    { name: 'Home', icon: Home, href: '/feed', active: true },
    { name: 'Search', icon: Search, href: '#' },
    { name: 'Explore', icon: Compass, href: '#' },
    { name: 'Reels', icon: Clapperboard, href: '#' },
    { name: 'Messages', icon: MessageCircle, href: '#' },
    { name: 'Notifications', icon: Heart, href: '#' },
    { name: 'Create', icon: PlusSquare, href: '#' },
    { name: 'Profile', icon: null, href: '#', isProfile: true }, // Placeholder for profile image
];
</script>

<template>
    <div class="flex flex-col h-full px-3 pb-5 pt-2">
        <!-- Logo -->
        <div class="h-[73px] mb-5 px-3 flex items-center">
            <Link href="/feed" class="hidden xl:block">
                <h1 class="font-['Grand_Hotel'] text-3xl">Instagram</h1>
            </Link>
            <Link href="/feed" class="xl:hidden block p-3 group">
                 <svg aria-label="Instagram" class="_ab6-" color="currentColor" fill="currentColor" height="24" role="img" viewBox="0 0 24 24" width="24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"></path></svg>
            </Link>
        </div>

        <!-- Navigation Links -->
        <div class="flex-1">
            <template v-for="item in navItems" :key="item.name">
                <Link
                    :href="item.href"
                    class="flex items-center gap-4 p-3 my-1 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-900 transition-colors group"
                    :class="{ 'font-bold': item.active }"
                >
                    <div class="relative group-hover:scale-105 transition-transform duration-200">
                        <component v-if="item.icon" :is="item.icon" :size="24" :stroke-width="item.active ? 3 : 2" />
                        <div v-else-if="item.isProfile" class="w-6 h-6 rounded-full bg-gray-300 overflow-hidden">
                             <!-- Placeholder for profile image -->
                             <img src="https://ui-avatars.com/api/?name=User&background=random" alt="Profile" class="w-full h-full object-cover" />
                        </div>
                    </div>
                    <span class="hidden xl:block text-base">{{ item.name }}</span>
                </Link>
            </template>
        </div>

        <!-- More Menu -->
        <div class="mt-auto">
            <button class="flex items-center gap-4 p-3 w-full rounded-lg hover:bg-gray-100 dark:hover:bg-gray-900 transition-colors group">
                <Menu :size="24" />
                <span class="hidden xl:block text-base">More</span>
            </button>
        </div>
    </div>
</template>
