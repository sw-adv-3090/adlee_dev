<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Traits\FileUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    use FileUpload;

    public function account()
    {
        return view('profile.update-profile-information-form');
    }

    public function update_profile_information(ProfileUpdateRequest $request)
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        if ($request->has('profile_photo')) {
            // delete old phote
            if ($request->user()->profile_photo_url) {
                $this->deleteFile($request->user()->profile_photo_url);
            }

            $request->user()->profile_photo_url = $this->fileUpload($request->profile_photo, 'avatars');
        }

        $request->user()->save();

        return Redirect::route('profile.account')->with('status', __('Profile updated successfully.'));
    }

    public function password()
    {
        return view('profile.update-password-form');
    }

    public function update_password(Request $request)
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('status', __('Password updated successfully.'));
    }

    public function browser_sessions()
    {
        return view('profile.browser-sessions');
    }
}
