@extends('layouts.userapp')

@section('title', 'Edit Profile')

@section('content')

<div class="max-w-2xl mx-auto space-y-5">
    <form method="POST" action="{{ route('userprofile.update') }}" enctype="multipart/form-data" class="space-y-5">
        @csrf
        @method('PUT')

        {{-- Profile Photo --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
            <h2 class="text-sm font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <i class="ri-image-line text-indigo-600"></i> Profile Photo
            </h2>
            <div class="flex items-center gap-5">
                <img id="profile_preview"
                     src="{{ $user->profile_picture ?: asset('useravatar.avif') }}"
                     class="w-20 h-20 rounded-full object-cover border-2 border-gray-200 shadow-sm flex-shrink-0">
                <div class="flex-1">
                    <input type="file" name="profile_picture" accept="image/*"
                           onchange="previewImage(this)"
                           class="block w-full text-sm text-gray-500
                                  file:mr-3 file:py-2 file:px-4
                                  file:rounded-lg file:border-0
                                  file:text-sm file:font-medium
                                  file:bg-indigo-50 file:text-indigo-700
                                  hover:file:bg-indigo-100 transition-colors">
                    <p class="mt-2 text-xs text-gray-400">JPG, PNG or GIF · Max 2MB</p>
                    @error('profile_picture')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Personal Information --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
            <h2 class="text-sm font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <i class="ri-user-settings-line text-indigo-600"></i> Personal Information
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="name" class="block text-xs font-medium text-gray-600 mb-1">Full Name</label>
                    <input type="text" id="name" name="name"
                           value="{{ old('name', $user->name) }}"
                           class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                    @error('name')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="email" class="block text-xs font-medium text-gray-600 mb-1">Email Address</label>
                    <input type="email" id="email" name="email"
                           value="{{ old('email', $user->email) }}"
                           class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                    @error('email')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Change Password --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
            <h2 class="text-sm font-semibold text-gray-800 mb-1 flex items-center gap-2">
                <i class="ri-lock-password-line text-indigo-600"></i> Change Password
            </h2>
            <p class="text-xs text-gray-400 mb-4">Leave blank if you don't want to change your password</p>
            <div class="space-y-4">
                <div>
                    <label for="current_password" class="block text-xs font-medium text-gray-600 mb-1">Current Password</label>
                    <input type="password" id="current_password" name="current_password"
                           class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                    @error('current_password')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="new_password" class="block text-xs font-medium text-gray-600 mb-1">New Password</label>
                        <input type="password" id="new_password" name="new_password"
                               class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                        @error('new_password')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="new_password_confirmation" class="block text-xs font-medium text-gray-600 mb-1">Confirm Password</label>
                        <input type="password" id="new_password_confirmation" name="new_password_confirmation"
                               class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                    </div>
                </div>
            </div>
        </div>

        {{-- Save Button --}}
        <div class="flex justify-end gap-3">
            <a href="{{ route('userprofile.index') }}"
               class="px-4 py-2 text-sm text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                Cancel
            </a>
            <button type="submit"
                    class="inline-flex items-center gap-2 px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition-colors shadow-sm">
                <i class="ri-save-line"></i> Save Changes
            </button>
        </div>

    </form>
</div>

@push('scripts')
<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => document.getElementById('profile_preview').src = e.target.result;
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush

@endsection
