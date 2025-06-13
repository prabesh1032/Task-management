<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserProfileController extends Controller
{
    /**
     * Display the user's profile.
     */
    public function index()
    {
        $user = Auth::user(); // Get the authenticated user
        return view('userprofile.index', compact('user')); // Pass user data to the view
    }

    /**
     * Show the form for editing the user's profile.
     */
    public function edit()
    {
        $user = Auth::user(); // Get the authenticated user
        return view('userprofile.edit', compact('user')); // Pass user data to the view
    }

    /**
     * Update the user's profile.
     */
    public function update(Request $request)
{
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'email', 'max:255', 'unique:users,email,' . Auth::id()],
        'profile_picture' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        'current_password' => ['nullable', 'required_with:new_password', 'current_password'],
        'new_password' => ['nullable', 'min:8', 'confirmed'],
    ]);

    $user = Auth::user();

    // Handle profile picture upload
    if ($request->hasFile('profile_picture')) {
        // Delete old profile picture if exists
        if ($user->profile_picture && file_exists(public_path('images/' . $user->profile_picture))) {
            unlink(public_path('images/' . $user->profile_picture));
        }

        // Save new profile picture
        $photoname = time() . '.' . $request->profile_picture->extension();
        $request->profile_picture->move(public_path('images'), $photoname);
        $user->profile_picture = $photoname;
    }

    // Update basic info
    $user->name = $request->name;
    $user->email = $request->email;

    // Update password if provided
    if ($request->filled('new_password')) {
        $user->password = Hash::make($request->new_password);
    }

    $user->save();

    return redirect()->route('userprofile.index')->with('success', 'Profile updated successfully!');
}
}
