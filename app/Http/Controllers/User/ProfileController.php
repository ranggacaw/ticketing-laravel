<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('user.profile.edit', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'avatar' => ['nullable', 'image', 'max:1024'], // 1MB Max
        ]);

        $user->fill([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
        ]);

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');

            if ($avatar && $avatar->isValid()) {
                // Delete old avatar if exists
                if ($user->avatar) {
                    Storage::disk('public')->delete($user->avatar);
                }

                // In some environments, getRealPath() might return false.
                // Using getPathname() as a fallback to ensure we have a valid string path for fopen.
                $tempPath = $avatar->getRealPath() ?: $avatar->getPathname();

                $path = Storage::disk('public')->putFileAs(
                    'avatars',
                    $tempPath,
                    $avatar->hashName()
                );

                if ($path) {
                    $user->avatar = $path;
                }
            }
        }

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return back()->with('status', 'profile-updated');
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('status', 'password-updated');
    }
}
