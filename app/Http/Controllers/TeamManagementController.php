<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class TeamManagementController extends Controller
{
    // List users (teams)
    public function index()
    {
        $users = User::withCount('assignedTasks')->orderBy('created_at', 'desc')->paginate(10);
        $sort  = request()->input('sort', 'newest');
        return view('team', compact('users', 'sort'));
    }

    // Show create form
    public function create()
    {
        return view('teams.create');
    }

    // Store new user created by admin
    public function store(Request $request)
    {
        $request->validate([
            'name'            => 'required|string|max:255',
            'email'           => 'required|email|unique:users,email',
            'password'        => 'required|confirmed|min:6',
            'role'            => 'nullable|string|in:admin,member',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,avif|max:2048',
        ]);

        $data = $request->only(['name', 'email']);

        // Upload profile picture to Cloudinary
        if ($request->hasFile('profile_picture')) {
            $uploaded = Cloudinary::uploadApi()->upload(
                $request->file('profile_picture')->getRealPath(),
                ['folder' => 'taskmanager/profiles']
            );

            $data['profile_picture']           = $uploaded['secure_url'] ?? $uploaded['url'] ?? null;
            $data['profile_picture_public_id'] = $uploaded['public_id'] ?? null;
        }

        $data['password'] = Hash::make($request->password);
        $data['role']     = $request->input('role', 'member');

        User::create($data);

        return redirect()->route('teams.index')->with('success', 'User created successfully.');
    }

    // Edit user
    public function edit(User $team)
    {
        return view('teams.edit', ['team' => $team]);
    }

    // Update user
    public function update(Request $request, User $team)
    {
        $request->validate([
            'name'            => 'required|string|max:255',
            'email'           => 'required|email|unique:users,email,' . $team->id,
            'password'        => 'nullable|confirmed|min:6',
            'role'            => 'nullable|string|in:admin,member',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,avif|max:2048',
        ]);

        $data = $request->only(['name', 'email']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // Upload new profile picture to Cloudinary
        if ($request->hasFile('profile_picture')) {
            // Delete old image from Cloudinary if exists
            if ($team->profile_picture_public_id) {
                Cloudinary::uploadApi()->destroy($team->profile_picture_public_id);
            }

            $uploaded = Cloudinary::uploadApi()->upload(
                $request->file('profile_picture')->getRealPath(),
                ['folder' => 'taskmanager/profiles']
            );

            $data['profile_picture']           = $uploaded['secure_url'] ?? $uploaded['url'] ?? null;
            $data['profile_picture_public_id'] = $uploaded['public_id'] ?? null;
        }

        $data['role'] = $request->input('role', $team->role ?? 'member');

        $team->update($data);

        return redirect()->route('teams.index')->with('success', 'User updated successfully.');
    }

    // Delete user
    public function destroy(User $team)
    {
        if (auth()->id() === $team->id) {
            return redirect()->route('teams.index')->with('error', 'You cannot delete your own account.');
        }

        // Delete profile picture from Cloudinary if exists
        if ($team->profile_picture_public_id) {
            Cloudinary::destroy($team->profile_picture_public_id);
        }

        $team->delete();

        return redirect()->route('teams.index')->with('success', 'User deleted successfully.');
    }
}
