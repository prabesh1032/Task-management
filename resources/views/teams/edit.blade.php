@extends('layouts.app')

@section('title', 'Edit User')

@section('content')

<div class="max-w-2xl mx-auto">

    {{-- Card --}}
    <div class="bg-white rounded-xl border border-gray-100 overflow-hidden">

        {{-- Card Header --}}
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-indigo-50 flex items-center justify-center">
                    <i class="ri-user-settings-line text-indigo-600"></i>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-900">Edit Member</p>
                    <p class="text-xs text-gray-400">Update {{ $team->name }}'s account details</p>
                </div>
            </div>
            <a href="{{ route('teams.index') }}"
               class="w-8 h-8 flex items-center justify-center rounded-lg text-red-500
                       hover:text-red-600 transition-colors">
                <i class="ri-close-line text-lg"></i>
            </a>
        </div>

        {{-- Form --}}
        <form action="{{ route('teams.update', $team) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="role" value="member">

            <div class="p-6 space-y-5">

                {{-- Profile Photo --}}
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-full border-2 border-dashed border-gray-200
                                flex items-center justify-center overflow-hidden flex-shrink-0">
                        <img id="avatar-preview"
                             src="{{ $team->profile_picture ?: asset('useravatar.avif') }}"
                             alt="{{ $team->name }}"
                             class="w-full h-full object-cover">
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-700 mb-1">Profile Photo</p>
                        <label class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium
                                      text-indigo-600 bg-indigo-50 rounded-lg hover:bg-indigo-100
                                      transition-colors cursor-pointer">
                            <i class="ri-upload-2-line"></i> Change photo
                            <input type="file" name="profile_picture" accept="image/*"
                                   class="hidden" onchange="previewAvatar(event)">
                        </label>
                        <p class="text-xs text-gray-400 mt-1">JPG, PNG or WEBP · optional</p>
                        @error('profile_picture')
                        <p class="text-xs text-red-500 mt-1 flex items-center gap-1">
                            <i class="ri-error-warning-line"></i> {{ $message }}
                        </p>
                        @enderror
                    </div>
                </div>

                <div class="border-t border-gray-100"></div>

                {{-- Name + Email --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div class="space-y-1.5">
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Full Name <span class="text-red-400">*</span>
                        </label>
                        <input type="text" name="name" required
                               value="{{ old('name', $team->name) }}"
                               placeholder="e.g. John Doe"
                               class="w-full px-3.5 py-2.5 text-sm rounded-lg border border-gray-200
                                      bg-gray-50 text-gray-900 placeholder-gray-400
                                      focus:outline-none focus:ring-2 focus:ring-indigo-500
                                      focus:border-transparent focus:bg-white transition">
                        @error('name')
                        <p class="text-xs text-red-500 flex items-center gap-1">
                            <i class="ri-error-warning-line"></i> {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Email Address <span class="text-red-400">*</span>
                        </label>
                        <input type="email" name="email" required
                               value="{{ old('email', $team->email) }}"
                               placeholder="e.g. john@example.com"
                               class="w-full px-3.5 py-2.5 text-sm rounded-lg border border-gray-200
                                      bg-gray-50 text-gray-900 placeholder-gray-400
                                      focus:outline-none focus:ring-2 focus:ring-indigo-500
                                      focus:border-transparent focus:bg-white transition">
                        @error('email')
                        <p class="text-xs text-red-500 flex items-center gap-1">
                            <i class="ri-error-warning-line"></i> {{ $message }}
                        </p>
                        @enderror
                    </div>
                </div>

                {{-- Password + Confirm --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div class="space-y-1.5">
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            New Password
                        </label>
                        <div class="relative">
                            <input type="password" name="password"
                                   id="password"
                                   placeholder="Leave blank to keep current"
                                   class="w-full px-3.5 py-2.5 pr-10 text-sm rounded-lg border border-gray-200
                                          bg-gray-50 text-gray-900 placeholder-gray-400
                                          focus:outline-none focus:ring-2 focus:ring-indigo-500
                                          focus:border-transparent focus:bg-white transition">
                            <button type="button" onclick="togglePassword('password', 'eye1')"
                                    class="absolute right-3 top-2.5 text-gray-400 hover:text-gray-600">
                                <i class="ri-eye-line text-base" id="eye1"></i>
                            </button>
                        </div>
                        @error('password')
                        <p class="text-xs text-red-500 flex items-center gap-1">
                            <i class="ri-error-warning-line"></i> {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Confirm Password
                        </label>
                        <div class="relative">
                            <input type="password" name="password_confirmation"
                                   id="password_confirmation"
                                   placeholder="Repeat new password"
                                   class="w-full px-3.5 py-2.5 pr-10 text-sm rounded-lg border border-gray-200
                                          bg-gray-50 text-gray-900 placeholder-gray-400
                                          focus:outline-none focus:ring-2 focus:ring-indigo-500
                                          focus:border-transparent focus:bg-white transition">
                            <button type="button" onclick="togglePassword('password_confirmation', 'eye2')"
                                    class="absolute right-3 top-2.5 text-gray-400 hover:text-gray-600">
                                <i class="ri-eye-line text-base" id="eye2"></i>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Info Note --}}
                <div class="flex items-start gap-2.5 px-4 py-3 bg-amber-50 border border-amber-100 rounded-lg">
                    <i class="ri-information-line text-amber-500 text-base mt-0.5 flex-shrink-0"></i>
                    <p class="text-xs text-amber-700">Leave the password fields blank if you don't want to change the current password.</p>
                </div>

            </div>

            {{-- Card Footer --}}
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex items-center justify-end gap-3">
                <a href="{{ route('teams.index') }}"
                   class="px-4 py-2 text-sm font-medium text-white bg-red-600
                          rounded-lg hover:bg-red-700 transition-colors">
                    Cancel
                </a>
                <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2 text-sm font-medium
                               text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg transition-colors">
                    <i class="ri-save-line"></i> Save Changes
                </button>
            </div>

        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
function togglePassword(fieldId, iconId) {
    const field = document.getElementById(fieldId);
    const icon  = document.getElementById(iconId);
    if (field.type === 'password') {
        field.type = 'text';
        icon.className = 'ri-eye-off-line text-base';
    } else {
        field.type = 'password';
        icon.className = 'ri-eye-line text-base';
    }
}

function previewAvatar(event) {
    const file = event.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        document.getElementById('avatar-preview').src = e.target.result;
    };
    reader.readAsDataURL(file);
}
</script>
@endpush
