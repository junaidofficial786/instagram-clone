<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfileService
{
    public function __construct(
        protected UserRepositoryInterface $userRepository
    ) {}

    /**
     * Update user profile
     */
    public function updateProfile(User $user, array $data): User
    {
        // Extract avatar from data if present
        $avatar = $data['avatar'] ?? null;
        unset($data['avatar']);

        // Update profile data
        $updatedUser = $this->userRepository->updateProfile($user, $data);

        // Handle avatar upload if provided
        if ($avatar instanceof UploadedFile) {
            $this->updateAvatar($updatedUser, $avatar);
        }

        return $updatedUser->fresh();
    }

    /**
     * Update user avatar
     */
    public function updateAvatar(User $user, UploadedFile $avatar): User
    {
        // Delete old avatar if exists
        if ($user->avatar) {
            $this->deleteAvatarFile($user->avatar);
        }

        // Store new avatar
        $filename = $this->generateAvatarFilename($avatar);
        $path = $avatar->storeAs('profile-pictures', $filename, 'public');

        return $this->userRepository->updateAvatar($user, $path);
    }

    /**
     * Delete user avatar
     */
    public function deleteAvatar(User $user): User
    {
        if ($user->avatar) {
            $this->deleteAvatarFile($user->avatar);
        }

        return $this->userRepository->deleteAvatar($user);
    }

    /**
     * Generate unique filename for avatar
     */
    protected function generateAvatarFilename(UploadedFile $file): string
    {
        return time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
    }

    /**
     * Delete avatar file from storage
     */
    protected function deleteAvatarFile(string $path): void
    {
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
