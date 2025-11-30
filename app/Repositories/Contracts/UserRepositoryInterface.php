<?php

namespace App\Repositories\Contracts;

use App\Models\User;
use Illuminate\Http\UploadedFile;

interface UserRepositoryInterface
{
    /**
     * Find user by ID
     */
    public function findById(int $id): ?User;

    /**
     * Update user profile
     */
    public function updateProfile(User $user, array $data): User;

    /**
     * Update user avatar
     */
    public function updateAvatar(User $user, string $avatarPath): User;

    /**
     * Delete user avatar
     */
    public function deleteAvatar(User $user): User;

    /**
     * Check if username exists for another user
     */
    public function usernameExistsForOtherUser(string $username, int $excludeUserId): bool;

    /**
     * Check if email exists for another user
     */
    public function emailExistsForOtherUser(string $email, int $excludeUserId): bool;
}
