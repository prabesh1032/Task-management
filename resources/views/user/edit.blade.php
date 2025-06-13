@extends('layouts.userapp')

@section('title', 'Update Checklist')

@section('content')
<div class="container mx-auto mt-6 max-w-4xl">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">Update Checklist - {{ $task->title }}</h1>

    <div class="bg-white p-6 rounded-lg shadow-lg">
        <!-- Task Info -->
        <div class="mb-6">
            <h2 class="text-xl font-semibold mb-2">Task Details</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <div>
                    <h3 class="font-medium text-gray-700">Priority</h3>
                    <p class="text-gray-600 capitalize">{{ $task->priority }}</p>
                </div>
                <div>
                    <h3 class="font-medium text-gray-700">Due Date</h3>
                    <p class="text-gray-600">{{ $task->due_date->format('M j, Y') }}</p>
                </div>
                <div>
                    <h3 class="font-medium text-gray-700">Status</h3>
                    <p class="text-gray-600 capitalize">{{ str_replace('_', ' ', $task->status) }}</p>
                </div>
            </div>

            <div class="mb-4">
                <h3 class="font-medium text-gray-700 mb-1">Description</h3>
                <p class="text-gray-600">{{ $task->description ?? 'No description provided' }}</p>
            </div>
        </div>

        <!-- Checklist Form -->
        <form action="{{ route('user.tasks.update', $task->id) }}" method="POST">
            @csrf
            @method('PATCH')

            <h2 class="text-xl font-semibold mb-3">Checklist Items</h2>

            @if(count($checklist) > 0)
                <div class="space-y-3 mb-6">
                    @foreach($checklist as $name => $isChecked)
                    <div class="flex items-center">
                        <input
                            type="checkbox"
                            id="checklist-{{ $loop->index }}"
                            name="checklist[{{ $name }}]"
                            value="1"
                            {{ $isChecked ? 'checked' : '' }}
                            class="w-5 h-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500"
                        >
                        <label for="checklist-{{ $loop->index }}" class="ml-2 text-gray-700">{{ $name }}</label>
                    </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 mb-6">No checklist items available</p>
            @endif

            <div class="flex justify-end">
                <button
                    type="submit"
                    class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition-colors"
                >
                    Update Checklist
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
