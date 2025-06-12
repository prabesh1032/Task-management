@extends('layouts.app')

@section('title', 'Create Task')

@section('content')
<div class="container mx-auto max-w-4xl">
    <h1 class="text-3xl font-bold mb-6">Create Task</h1>
    <form action="{{ route('tasks.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        {{-- CSRF Token --}}
        @csrf
        <div class="mb-4">
            <label for="title" class="block text-lg font-medium text-gray-700">Task Title</label>
            <input type="text" id="title" name="title" class="w-full border rounded-lg p-3" placeholder="Enter Task Title" value="{{ old('title') }}" required>
            @error('title')
                <span class="text-red-600 text-sm mt-1 block">*{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="description" class="block text-lg font-medium text-gray-700">Description</label>
            <textarea id="description" name="description" class="w-full border rounded-lg p-3" placeholder="Describe task">{{ old('description') }}</textarea>
            @error('description')
                <span class="text-red-600 text-sm mt-1 block">*{{ $message }}</span>
            @enderror
        </div>

        {{-- <div class="mb-4">
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
        </div> --}}

        <div class="flex space-x-4 mb-4">
            <div class="flex-1">
                <label for="priority" class="block text-lg font-medium text-gray-700">Priority</label>
                <select id="priority" name="priority" class="w-full border rounded-lg p-3" required>
                    <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Low</option>
                    <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                    <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High</option>
                </select>
                @error('priority')
                    <span class="text-red-600 text-sm mt-1 block">*{{ $message }}</span>
                @enderror
            </div>

        <div class="flex-1">
                <label for="due_date" class="block text-lg font-medium text-gray-700">Due Date</label>
                <input type="date" id="due_date" name="due_date" class="w-full border rounded-lg p-3" value="{{ old('due_date') }}" required>
                @error('due_date')
                    <span class="text-red-600 text-sm mt-1 block">*{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="mb-4">
            <label for="assigned_to" class="block text-lg font-medium text-gray-700">Assign To</label>
            <select id="assigned_to" name="assigned_to" class="border rounded w-full p-2" required>
                <option value="">Select User</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ old('assigned_to') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
            @error('assigned_to')
                <div class="text-red-600 mt-2 text-sm">
                    *{{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="todo_checklist" class="block text-lg font-medium text-gray-700">TODO Checklist</label>
            <div id="checklist-items" class="space-y-2">
                <input type="text" name="todo_checklist[]" class="w-full border rounded-lg p-3" placeholder="Checklist Item 1">
            </div>
            <button type="button" id="add-checklist-item" class="mt-2 bg-blue-500 text-white py-2 px-4 rounded-lg">
                + Add Item
            </button>
            @error('todo_checklist.*')
                <span class="text-red-600 text-sm mt-1 block">*{{ $message }}</span>
            @enderror
        </div>

        {{-- <div class="mb-4">
            <label for="attachment" class="block text-lg font-medium text-gray-700">Attachment</label>
            <input type="file" id="attachment" name="attachment" class="border rounded w-full p-2">
            @error('attachment')
                <div class="text-red-600 mt-2 text-sm">
                    *{{ $message }}
                </div>
            @enderror
        </div> --}}

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Create</button>
    </form>
</div>

<script>
    document.getElementById('add-checklist-item').addEventListener('click', function() {
        const checklistItems = document.getElementById('checklist-items');
        const input = document.createElement('input');
        input.type = 'text';
        input.name = 'todo_checklist[]';
        input.className = 'w-full border rounded-lg p-3';
        input.placeholder = `Checklist Item ${checklistItems.children.length + 1}`;
        checklistItems.appendChild(input);
    });
</script>
@endsection
