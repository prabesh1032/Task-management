<?php
namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class UserProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $totalTasks     = Task::where('assigned_to', $user->id)->count();
        $completedTasks = Task::where('assigned_to', $user->id)->where('status', 'completed')->count();
        $pendingTasks   = Task::where('assigned_to', $user->id)->where('status', 'pending')->count();
        $inProgressTasks = Task::where('assigned_to', $user->id)->where('status', 'in_progress')->count();
        $recentTasks    = Task::where('assigned_to', $user->id)->latest()->take(3)->get();

        return view('userprofile.index', compact(
            'user',
            'totalTasks',
            'completedTasks',
            'pendingTasks',
            'inProgressTasks',
            'recentTasks'
        ));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('userprofile.edit', compact('user'));
    }

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

        if ($request->hasFile('profile_picture')) {
            if ($user->profile_picture_public_id) {
                Cloudinary::uploadApi()->destroy($user->profile_picture_public_id);
            }

            $uploaded = Cloudinary::uploadApi()->upload(
                $request->file('profile_picture')->getRealPath(),
                ['folder' => 'taskmanager/profiles']
            );

            $user->profile_picture           = $uploaded['secure_url'] ?? $uploaded['url'] ?? null;
            $user->profile_picture_public_id = $uploaded['public_id'] ?? null;
        }

        $user->name  = $request->name;
        $user->email = $request->email;

        if ($request->filled('new_password')) {
            $user->password = Hash::make($request->new_password);
        }

        $user->save();

        return redirect()->route('userprofile.index')->with('success', 'Profile updated successfully!');
    }
}
