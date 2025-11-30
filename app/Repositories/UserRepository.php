<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    /**
     * Find user by ID
     */
    public function findById(int $id): ?User
    {
        return User::find($id);
    }

    /**
     * Update user profile
     */
    public function updateProfile(User $user, array $data): User
    {
        $user->update($data);
        return $user->fresh();
    }

    /**
     * Update user avatar
     */
    public function updateAvatar(User $user, string $avatarPath): User
    {
        $user->update(['avatar' => $avatarPath]);
        return $user->fresh();
    }

    /**
     * Delete user avatar
     */
    public function deleteAvatar(User $user): User
    {
        $user->update(['avatar' => null]);
        return $user->fresh();
    }

    /**
     * Check if username exists for another user
     */
    public function usernameExistsForOtherUser(string $username, int $excludeUserId): bool
    {
        return User::where('username', $username)
            ->where('id', '!=', $excludeUserId)
            ->exists();
    }

    /**
     * Check if email exists for another user
     */
    public function emailExistsForOtherUser(string $email, int $excludeUserId): bool
    {
        return User::where('email', $email)
            ->where('id', '!=', $excludeUserId)
            ->exists();
    }
}
