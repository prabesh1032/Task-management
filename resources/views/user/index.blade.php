@extends('layouts.userapp')

@section('title', 'My Tasks')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="text-center mb-10">
        <h1 class="text-3xl md:text-4xl font-bold text-gray-800">
            <i class="ri-task-line text-indigo-600 mr-2"></i> My Assigned Tasks
        </h1>
        <p class="mt-2 text-gray-600">Manage your current workload efficiently</p>
    </div>

    @if($tasks->isEmpty())
    <div class="bg-indigo-50 rounded-xl p-8 text-center max-w-2xl mx-auto">
        <i class="ri-inbox-line text-5xl text-indigo-400 mb-4"></i>
        <h3 class="text-xl font-medium text-gray-800">No tasks assigned</h3>
        <p class="text-gray-600 mt-2">You currently have no tasks. Check back later or contact your manager.</p>
    </div>
    @else
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        @foreach($tasks as $task)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
            <!-- Task Header -->
            <div class="bg-gradient-to-r from-indigo-50 to-white p-6 border-b border-gray-100">
                <div class="flex justify-between items-start">
                    <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                        <i class="ri-checkbox-circle-line text-indigo-500 mr-2"></i>
                        {{ $task->title }}
                    </h2>
                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                        @if($task->status === 'completed') bg-green-100 text-green-800
                        @elseif($task->status === 'in_progress') bg-blue-100 text-blue-800
                        @elseif($task->status === 'overdue') bg-red-100 text-red-800
                        @else bg-yellow-100 text-yellow-800 @endif">
                        {{ str_replace('_', ' ', ucfirst($task->status)) }}
                    </span>
                </div>
                <p class="mt-2 text-gray-600 text-sm">{{ $task->description }}</p>
            </div>

            <!-- Task Meta -->
            <div class="p-6 grid grid-cols-2 gap-4 text-sm">
                <div class="flex items-center">
                    <i class="ri-flag-line mr-2
                        @if($task->priority === 'high') text-red-500
                        @elseif($task->priority === 'medium') text-amber-500
                        @else text-green-500 @endif"></i>
                    <div>
                        <p class="text-gray-500">Priority</p>
                        <p class="font-medium">{{ ucfirst($task->priority) }}</p>
                    </div>
                </div>
                <div class="flex items-center">
                    <i class="ri-user-line mr-2 text-blue-500"></i>
                    <div>
                        <p class="text-gray-500">Assigned By</p>
                        <p class="font-medium">{{ $task->assignedBy->name ?? 'Admin' }}</p>
                    </div>
                </div>
                <div class="flex items-center">
                    <i class="ri-calendar-line mr-2 text-purple-500"></i>
                    <div>
                        <p class="text-gray-500">Due Date</p>
                        <p class="font-medium @if($task->due_date->isPast() && $task->status !== 'completed') text-red-500 @endif">
                            {{ $task->due_date->format('M j, Y') }}
                            @if($task->due_date->isPast() && $task->status !== 'completed')
                            <span class="text-xs ml-1">(Overdue)</span>
                            @endif
                        </p>
                    </div>
                </div>
                <div class="flex items-center">
                    <i class="ri-time-line mr-2 text-gray-500"></i>
                    <div>
                        <p class="text-gray-500">Assigned</p>
                        <p class="font-medium">{{ $task->created_at->diffForHumans() }}</p>
                    </div>
                </div>
            </div>

            <!-- Checklist Progress -->
            @php
                $checklist = json_decode($task->todo_checklist, true) ?? [];
                $completedCount = is_array($checklist) ? array_sum($checklist) : 0;
                $totalItems = is_array($checklist) ? count($checklist) : 0;
            @endphp

            @if($totalItems > 0)
            <div class="px-6 pb-4">
                <div class="flex justify-between items-center mb-1">
                    <p class="text-sm font-medium text-gray-700">Checklist Progress</p>
                    <p class="text-xs font-medium text-gray-500">
                        {{ $completedCount }}/{{ $totalItems }} completed
                    </p>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-indigo-600 h-2 rounded-full"
                         style="width: {{ ($totalItems > 0 ? round(($completedCount/$totalItems)*100) : 0) }}%"></div>
                </div>
            </div>
            @endif

            <!-- Task Footer -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-between items-center">
                <span class="text-xs text-gray-500">
                    Updated {{ $task->updated_at->diffForHumans() }}
                </span>
                <div class="space-x-2">

                    <a href="{{ route('user.tasks.edit', $task->id) }}"
                       class="inline-flex items-center bg-indigo-600 text-white text-sm font-medium py-1.5 px-3 rounded hover:bg-indigo-700 transition">
                        <i class="ri-edit-line mr-1"></i> Update
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection
