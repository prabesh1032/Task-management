@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-xl border border-gray-100 p-5 flex items-center justify-between">
        <div>
            <p class="text-xs font-medium text-gray-500">Total Tasks</p>
            <p class="text-2xl font-semibold mt-1">{{ $totalTasks }}</p>
        </div>
        <div class="w-10 h-10 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
            <i class="ri-todo-line text-xl"></i>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-100 p-5 flex items-center justify-between">
        <div>
            <p class="text-xs font-medium text-gray-500">Completed</p>
            <p class="text-2xl font-semibold mt-1">{{ $completedTasks }}</p>
        </div>
        <div class="w-10 h-10 rounded-lg bg-green-50 text-green-600 flex items-center justify-center">
            <i class="ri-checkbox-circle-line text-xl"></i>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-100 p-5 flex items-center justify-between">
        <div>
            <p class="text-xs font-medium text-gray-500">Team Members</p>
            <p class="text-2xl font-semibold mt-1">{{ $teamMembersCount }}</p>
        </div>
        <div class="w-10 h-10 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center">
            <i class="ri-team-line text-xl"></i>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">

    <!-- Task Distribution -->
    <div class="bg-white rounded-xl border border-gray-100 p-5">
        <div class="mb-4">
            <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Task Distribution</h2>
        </div>
        <div style="position:relative; height:280px; width:100%">
            <canvas id="distributionChart"></canvas>
        </div>
    </div>

    <!-- Task Priority -->
    <div class="bg-white rounded-xl border border-gray-100 p-5">
        <div class="mb-4">
            <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Priority Levels</h2>
        </div>
        <div style="position:relative; height:280px; width:100%">
            <canvas id="priorityChart"></canvas>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const fontColor = '#6b7280';

    // Pie — Task Distribution
    new Chart(document.getElementById('distributionChart'), {
        type: 'doughnut',
        data: {
            labels: ['Pending', 'In Progress', 'Completed'],
            datasets: [{
                data: [
                    {{ $taskDistribution['pending'] ?? 0 }},
                    {{ $taskDistribution['in_progress'] ?? 0 }},
                    {{ $taskDistribution['completed'] ?? 0 }}
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
                    labels: {
                        color: fontColor,
                        font: { size: 12 },
                        padding: 16,
                        usePointStyle: true,
                        pointStyleWidth: 8
                    }
                },
                tooltip: {
                    callbacks: {
                        label: ctx => ` ${ctx.label}: ${ctx.raw} tasks`
                    }
                }
            }
        }
    });

    // Bar — Priority Levels
    new Chart(document.getElementById('priorityChart'), {
        type: 'bar',
        data: {
            labels: ['Low', 'Medium', 'High'],
            datasets: [{
                label: 'Tasks',
                data: [
                    {{ $taskPriority['low'] ?? 0 }},
                    {{ $taskPriority['medium'] ?? 0 }},
                    {{ $taskPriority['high'] ?? 0 }}
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
                x: {
                    grid: { display: false },
                    ticks: { color: fontColor, font: { size: 12 } }
                },
                y: {
                    beginAtZero: true,
                    grid: { color: '#f3f4f6' },
                    ticks: { precision: 0, color: fontColor, font: { size: 12 } }
                }
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => ` ${ctx.raw} tasks`
                    }
                }
            }
        }
    });

});
</script>
@endpush
