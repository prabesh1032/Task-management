<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class UserProfileController extends Controller
{
    /**
     * Display the user's profile.
     */
    public function index()
    {
        $user = Auth::user();
        return view('userprofile.index', compact('user'));
    }

    /**
     * Show the form for editing the user's profile.
     */
    public function edit()
    {
        $user = Auth::user();
        return view('userprofile.edit', compact('user'));
    }

    /**
     * Update the user's profile.
     */
    public function update(Request $request)
    {
        $request->validate([
            'name'             => ['required', 'string', 'max:255'],
            'email'            => ['required', 'email', 'max:255', 'unique:users,email,' . Auth::id()],
            'profile_picture'  => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'current_password' => ['nullable', 'required_with:new_password', 'current_password'],
            'new_password'     => ['nullable', 'min:8', 'confirmed'],
        ]);

        $user = Auth::user();

        // Handle profile picture upload via Cloudinary
        if ($request->hasFile('profile_picture')) {
            // Delete old image from Cloudinary if exists
            if ($user->profile_picture_public_id) {
                Cloudinary::uploadApi()->destroy($user->profile_picture_public_id);
            }

            // Upload new image to Cloudinary
            $uploaded = Cloudinary::uploadApi()->upload(
                $request->file('profile_picture')->getRealPath(),
                ['folder' => 'taskmanager/profiles']
            );

            $user->profile_picture           = $uploaded['secure_url'] ?? $uploaded['url'] ?? null;
            $user->profile_picture_public_id = $uploaded['public_id'] ?? null;
        }

        // Update basic info
        $user->name  = $request->name;
        $user->email = $request->email;

        // Update password if provided
        if ($request->filled('new_password')) {
            $user->password = Hash::make($request->new_password);
        }

        $user->save();

        return redirect()->route('userprofile.index')->with('success', 'Profile updated successfully!');
    }
}
