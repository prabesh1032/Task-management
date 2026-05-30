@extends('layouts.app')

@section('title', 'Create Team Member')

@section('content')

<div class="max-w-2xl mx-auto">

    {{-- Card --}}
    <div class="bg-white rounded-xl border border-gray-100 overflow-hidden">

        {{-- Card Header --}}
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-indigo-50 flex items-center justify-center">
                    <i class="ri-user-add-line text-indigo-600"></i>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-900">New Team Member</p>
                    <p class="text-xs text-gray-400">Fill in the details to create a member account</p>
                </div>
            </div>
            <a href="{{ route('teams.index') }}"
               class="w-8 h-8 flex items-center justify-center text-red-500 hover:text-red-600 transition-colors">
                <i class="ri-close-line text-lg"></i>
            </a>
        </div>

        {{-- Form --}}
        <form action="{{ route('teams.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="role" value="member">

            <div class="p-6 space-y-5">

                {{-- Profile Photo --}}
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-full bg-gray-100 border-2 border-dashed border-gray-200
                                flex items-center justify-center overflow-hidden flex-shrink-0" id="avatar-preview">
                        <i class="ri-user-line text-2xl text-gray-300" id="avatar-icon"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-700 mb-1">Profile Photo</p>
                        <label class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium
                                      text-indigo-600 bg-indigo-50 rounded-lg hover:bg-indigo-100
                                      transition-colors cursor-pointer">
                            <i class="ri-upload-2-line"></i> Upload photo
                            <input type="file" name="profile_picture" accept="image/*"
                                   class="hidden" id="profile-upload"
                                   onchange="previewAvatar(event)">
                        </label>
                        <p class="text-xs text-gray-400 mt-1">JPG, PNG or WEBP · optional</p>
                        @error('profile_picture')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
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
                               value="{{ old('name') }}"
                               placeholder="Name of team member"
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
                               value="{{ old('email') }}"
                               placeholder="e.g. ram@example.com"
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
                            Password <span class="text-red-400">*</span>
                        </label>
                        <div class="relative">
                            <input type="password" name="password" required
                                   id="password"
                                   placeholder="Min. 8 characters"
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
                            Confirm Password <span class="text-red-400">*</span>
                        </label>
                        <div class="relative">
                            <input type="password" name="password_confirmation" required
                                   id="password_confirmation"
                                   placeholder="Repeat password"
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

            </div>

            {{-- Card Footer --}}
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex items-center justify-end gap-3">
                <a href="{{ route('teams.index') }}"
                   class="px-4 py-2 text-sm font-medium  text-white bg-red-500 hover:bg-red-600
                          rounded-lg transition-colors">
                    Cancel
                </a>
                <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2 text-sm font-medium
                               text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg transition-colors">
                    <i class="ri-user-add-line"></i> Create Member
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
        const preview = document.getElementById('avatar-preview');
        const icon    = document.getElementById('avatar-icon');
        icon.style.display = 'none';
        const existing = preview.querySelector('img');
        if (existing) existing.remove();
        const img = document.createElement('img');
        img.src = e.target.result;
        img.className = 'w-full h-full object-cover';
        preview.appendChild(img);
    };
    reader.readAsDataURL(file);
}
</script>
@endpush
