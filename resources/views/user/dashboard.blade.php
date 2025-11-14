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
    <!-- Dashboard Graphs -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <!-- Task Distribution Section -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Your Task Distribution</h2>
            <div class="chart-container" style="position: relative; height:300px; width:100%">
                <canvas id="distributionChart"></canvas>
            </div>
        </div>

        <!-- Task Priority Section -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Your Task Priority Levels</h2>
            <div class="chart-container" style="position: relative; height:300px; width:100%">
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
        // Task Distribution Chart (Pie)
        const distCtx = document.getElementById('distributionChart').getContext('2d');
        new Chart(distCtx, {
            type: 'pie',
            data: {
                labels: ['Pending', 'In Progress', 'Completed'],
                datasets: [{
                    data: [
                        {{ $pendingTasks }},
                        {{ $inProgressTasks }},
                        {{ $completedTasks }}
                    ],
                    backgroundColor: [
                        '#3b82f6', // Blue for Pending
                        '#f59e0b', // Amber for In Progress
                        '#10b981'  // Green for Completed
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `${context.label}: ${context.raw}`;
                            }
                        }
                    }
                }
            }
        });

        // Task Priority Chart (Bar)
        const priorityCtx = document.getElementById('priorityChart').getContext('2d');
        new Chart(priorityCtx, {
            type: 'bar',
            data: {
                labels: ['Low', 'Medium', 'High'],
                datasets: [{
                    label: 'Number of Tasks',
                    data: [
                        {{ $lowPriorityTasks }},
                        {{ $mediumPriorityTasks }},
                        {{ $highPriorityTasks }}
                    ],
                    backgroundColor: [
                        '#10b981', // Green for Low
                        '#f59e0b', // Amber for Medium
                        '#ef4444'  // Red for High
                    ],
                    borderColor: [
                        '#10b981',
                        '#f59e0b',
                        '#ef4444'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `${context.dataset.label}: ${context.raw}`;
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endpush
@endsection
