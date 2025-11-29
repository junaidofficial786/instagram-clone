<script setup lang="ts">
import { ref } from 'vue';

const stories = ref([
    { id: 1, username: 'your_story', image: 'https://ui-avatars.com/api/?name=Me&background=random', isUser: true },
    { id: 2, username: 'user_one', image: 'https://ui-avatars.com/api/?name=User+One&background=random', hasStory: true },
    { id: 3, username: 'user_two', image: 'https://ui-avatars.com/api/?name=User+Two&background=random', hasStory: true },
    { id: 4, username: 'user_three', image: 'https://ui-avatars.com/api/?name=User+Three&background=random', hasStory: true },
    { id: 5, username: 'user_four', image: 'https://ui-avatars.com/api/?name=User+Four&background=random', hasStory: true },
    { id: 6, username: 'user_five', image: 'https://ui-avatars.com/api/?name=User+Five&background=random', hasStory: true },
    { id: 7, username: 'user_six', image: 'https://ui-avatars.com/api/?name=User+Six&background=random', hasStory: true },
    { id: 8, username: 'user_seven', image: 'https://ui-avatars.com/api/?name=User+Seven&background=random', hasStory: true },
]);
</script>

<template>
    <div class="flex gap-4 overflow-x-auto pb-4 mb-4 scrollbar-hide">
        <div v-for="story in stories" :key="story.id" class="flex flex-col items-center gap-1 min-w-[66px] cursor-pointer">
            <div class="relative w-[66px] h-[66px]">
                <div 
                    class="w-full h-full rounded-full p-[2px]"
                    :class="story.hasStory ? 'bg-gradient-to-tr from-yellow-400 via-red-500 to-purple-500' : (story.isUser ? '' : 'bg-gray-200')"
                >
                    <div class="w-full h-full rounded-full bg-white dark:bg-black p-[2px] overflow-hidden">
                        <img :src="story.image" :alt="story.username" class="w-full h-full object-cover rounded-full" />
                    </div>
                </div>
                <div v-if="story.isUser" class="absolute bottom-0 right-0 bg-blue-500 text-white rounded-full w-5 h-5 flex items-center justify-center border-2 border-white dark:border-black">
                    <span class="text-xs font-bold">+</span>
                </div>
            </div>
            <span class="text-xs truncate w-full text-center">{{ story.username }}</span>
        </div>
    </div>
</template>

<style scoped>
.scrollbar-hide::-webkit-scrollbar {
    display: none;
}
.scrollbar-hide {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
</style>
