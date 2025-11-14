@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="max-w-3xl mx-auto">
    <h2 class="text-2xl font-bold mb-4">Edit User</h2>

    <form action="{{ route('teams.update', $team) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-sm font-medium mb-2">Full Name</label>
            <input type="text" name="name" required class="w-full px-3 py-2 border rounded" value="{{ old('name', $team->name) }}">
            @error('name') <p class="text-sm text-red-500">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-2">Email</label>
            <input type="email" name="email" required class="w-full px-3 py-2 border rounded" value="{{ old('email', $team->email) }}">
            @error('email') <p class="text-sm text-red-500">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-2">Password (leave blank to keep current)</label>
            <input type="password" name="password" class="w-full px-3 py-2 border rounded">
            @error('password') <p class="text-sm text-red-500">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-2">Confirm Password</label>
            <input type="password" name="password_confirmation" class="w-full px-3 py-2 border rounded">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-2">Role</label>
            <select name="role" class="w-full px-3 py-2 border rounded">
                <option value="member" {{ old('role', $team->role) === 'member' ? 'selected' : '' }}>Member</option>
                <option value="admin" {{ old('role', $team->role) === 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
            @error('role') <p class="text-sm text-red-500">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-2">Profile Photo (optional)</label>
            <div class="flex items-center space-x-4 mb-2">
                <div class="shrink-0">
                    <img id="profile_preview" class="h-16 w-16 rounded-full object-cover" src="{{ $team->profile_picture ? asset('images/' . $team->profile_picture) : asset('useravatar.avif') }}" alt="Preview">
                </div>
                <input type="file" name="profile_picture" accept="image/*" onchange="document.getElementById('profile_preview').src = window.URL.createObjectURL(this.files[0])">
            </div>
            @error('profile_picture') <p class="text-sm text-red-500">{{ $message }}</p> @enderror
        </div>

        <div class="flex space-x-2">
            <button class="px-4 py-2 bg-indigo-600 text-white rounded">Save</button>
            <a href="{{ route('teams.index') }}" class="px-4 py-2 border rounded">Cancel</a>
        </div>
    </form>
</div>

@endsection
