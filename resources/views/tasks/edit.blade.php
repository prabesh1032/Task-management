@extends('layouts.app')

@section('title', 'Update Task')

@section('content')
<div class="container mx-auto max-w-4xl">
    <h1 class="text-3xl font-bold mb-6">Update Task</h1>
    <form action="{{ route('tasks.update', $task->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Basic Task Info -->
        <div class="grid grid-cols-1 gap-6">
            <div>
                <label for="title" class="block text-lg font-medium text-gray-700">Task Title</label>
                <input type="text" id="title" name="title" class="w-full border rounded-lg p-3"
                       value="{{ $task->title }}" required>
                @error('title')
                    <span class="text-red-600 text-sm mt-1 block">*{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="description" class="block text-lg font-medium text-gray-700">Description</label>
                <textarea id="description" name="description" class="w-full border rounded-lg p-3">{{ $task->description }}</textarea>
                @error('description')
                    <span class="text-red-600 text-sm mt-1 block">*{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- Priority, Due Date, and Assignment -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
            <div>
                <label for="priority" class="block text-lg font-medium text-gray-700">Priority</label>
                <select id="priority" name="priority" class="w-full border rounded-lg p-3" required>
                    <option value="low" {{ $task->priority == 'low' ? 'selected' : '' }}>Low</option>
                    <option value="medium" {{ $task->priority == 'medium' ? 'selected' : '' }}>Medium</option>
                    <option value="high" {{ $task->priority == 'high' ? 'selected' : '' }}>High</option>
                </select>
            </div>

            <div>
                <label for="due_date" class="block text-lg font-medium text-gray-700">Due Date</label>
                <input type="date" id="due_date" name="due_date" class="w-full border rounded-lg p-3"
                       value="{{ $task->due_date->format('Y-m-d') }}" required>
            </div>

            <div>
                <label for="assigned_to" class="block text-lg font-medium text-gray-700">Assign To</label>
                <select id="assigned_to" name="assigned_to" class="w-full border rounded-lg p-3" required>
                    <option value="">Select User</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ $task->assigned_to == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Checklist Section -->
        <div class="bg-gray-50 p-4 rounded-lg mt-6">
            <h2 class="text-xl font-semibold mb-4">Checklist Items</h2>

            <div id="checklist-container" class="space-y-3 mb-4">
                @php
                    $checklistItems = json_decode($task->todo_checklist, true) ?? [];
                    $checklistKeys = array_keys($checklistItems);
                @endphp

                @if(count($checklistKeys) > 0)
                    @foreach($checklistKeys as $key)
                    <div class="flex items-center space-x-3 checklist-item">
                        <input type="text" name="todo_checklist[]"
                               class="flex-1 border rounded-lg p-3"
                               value="{{ $key }}">
                        <button type="button" class="remove-checklist-item text-red-500 hover:text-red-700 p-2">
                            Remove
                        </button>
                    </div>
                    @endforeach
                @else
                    <div class="flex items-center space-x-3 checklist-item">
                        <input type="text" name="todo_checklist[]"
                               class="flex-1 border rounded-lg p-3"
                               placeholder="Enter checklist item">
                        <button type="button" class="remove-checklist-item text-red-500 hover:text-red-700 p-2">
                            Remove
                        </button>
                    </div>
                @endif
            </div>

            <button type="button" id="add-checklist-item"
                    class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600">
                + Add Another Item
            </button>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end mt-6">
            <button type="submit" class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600">
                Update Task
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('checklist-container');
        const addButton = document.getElementById('add-checklist-item');

        // Add new checklist item
        addButton.addEventListener('click', function() {
            const newItem = document.createElement('div');
            newItem.className = 'flex items-center space-x-3 checklist-item';
            newItem.innerHTML = `
                <input type="text" name="todo_checklist[]"
                       class="flex-1 border rounded-lg p-3"
                       placeholder="Enter checklist item">
                <button type="button" class="remove-checklist-item text-red-500 hover:text-red-700 p-2">
                    Remove
                </button>
            `;
            container.appendChild(newItem);
        });

        // Remove checklist item
        container.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-checklist-item')) {
                const item = e.target.closest('.checklist-item');
                if (container.querySelectorAll('.checklist-item').length > 1) {
                    item.remove();
                } else {
                    item.querySelector('input').value = '';
                }
            }
        });
    });
</script>
@endsection
