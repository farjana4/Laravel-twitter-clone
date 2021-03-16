<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditProfileRequest;
use App\Services\ProfileService;
use Exception;
use Illuminate\Http\RedirectResponse;

class ProfileController extends Controller
{
    private ProfileService $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function showProfileForm()
    {
        $data['user'] = auth()->user();
        $data['tweets'] = $data['user']->tweets;

        return view('profile.profile', $data);
    }

    public function updateProfile(EditProfileRequest $request): RedirectResponse
    {
        try {
            $this->profileService->updateProfile($request->except(['_token']));

            $this->setSuccessNotification('User profile updated Successfully');
        } catch (Exception $exception) {
            $this->setErrorNotification($exception->getMessage());
        }

        return redirect()->back();
    }
}
