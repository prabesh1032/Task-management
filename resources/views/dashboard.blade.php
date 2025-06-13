@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Task Distribution Section -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Task Distribution</h2>
        <div class="chart-container" style="position: relative; height:300px; width:100%">
            <canvas id="distributionChart"></canvas>
        </div>
    </div>

    <!-- Task Priority Section -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Task Priority Levels</h2>
        <div class="chart-container" style="position: relative; height:300px; width:100%">
            <canvas id="priorityChart"></canvas>
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
                        {{ $taskDistribution['pending'] ?? 0 }},
                        {{ $taskDistribution['in_progress'] ?? 0 }},
                        {{ $taskDistribution['completed'] ?? 0 }}
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
                        {{ $taskPriority['low'] ?? 0 }},
                        {{ $taskPriority['medium'] ?? 0 }},
                        {{ $taskPriority['high'] ?? 0 }}
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
