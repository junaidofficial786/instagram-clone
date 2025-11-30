<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 1000 users with realistic data
        for ($i = 1; $i <= 1000; $i++) {
            $firstName = fake()->firstName();
            $lastName = fake()->lastName();

            User::create([
                'name' => $firstName.' '.$lastName,
                'username' => strtolower($firstName.$lastName.rand(1, 999)),
                'email' => strtolower($firstName.'.'.$lastName.rand(1, 999).'@'.fake()->freeEmailDomain()),
                'email_verified_at' => now(),
                'password' => Hash::make('password'), // Default password for all users
                'avatar' => null, // Keeping null as requested
                'bio' => rand(1, 10) > 3 ? fake()->sentence(rand(5, 15)) : null,
                'website' => rand(1, 10) > 5 ? 'https://'.fake()->domainName() : null,
                'gender' => fake()->randomElement(['male', 'female', 'other', 'prefer_not_to_say', null]),
                'is_private' => fake()->boolean(20), // 20% chance of private account
                'created_at' => fake()->dateTimeBetween('-2 years', 'now'),
            ]);

            // Display progress
            if ($i % 100 == 0) {
                $this->command->info("Created {$i} users...");
            }
        }

        $this->command->info('Successfully created 1000 users!');
    }
}
