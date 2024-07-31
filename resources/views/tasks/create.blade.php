@extends('layouts.app')

@section('title', 'Create Task')

@section('content')
<div class="container mx-auto">
    <h1 class="text-4xl font-bold mb-6">Create Task</h1>

    <form action="{{ route('tasks.store') }}" method="POST" class="max-w-lg">
        @csrf
        <div class="mb-4">
            <label for="title" class="block text-lg font-medium text-gray-700">Title</label>
            <input type="text" id="title" name="title" class="border rounded w-full p-2" value="{{ old('title') }}" required>
            @error('title')
                <div class="text-red-600 mt-2 text-sm">
                    *{{ $message }}
                </div>
            @enderror
        </div>
        <div class="mb-4">
            <label for="description" class="block text-lg font-medium text-gray-700">Description</label>
            <textarea id="description" name="description" class="border rounded w-full p-2">{{ old('description') }}</textarea>
            @error('description')
                <div class="text-red-600 mt-2 text-sm">
                    *{{ $message }}
                </div>
            @enderror
        </div>
        <div class="mb-4">
            <label for="status" class="block text-lg font-medium text-gray-700">Status</label>
            <select id="status" name="status" class="border rounded w-full p-2" required>
                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="overdue" {{ old('status') == 'overdue' ? 'selected' : '' }}>Overdue</option>
            </select>
            @error('status')
                <div class="text-red-600 mt-2 text-sm">
                    *{{ $message }}
                </div>
            @enderror
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Create</button>
    </form>
</div>
@endsection
