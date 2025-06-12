@extends('layouts.app')

@section('title', 'Tasks')

@section('content')
<div class="container mx-auto">
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold">My Tasks</h1>
        <a href="{{ route('tasks.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded shadow">Add New Task</a>
    </div>

    <div class="flex gap-4 mb-6">
        <button class="px-4 py-2 bg-gray-200 rounded">All</button>
        <button class="px-4 py-2 bg-gray-200 rounded">Pending</button>
        <button class="px-4 py-2 bg-gray-200 rounded">In Progress</button>
        <button class="px-4 py-2 bg-gray-200 rounded">Completed</button>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($tasks as $task)
            <div class="bg-white p-6 rounded-lg shadow border">
                <div class="flex items-center justify-between mb-4">
                    <span class="px-3 py-1 text-sm font-medium rounded-full {{ $task->priority === 'high' ? 'bg-red-100 text-red-800' : ($task->priority === 'medium' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                        {{ ucfirst($task->priority) }} Priority
                    </span>
                    <span class="px-3 py-1 text-sm font-medium rounded-full {{ $task->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                        {{ ucfirst($task->status) }}
                    </span>
                </div>
                <h2 class="text-xl font-bold text-gray-800 mb-2">{{ $task->title }}</h2>
                <p class="text-gray-600 mb-4">{{ Str::limit($task->description, 100) }}</p>

                <div class="mb-4">
                    <p class="text-sm text-gray-500">
                        <strong>Due Date:</strong> {{ \Carbon\Carbon::parse($task->due_date)->format('d M, Y') }}
                    </p>
                    <p class="text-sm text-gray-500">
                        <strong>Assigned To:</strong> {{ $task->assignedTo->name ?? 'Unassigned' }}
                    </p>
                </div>

                @if($task->todo_checklist)
                    <div class="mt-4">
                        <p class="text-sm font-medium text-gray-700 mb-2">Progress:</p>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-blue-500 h-2.5 rounded-full" style="width: {{ $task->progress_percentage ?? 0 }}%"></div>
                        </div>
                        <p class="text-sm text-gray-500 mt-2">{{ $task->tasks_done }} / {{ $task->total_tasks }} Tasks Done</p>
                    </div>
                @endif

                <div class="mt-6 flex justify-between">
                    <a href="{{ route('tasks.edit', $task->id) }}" class="text-blue-500 hover:underline">Edit</a>
                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('Are you sure to delete?')">Delete</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
