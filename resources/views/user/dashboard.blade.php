@extends('layouts.userapp')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Welcome Section -->
    <h1 class="text-4xl font-bold mb-6 text-gray-800">
        Welcome back, {{ auth()->user()->name }}!
    </h1>
    <p class="text-gray-500 mb-8">
        Here's a quick overview of your tasks and recent updates.
    </p>
    <!-- Top Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-xl border border-gray-100 p-5 flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-gray-500">Total Tasks</p>
                <p class="text-2xl font-semibold mt-1">{{ ($pendingTasks ?? 0) + ($inProgressTasks ?? 0) + ($completedTasks ?? 0) }}</p>
            </div>
            <div class="w-10 h-10 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
                <i class="ri-todo-line text-xl"></i>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-100 p-5 flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-gray-500">Completed</p>
                <p class="text-2xl font-semibold mt-1">{{ $completedTasks ?? 0 }}</p>
            </div>
            <div class="w-10 h-10 rounded-lg bg-green-50 text-green-600 flex items-center justify-center">
                <i class="ri-checkbox-circle-line text-xl"></i>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-100 p-5 flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-gray-500">Team Members</p>
                <p class="text-2xl font-semibold mt-1">{{ $teamMembersCount ?? 0 }}</p>
            </div>
            <div class="w-10 h-10 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center">
                <i class="ri-team-line text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Dashboard Graphs -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <!-- Task Distribution Section -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Your Task Distribution</h2>
            <div style="position:relative; height:280px; width:100%">
                <canvas id="distributionChart"></canvas>
            </div>
        </div>

        <!-- Task Priority Section -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Your Task Priority Levels</h2>
            <div style="position:relative; height:280px; width:100%">
                <canvas id="priorityChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Recent Activities Section -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden mt-6">
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
                        <tr class="hover:bg-gray-50 transition duration-150">
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
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fontColor = '#6b7280';

        // Distribution — doughnut (matches admin)
        new Chart(document.getElementById('distributionChart'), {
            type: 'doughnut',
            data: {
                labels: ['Pending', 'In Progress', 'Completed'],
                datasets: [{
                    data: [
                        {{ $pendingTasks ?? 0 }},
                        {{ $inProgressTasks ?? 0 }},
                        {{ $completedTasks ?? 0 }}
                    ],
                    backgroundColor: ['#3b82f6', '#f59e0b', '#10b981'],
                    borderWidth: 2,
                    borderColor: '#ffffff',
                    hoverOffset: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '60%',
                plugins: {
                    legend: {
                        position: 'right',
                        labels: { color: fontColor, font: { size: 12 }, padding: 16, usePointStyle: true, pointStyleWidth: 8 }
                    },
                    tooltip: {
                        callbacks: { label: ctx => ` ${ctx.label}: ${ctx.raw} tasks` }
                    }
                }
            }
        });

        // Priority — bar (matches admin options)
        new Chart(document.getElementById('priorityChart'), {
            type: 'bar',
            data: {
                labels: ['Low', 'Medium', 'High'],
                datasets: [{
                    label: 'Tasks',
                    data: [
                        {{ $lowPriorityTasks ?? 0 }},
                        {{ $mediumPriorityTasks ?? 0 }},
                        {{ $highPriorityTasks ?? 0 }}
                    ],
                    backgroundColor: ['#10b981', '#f59e0b', '#ef4444'],
                    borderRadius: 6,
                    borderWidth: 0,
                    maxBarThickness: 48
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: { grid: { display: false }, ticks: { color: fontColor, font: { size: 12 } } },
                    y: { beginAtZero: true, grid: { color: '#f3f4f6' }, ticks: { precision: 0, color: fontColor, font: { size: 12 } } }
                },
                plugins: {
                    legend: { display: false },
                    tooltip: { callbacks: { label: ctx => ` ${ctx.raw} tasks` } }
                }
            }
        });
    });
</script>
@endpush
@endsection
