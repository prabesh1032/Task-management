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
    <!-- Top Stats (4 cards) -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex items-center gap-3">
            <div class="p-2.5 rounded-lg bg-indigo-50 text-indigo-600"><i class="ri-stack-line text-lg"></i></div>
            <div>
                <p class="text-xs text-gray-500">Total</p>
                <p class="text-xl font-bold text-gray-900">{{ $totalTasks ?? (($pendingTasks ?? 0) + ($inProgressTasks ?? 0) + ($completedTasks ?? 0) + ($overdueTasks ?? 0)) }}</p>
            </div>
        </div>

        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex items-center gap-3">
            <div class="p-2.5 rounded-lg bg-blue-50 text-blue-600"><i class="ri-loader-4-line text-lg"></i></div>
            <div>
                <p class="text-xs text-gray-500">In Progress</p>
                <p class="text-xl font-bold text-gray-900">{{ $inProgressTasks ?? 0 }}</p>
            </div>
        </div>

        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex items-center gap-3">
            <div class="p-2.5 rounded-lg bg-green-50 text-green-600"><i class="ri-checkbox-circle-line text-lg"></i></div>
            <div>
                <p class="text-xs text-gray-500">Completed</p>
                <p class="text-xl font-bold text-gray-900">{{ $completedTasks ?? 0 }}</p>
            </div>
        </div>

        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex items-center gap-3">
            <div class="p-2.5 rounded-lg bg-red-50 text-red-600"><i class="ri-alarm-warning-line text-lg"></i></div>
            <div>
                <p class="text-xs text-gray-500">Overdue</p>
                <p class="text-xl font-bold text-gray-900">{{ $overdueTasks ?? 0 }}</p>
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
