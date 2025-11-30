<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Services\ProfileService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    public function __construct(
        protected ProfileService $profileService
    ) {}

    /**
     * Display the user's profile
     */
    public function show(): Response
    {
        $user = auth()->user();

        return Inertia::render('Profile', [
            'currentUser' => [
                'username' => $user->username,
                'name' => $user->name,
                'avatar' => $user->avatar ? asset('storage/'.$user->avatar) : null,
            ],
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
                'name' => $user->name,
                'email' => $user->email,
                'avatar' => $user->avatar ? asset('storage/'.$user->avatar) : null,
                'bio' => $user->bio,
                'website' => $user->website,
                'gender' => $user->gender,
                'postsCount' => 0, // Placeholder - will be implemented with posts feature
                'followersCount' => 0, // Placeholder - will be implemented with follows feature
                'followingCount' => 0, // Placeholder - will be implemented with follows feature
                'isOwnProfile' => true,
            ],
        ]);
    }

    /**
     * Show the form for editing the profile
     */
    public function edit(): Response
    {
        $user = auth()->user();

        return Inertia::render('EditProfile', [
            'currentUser' => [
                'username' => $user->username,
                'name' => $user->name,
                'avatar' => $user->avatar ? asset('storage/'.$user->avatar) : null,
            ],
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
                'name' => $user->name,
                'email' => $user->email,
                'avatar' => $user->avatar ? asset('storage/'.$user->avatar) : null,
                'bio' => $user->bio,
                'website' => $user->website,
                'gender' => $user->gender,
            ],
        ]);
    }

    /**
     * Update the user's profile
     */
    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        try {
            $user = auth()->user();
            $data = $request->validated();

            // Update profile
            $this->profileService->updateProfile($user, $data);

            return redirect()
                ->route('profile')
                ->with('success', 'Profile updated successfully!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['error' => 'Failed to update profile. Please try again.']);
        }
    }

    /**
     * Delete the user's avatar
     */
    public function deleteAvatar(): RedirectResponse
    {
        try {
            $user = auth()->user();
            $this->profileService->deleteAvatar($user);

            return redirect()
                ->back()
                ->with('success', 'Profile picture removed successfully!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withErrors(['error' => 'Failed to remove profile picture. Please try again.']);
        }
    }
}
