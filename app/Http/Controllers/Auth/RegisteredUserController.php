<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function __construct()
    {
        // Ensure only authenticated admins can access registration endpoints
        $this->middleware(['auth', 'isadmin']);
    }
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|confirmed|min:6',
            'role' => 'nullable|string|in:admin,member',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,avif|max:2048', // Validate profile picture
        ]);

        $data = $request->only(['name', 'email']);

        // Handle image upload for the profile picture
        if ($request->hasFile('profile_picture')) {
            $photoname = time() . '.' . $request->profile_picture->extension();
            $request->profile_picture->move(public_path('images'), $photoname); // Save to public/images
            $data['profile_picture'] = $photoname; // Save file name in the database
        }

        $data['password'] = Hash::make($request->password); // Encrypt the password
        // Assign role - default to 'member' unless admin provided a valid role
        $data['role'] = $request->input('role', 'member');

        // Create the user
        $user = User::create($data);

        // Do not auto-login the created user. Redirect back to admin dashboard.
        return redirect()->route('dashboard')->with('success', 'User created successfully!');
    }
}
