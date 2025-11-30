<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Starting to create comments for posts...');
        
        // Get all post IDs
        $posts = Post::pluck('id')->toArray();
        
        if (empty($posts)) {
            $this->command->error('No posts found! Please run PostSeeder first.');
            return;
        }

        // Get all user IDs
        $userIds = User::pluck('id')->toArray();

        if (empty($userIds)) {
            $this->command->error('No users found! Please run UserSeeder first.');
            return;
        }

        // Sample comment texts for variety
        $commentTexts = [
            'Nice!',
            'Amazing! 😍',
            'Beautiful!',
            'Love this! ❤️',
            'Wow! 🔥',
            'So cool!',
            'Great shot! 📸',
            'Stunning!',
            'This is awesome!',
            'Perfect! 👌',
            'Incredible!',
            'Love it!',
            'Beautiful photo!',
            'This is so good! 😊',
            'Absolutely love this!',
            'Goals! 💯',
            'Can\'t stop looking at this!',
            'This made my day! ☀️',
            'Amazing work!',
            'Keep it up! 🙌',
            'Gorgeous! ✨',
            'Breathtaking!',
            'You\'re so talented!',
            'This deserves more likes!',
            'What a view! 🌟',
        ];

        $totalComments = 0;

        // For each post, create random number of comments (2-100)
        foreach ($posts as $postId) {
            $numberOfComments = rand(2, 100);
            
            for ($i = 0; $i < $numberOfComments; $i++) {
                try {
                    // Randomly decide if this is a reply (parent comment)
                    $isReply = $i > 0 && rand(1, 10) > 7; // 30% chance of being a reply
                    $parentId = null;

                    if ($isReply) {
                        // Get a random existing comment from this post to reply to
                        $existingComment = Comment::where('post_id', $postId)->inRandomOrder()->first();
                        if ($existingComment) {
                            $parentId = $existingComment->id;
                        }
                    }

                    Comment::create([
                        'user_id' => fake()->randomElement($userIds),
                        'post_id' => $postId,
                        'parent_id' => $parentId,
                        'content' => fake()->randomElement($commentTexts) . (rand(1, 10) > 7 ? ' ' . fake()->sentence(rand(3, 8)) : ''),
                        'created_at' => fake()->dateTimeBetween('-6 months', 'now'),
                    ]);

                    $totalComments++;

                } catch (\Exception $e) {
                    $this->command->error("Error creating comment: " . $e->getMessage());
                }
            }

            // Display progress
            if (array_search($postId, $posts) % 50 == 0) {
                $this->command->info("Processed " . array_search($postId, $posts) . " posts, created {$totalComments} comments so far...");
            }
        }

        $this->command->info("Successfully created {$totalComments} comments for " . count($posts) . " posts!");
    }
}
