<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
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
     * Display the authenticated user's profile
     */
    public function index(): Response
    {
        $user = auth()->user();

        return Inertia::render('Profile', [
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
                'name' => $user->name,
                'email' => $user->email,
                'avatar' => $user->avatar ? asset('storage/'.$user->avatar) : null,
                'bio' => $user->bio,
                'website' => $user->website,
                'gender' => $user->gender,
                'postsCount' => 0,
                'followersCount' => 0,
                'followingCount' => 0,
            ],
            'isOwnProfile' => true,
        ]);
    }

    /**
     * Display a specific user's profile by username
     */
    public function show(string $username): Response
    {
        $user = User::where('username', $username)->firstOrFail();
        
        return Inertia::render('Profile', [
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
                'name' => $user->name,
                'avatar' => $user->avatar ? asset('storage/'.$user->avatar) : null,
                'bio' => $user->bio,
                'website' => $user->website,
                'postsCount' => 0,
                'followersCount' => 0,
                'followingCount' => 0,
            ],
            'isOwnProfile' => auth()->id() === $user->id,
        ]);
    }

    /**
     * Show the form for editing the profile
     */
    public function edit(): Response
    {
        $user = auth()->user();

        return Inertia::render('EditProfile', [
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
