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
        <a href="{{ route('tasks.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded shadow hover:bg-blue-600 transition-colors">
            Add New Task
        </a>
    </div>

    <!-- Filter Buttons -->
    <div class="flex flex-wrap gap-2 mb-6">
        <!-- Status Filters -->
        <div class="flex items-center space-x-2 bg-gray-100 p-2 rounded-lg">
            <span class="text-sm font-medium text-gray-700">Status:</span>
            <a href="{{ request()->fullUrlWithQuery(['status' => null]) }}"
               class="px-3 py-1 text-sm rounded {{ !request()->has('status') ? 'bg-blue-500 text-white' : 'bg-gray-200 hover:bg-gray-300' }}">
                All
            </a>
            <a href="{{ request()->fullUrlWithQuery(['status' => 'pending']) }}"
               class="px-3 py-1 text-sm rounded {{ request()->input('status') === 'pending' ? 'bg-yellow-500 text-white' : 'bg-gray-200 hover:bg-gray-300' }}">
                Pending
            </a>
            <a href="{{ request()->fullUrlWithQuery(['status' => 'in_progress']) }}"
               class="px-3 py-1 text-sm rounded {{ request()->input('status') === 'in_progress' ? 'bg-blue-500 text-white' : 'bg-gray-200 hover:bg-gray-300' }}">
                In Progress
            </a>
            <a href="{{ request()->fullUrlWithQuery(['status' => 'completed']) }}"
               class="px-3 py-1 text-sm rounded {{ request()->input('status') === 'completed' ? 'bg-green-500 text-white' : 'bg-gray-200 hover:bg-gray-300' }}">
                Completed
            </a>
        </div>

        <!-- Priority Filters -->
        <div class="flex items-center space-x-2 bg-gray-100 p-2 rounded-lg">
            <span class="text-sm font-medium text-gray-700">Priority:</span>
            <a href="{{ request()->fullUrlWithQuery(['priority' => null]) }}"
               class="px-3 py-1 text-sm rounded {{ !request()->has('priority') ? 'bg-blue-500 text-white' : 'bg-gray-200 hover:bg-gray-300' }}">
                All
            </a>
            <a href="{{ request()->fullUrlWithQuery(['priority' => 'high']) }}"
               class="px-3 py-1 text-sm rounded {{ request()->input('priority') === 'high' ? 'bg-red-500 text-white' : 'bg-gray-200 hover:bg-gray-300' }}">
                High
            </a>
            <a href="{{ request()->fullUrlWithQuery(['priority' => 'medium']) }}"
               class="px-3 py-1 text-sm rounded {{ request()->input('priority') === 'medium' ? 'bg-yellow-500 text-white' : 'bg-gray-200 hover:bg-gray-300' }}">
                Medium
            </a>
            <a href="{{ request()->fullUrlWithQuery(['priority' => 'low']) }}"
               class="px-3 py-1 text-sm rounded {{ request()->input('priority') === 'low' ? 'bg-green-500 text-white' : 'bg-gray-200 hover:bg-gray-300' }}">
                Low
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($tasks as $task)
            @php
                // Calculate progress from checklist
                $checklist = json_decode($task->todo_checklist, true) ?? [];
                $totalTasks = count($checklist);
                $completedTasks = 0;

                if ($totalTasks > 0) {
                    $completedTasks = array_sum($checklist); // Counts all true values
                    $progressPercentage = round(($completedTasks / $totalTasks) * 100);
                } else {
                    $progressPercentage = 0;
                }

                // Determine progress bar color based on percentage
                $progressColor = 'bg-blue-500';
                if ($progressPercentage >= 80) {
                    $progressColor = 'bg-green-500';
                } elseif ($progressPercentage <= 30) {
                    $progressColor = 'bg-red-500';
                }
            @endphp

            <div class="bg-white p-6 rounded-lg shadow border hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-4">
                    <span class="px-3 py-1 text-sm font-medium rounded-full {{
                        $task->priority === 'high' ? 'bg-red-100 text-red-800' :
                        ($task->priority === 'medium' ? 'bg-yellow-100 text-yellow-800' :
                        'bg-green-100 text-green-800')
                    }}">
                        {{ ucfirst($task->priority) }} Priority
                    </span>
                    <span class="px-3 py-1 text-sm font-medium rounded-full {{
                        $task->status === 'completed' ? 'bg-green-100 text-green-800' :
                        ($task->status === 'in_progress' ? 'bg-blue-100 text-blue-800' :
                        'bg-yellow-100 text-yellow-800')
                    }}">
                        {{ str_replace('_', ' ', ucfirst($task->status)) }}
                    </span>
                </div>

                <h2 class="text-xl font-bold text-gray-800 mb-2">{{ $task->title }}</h2>
                <p class="text-gray-600 mb-4">{{ Str::limit($task->description, 100) }}</p>

                <div class="mb-4 space-y-1">
                    <p class="text-sm text-gray-500 flex items-center">
                        <i class="ri-calendar-line mr-2"></i>
                        <strong>Due:</strong> {{ $task->due_date->format('d M, Y') }}
                    </p>
                    <p class="text-sm text-gray-500 flex items-center">
                        <i class="ri-user-line mr-2"></i>
                        <strong>Assigned To:</strong> {{ $task->assignedTo->name ?? 'Unassigned' }}
                    </p>
                </div>

                @if($totalTasks > 0)
                    <div class="mt-4">
                        <div class="flex justify-between items-center mb-1">
                            <p class="text-sm font-medium text-gray-700">Progress</p>
                            <p class="text-xs font-medium {{
                                $progressPercentage >= 80 ? 'text-green-600' :
                                ($progressPercentage <= 30 ? 'text-red-600' : 'text-blue-600')
                            }}">
                                {{ $progressPercentage }}%
                            </p>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="{{ $progressColor }} h-2.5 rounded-full"
                                 style="width: {{ $progressPercentage }}%"></div>
                        </div>
                        <p class="text-xs text-gray-500 mt-1 text-right">
                            {{ $completedTasks }} of {{ $totalTasks }} tasks completed
                        </p>
                    </div>
                @endif

                <div class="mt-6 flex justify-between items-center">
                    <span class="text-xs text-gray-400">
                        Updated {{ $task->updated_at->diffForHumans() }}
                    </span>
                    <div class="flex gap-3">
                        <a href="{{ route('tasks.edit', $task->id) }}"
                           class="text-blue-500 hover:text-blue-700 transition-colors flex items-center">
                            <i class="ri-edit-line mr-1"></i> Edit
                        </a>
                        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="text-red-500 hover:text-red-700 transition-colors flex items-center"
                                    onclick="return confirm('Are you sure you want to delete this task?')">
                                <i class="ri-delete-bin-line mr-1"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
