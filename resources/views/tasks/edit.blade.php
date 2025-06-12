@extends('layouts.app')

@section('title', 'Update Task')

@section('content')
<div class="container mx-auto mt-6 max-w-4xl">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">Update Task</h1>
    <form action="{{ route('tasks.update', $task->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Task Title -->
        <div class="mb-4">
            <label for="title" class="block text-gray-600 mb-2">Task Title</label>
            <input type="text" name="title" id="title" value="{{ $task->title }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-200" required>
        </div>

        <!-- Task Description -->
        <div class="mb-4">
            <label for="description" class="block text-gray-600 mb-2">Description</label>
            <textarea name="description" id="description" rows="4" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-200" required>{{ $task->description }}</textarea>
        </div>

        <!-- Priority and Due Date -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
                <label for="priority" class="block text-gray-600 mb-2">Priority</label>
                <select name="priority" id="priority" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-200">
                    <option value="low" {{ $task->priority === 'low' ? 'selected' : '' }}>Low</option>
                    <option value="medium" {{ $task->priority === 'medium' ? 'selected' : '' }}>Medium</option>
                    <option value="high" {{ $task->priority === 'high' ? 'selected' : '' }}>High</option>
                </select>
            </div>
            <div>
                <label for="due_date" class="block text-gray-600 mb-2">Due Date</label>
                <input type="date" name="due_date" id="due_date" value="{{ $task->due_date }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-200" required>
            </div>
        </div>

        <div class="mb-4">
            <label for="assigned_to" class="block text-lg font-medium text-gray-700">Assign To</label>
            <select id="assigned_to" name="assigned_to" class="border rounded w-full p-2" required>
                <option value="">Select User</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ old('assigned_to', $task->assigned_to) == $user->id ? 'selected' : '' }}>
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
        <!-- TODO Checklist -->
        <div class="mb-6">
            <label class="block text-gray-600 mb-2">TODO Checklist</label>
            <ul id="checklist" class="space-y-2">
                @foreach(json_decode($task->todo_checklist, true) ?? [] as $index => $item)
                    <li class="flex items-center justify-between p-2 border rounded-lg">
                        <span>{{ $item }}</span>
                        <button type="button" class="text-red-500 hover:text-red-700" onclick="deleteChecklistItem(this)">Delete</button>
                        <input type="hidden" name="checklist[]" value="{{ $item }}">
                    </li>
                @endforeach
            </ul>
            <div class="mt-4 flex">
                <input type="text" id="newChecklistItem" placeholder="Enter new task" class="flex-1 px-4 py-2 border rounded-l-lg focus:outline-none focus:ring focus:ring-blue-200">
                <button type="button" class="bg-blue-500 text-white px-4 py-2 rounded-r-lg hover:bg-blue-600" onclick="addChecklistItem()">Add</button>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-between items-center">
            <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600">Update Task</button>
        </div>
    </form>
</div>

<script>
    function deleteChecklistItem(button) {
        button.parentElement.remove();
    }

    function addChecklistItem() {
        const input = document.getElementById('newChecklistItem');
        const value = input.value.trim();
        if (value) {
            const ul = document.getElementById('checklist');
            const li = document.createElement('li');
            li.className = "flex items-center justify-between p-2 border rounded-lg";
            li.innerHTML = `<span>${value}</span>
                            <button type="button" class="text-red-500 hover:text-red-700" onclick="deleteChecklistItem(this)">Delete</button>
                            <input type="hidden" name="checklist[]" value="${value}">`;
            ul.appendChild(li);
            input.value = '';
        }
    }
</script>
@endsection
