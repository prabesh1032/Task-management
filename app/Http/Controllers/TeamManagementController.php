<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TeamManagementController extends Controller
{
    // Middleware is applied at route level in web.php, no need for constructor middleware

    // List users (teams)
    public function index()
    {
        $users = User::withCount('assignedTasks')->orderBy('created_at', 'desc')->paginate(10);
        $sort = request()->input('sort', 'newest');
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
            'role' => 'nullable|string|in:admin,member',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,avif|max:2048',
        ]);

        $data = $request->only(['name', 'email']);

        if ($request->hasFile('profile_picture')) {
            $photoname = time() . '.' . $request->profile_picture->extension();
            $request->profile_picture->move(public_path('images'), $photoname);
            $data['profile_picture'] = $photoname;
        }

        $data['password'] = Hash::make($request->password);
        $data['role'] = $request->input('role', 'member');

        User::create($data);

        return redirect()->route('teams.index')->with('success', 'User created successfully.');
    }

    // Edit user
    public function edit(User $team)
    {
        // $team variable is a User (teams = users)
        return view('teams.edit', ['team' => $team]);
    }

    // Update user
    public function update(Request $request, User $team)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $team->id,
            'password' => 'nullable|confirmed|min:6',
            'role' => 'nullable|string|in:admin,member',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,avif|max:2048',
        ]);

        $data = $request->only(['name', 'email']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('profile_picture')) {
            $photoname = time() . '.' . $request->profile_picture->extension();
            $request->profile_picture->move(public_path('images'), $photoname);
            $data['profile_picture'] = $photoname;
        }

        $data['role'] = $request->input('role', $team->role ?? 'member');

        $team->update($data);

        return redirect()->route('teams.index')->with('success', 'User updated successfully.');
    }

    // Delete user
    public function destroy(User $team)
    {
        // Prevent deleting self
        if (auth()->id() === $team->id) {
            return redirect()->route('teams.index')->with('error', 'You cannot delete your own account.');
        }

        $team->delete();
        return redirect()->route('teams.index')->with('success', 'User deleted successfully.');
    }
}
