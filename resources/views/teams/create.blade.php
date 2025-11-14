@extends('layouts.app')

@section('title', 'Create User')

@section('content')
<div class="max-w-3xl mx-auto">
    <h2 class="text-2xl font-bold mb-4">Create User</h2>

    <form action="{{ route('teams.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label class="block text-sm font-medium mb-2">Full Name</label>
            <input type="text" name="name" required class="w-full px-3 py-2 border rounded" value="{{ old('name') }}">
            @error('name') <p class="text-sm text-red-500">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-2">Email</label>
            <input type="email" name="email" required class="w-full px-3 py-2 border rounded" value="{{ old('email') }}">
            @error('email') <p class="text-sm text-red-500">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-2">Password</label>
            <input type="password" name="password" required class="w-full px-3 py-2 border rounded">
            @error('password') <p class="text-sm text-red-500">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-2">Confirm Password</label>
            <input type="password" name="password_confirmation" required class="w-full px-3 py-2 border rounded">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-2">Role</label>
            <select name="role" class="w-full px-3 py-2 border rounded">
                <option value="member" selected>Member</option>
                <option value="admin">Admin</option>
            </select>
            @error('role') <p class="text-sm text-red-500">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-2">Profile Photo (optional)</label>
            <input type="file" name="profile_picture" accept="image/*">
            @error('profile_picture') <p class="text-sm text-red-500">{{ $message }}</p> @enderror
        </div>

        <div class="flex space-x-2">
            <button class="px-4 py-2 bg-indigo-600 text-white rounded">Create</button>
            <a href="{{ route('teams.index') }}" class="px-4 py-2 border rounded">Cancel</a>
        </div>
    </form>
</div>

@endsection
