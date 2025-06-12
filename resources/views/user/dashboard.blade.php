@extends('layouts.userapp')

@section('title', 'Member Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Welcome Section -->
    <h1 class="text-4xl font-bold mb-6 text-gray-800">
        Welcome back, {{ auth()->user()->name }}!
    </h1>
    <p class="text-gray-500 mb-8">
        Here's a quick overview of your tasks and recent updates.
    </p>

    <!-- Dashboard Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-2">
        <!-- Task Summary Card -->
        <div class="bg-white p-6">
            <h2 class="text-xl font-semibold text-gray-700 mb-4 flex items-center">
                <i class="ri-task-line text-indigo-600 text-2xl mr-2"></i> Task Summary
            </h2>
            <ul class="space-y-3 text-gray-600">
                <li class="flex justify-between">
                    <span>Total Tasks:</span>
                    <span class="font-semibold text-gray-900">{{ $totalTasks }}</span>
                </li>
                <li class="flex justify-between">
                    <span>Pending Tasks:</span>
                    <span class="font-semibold text-yellow-600">{{ $pendingTasks }}</span>
                </li>
                <li class="flex justify-between">
                    <span>In Progress:</span>
                    <span class="font-semibold text-blue-600">{{ $inProgressTasks }}</span>
                </li>
                <li class="flex justify-between">
                    <span>Completed Tasks:</span>
                    <span class="font-semibold text-green-600">{{ $completedTasks }}</span>
                </li>
                <li class="flex justify-between">
                    <span>Overdue Tasks:</span>
                    <span class="font-semibold text-red-600">{{ $overdueTasks }}</span>
                </li>
            </ul>
            <a href="{{ route('tasks.index') }}" class="mt-6 inline-block text-sm font-medium text-indigo-600 hover:text-indigo-800">
                View all tasks &rarr;
            </a>
        </div>
    </div>

    <!-- Recent Activities Section -->
<!-- Recent Activities Section -->
<div class="bg-white shadow-md rounded-lg overflow-hidden mt-16">
    <div class="p-6">
        <h2 class="text-2xl font-bold text-indigo-700 flex items-center space-x-3">
            <i class="ri-timer-line text-3xl"></i>
            <span>Recent Activities</span>
        </h2>
        <p class="text-sm text-gray-500 mt-2">Keep track of your latest tasks and progress.</p>
    </div>
    <div class="p-6">
        @if($recentTasks->count())
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-indigo-100 text-indigo-800 uppercase text-sm font-semibold">
                        <th class="px-6 py-4">Task</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Due Date</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentTasks as $task)
                    <tr class="bg-red-100 transition duration-150">
                        <td class="px-6 py-4 font-medium text-gray-800">{{ $task->title }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold
                                @if($task->status == 'pending') bg-yellow-100 text-yellow-700
                                @elseif($task->status == 'in_progress') bg-blue-100 text-blue-700
                                @elseif($task->status == 'completed') bg-green-100 text-green-700
                                @elseif($task->status == 'overdue') bg-red-100 text-red-700
                                @else bg-gray-100 text-gray-700
                                @endif">
                                {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">{{ $task->due_date ? $task->due_date->format('M d, Y') : 'N/A' }}</td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('user.tasks.index') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 space-x-1">
                                <i class="ri-eye-line"></i>
                                <span>View</span>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p class="text-center text-gray-500 italic mt-4">No recent tasks assigned.</p>
        @endif
    </div>
</div>
</div>
@endsection
