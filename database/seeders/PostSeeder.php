<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use App\Models\Image;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Starting to create 1000 posts with images...');
        
        // Get all user IDs
        $userIds = User::pluck('id')->toArray();
        
        if (empty($userIds)) {
            $this->command->error('No users found! Please run UserSeeder first.');
            return;
        }

        // Create storage directory if it doesn't exist
        if (!Storage::disk('public')->exists('posts')) {
            Storage::disk('public')->makeDirectory('posts');
        }

        // Placeholder image URLs from various sources
        $placeholderUrls = [
            'https://picsum.photos/800/600?random=',
            'https://source.unsplash.com/800x600/?nature,',
            'https://source.unsplash.com/800x600/?city,',
            'https://source.unsplash.com/800x600/?people,',
            'https://source.unsplash.com/800x600/?food,',
            'https://source.unsplash.com/800x600/?travel,',
            'https://source.unsplash.com/800x600/?technology,',
            'https://source.unsplash.com/800x600/?art,',
        ];

        for ($i = 1; $i <= 1000; $i++) {
            try {
                // Create post
                $post = Post::create([
                    'user_id' => fake()->randomElement($userIds),
                    'caption' => rand(1, 10) > 2 ? fake()->sentence(rand(5, 20)) . ' ' . fake()->randomElement(['#instagram', '#photo', '#love', '#beautiful', '#instagood', '#photooftheday', '']) : null,
                    'location' => rand(1, 10) > 5 ? fake()->city() . ', ' . fake()->country() : null,
                    'hide_likes' => fake()->boolean(5),
                    'hide_comments' => fake()->boolean(5),
                    'created_at' => fake()->dateTimeBetween('-1 year', 'now'),
                ]);

                // Download and save image locally
                $randomSeed = $i . time();
                $imageUrl = fake()->randomElement($placeholderUrls) . $randomSeed;
                
                try {
                    // Download image
                    $response = Http::timeout(10)->get($imageUrl);
                    
                    if ($response->successful()) {
                        // Generate unique filename
                        $filename = 'post_' . $post->id . '_' . time() . '_' . rand(1000, 9999) . '.jpg';
                        $path = 'posts/' . $filename;
                        
                        // Save image to storage
                        Storage::disk('public')->put($path, $response->body());
                        
                        // Create image record
                        Image::create([
                            'url' => $path,
                            'imageable_id' => $post->id,
                            'imageable_type' => Post::class,
                            'type' => 'image',
                            'order' => 0,
                        ]);
                    } else {
                        // Fallback: just save the URL without downloading
                        Image::create([
                            'url' => $imageUrl,
                            'imageable_id' => $post->id,
                            'imageable_type' => Post::class,
                            'type' => 'image',
                            'order' => 0,
                        ]);
                    }
                } catch (\Exception $e) {
                    // If download fails, save the URL directly
                    Image::create([
                        'url' => $imageUrl,
                        'imageable_id' => $post->id,
                        'imageable_type' => Post::class,
                        'type' => 'image',
                        'order' => 0,
                    ]);
                }

                // Display progress
                if ($i % 50 == 0) {
                    $this->command->info("Created {$i} posts with images...");
                }

            } catch (\Exception $e) {
                $this->command->error("Error creating post {$i}: " . $e->getMessage());
            }
        }

        $this->command->info('Successfully created 1000 posts with images!');
    }
}
