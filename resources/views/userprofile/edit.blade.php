@extends('layouts.userapp')

@section('title', 'Edit Profile')

@section('content')
<div class="container mx-auto max-w-4xl py-8">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 p-6 text-white">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-bold">Edit Profile</h1>
                <a href="{{ route('userprofile.index') }}"
                   class="flex items-center text-white hover:text-gray-200 transition-colors">
                    <i class="ri-arrow-left-line mr-2"></i> Back to Profile
                </a>
            </div>
        </div>

        <!-- Edit Form -->
        <div class="p-6 md:p-8">
            <form method="POST" action="{{ route('userprofile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <!-- Profile Picture Section -->
                    <div class="border-b border-gray-200 pb-6">
                        <h2 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                            <i class="ri-image-line mr-2 text-indigo-600"></i>
                            Profile Photo
                        </h2>
                        <div class="flex items-center space-x-6">
                            <div class="shrink-0">
                                <img id="profile_preview"
                                     src="{{ $user->profile_picture ? asset('images/' . $user->profile_picture) : asset('useravatar.avif') }}"
                                     class="h-20 w-20 rounded-full object-cover border-2 border-gray-200 shadow-sm">
                            </div>
                            <div class="flex-1">
                                <label class="block">
                                    <span class="sr-only">Choose profile photo</span>
                                    <input type="file" name="profile_picture" accept="image/*"
                                           class="block w-full text-sm text-gray-500
                                                  file:mr-4 file:py-2 file:px-4
                                                  file:rounded-md file:border-0
                                                  file:text-sm file:font-semibold
                                                  file:bg-indigo-50 file:text-indigo-700
                                                  hover:file:bg-indigo-100"
                                           onchange="previewImage(this)">
                                </label>
                                <p class="mt-2 text-xs text-gray-500">
                                    JPG, PNG or GIF (Max: 2MB)
                                </p>
                                @error('profile_picture')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Personal Information Section -->
                    <div class="border-b border-gray-200 pb-6">
                        <h2 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                            <i class="ri-user-settings-line mr-2 text-indigo-600"></i>
                            Personal Information
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2 px-3">
                                @error('name')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2 px-3">
                                @error('email')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Change Password Section -->
                    <div>
                        <h2 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                            <i class="ri-lock-password-line mr-2 text-indigo-600"></i>
                            Change Password
                        </h2>

                        <div class="space-y-4 bg-gray-50 p-4 rounded-lg">
                            <div>
                                <label for="current_password" class="block text-sm font-medium text-gray-700">Current Password</label>
                                <input type="password" id="current_password" name="current_password"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2 px-3">
                                @error('current_password')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="new_password" class="block text-sm font-medium text-gray-700">New Password</label>
                                <input type="password" id="new_password" name="new_password"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2 px-3">
                                @error('new_password')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                                <input type="password" id="new_password_confirmation" name="new_password_confirmation"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2 px-3">
                            </div>
                        </div>
                    </div>

                    <!-- Save Button -->
                    <div class="flex justify-end pt-4">
                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                            <i class="ri-save-line mr-2"></i> Save Changes
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('profile_preview').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
