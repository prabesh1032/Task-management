@extends('layouts.userapp')

@section('title', 'My Tasks')

@section('content')

{{-- Summary Stats --}}
@php
    $totalTasksCount = $tasks->count();
    $completedCount  = $tasks->where('status', 'completed')->count();
    $inProgressCount = $tasks->where('status', 'in_progress')->count();
    $overdueCount    = $tasks->filter(fn($t) => $t->due_date->isPast() && $t->status !== 'completed')->count();
@endphp

<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex items-center gap-3">
        <div class="p-2.5 rounded-lg bg-indigo-50 text-indigo-600"><i class="ri-stack-line text-lg"></i></div>
        <div>
            <p class="text-xs text-gray-500">Total</p>
            <p class="text-xl font-bold text-gray-900">{{ $totalTasksCount }}</p>
        </div>
    </div>
    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex items-center gap-3">
        <div class="p-2.5 rounded-lg bg-blue-50 text-blue-600"><i class="ri-loader-4-line text-lg"></i></div>
        <div>
            <p class="text-xs text-gray-500">In Progress</p>
            <p class="text-xl font-bold text-gray-900">{{ $inProgressCount }}</p>
        </div>
    </div>
    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex items-center gap-3">
        <div class="p-2.5 rounded-lg bg-green-50 text-green-600"><i class="ri-checkbox-circle-line text-lg"></i></div>
        <div>
            <p class="text-xs text-gray-500">Completed</p>
            <p class="text-xl font-bold text-gray-900">{{ $completedCount }}</p>
        </div>
    </div>
    <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex items-center gap-3">
        <div class="p-2.5 rounded-lg bg-red-50 text-red-600"><i class="ri-alarm-warning-line text-lg"></i></div>
        <div>
            <p class="text-xs text-gray-500">Overdue</p>
            <p class="text-xl font-bold text-gray-900">{{ $overdueCount }}</p>
        </div>
    </div>
</div>

{{-- Task Grid --}}
@if($tasks->isEmpty())
<div class="flex flex-col items-center justify-center py-20 bg-white rounded-xl border border-gray-100">
    <div class="w-14 h-14 rounded-full bg-gray-100 flex items-center justify-center mb-3">
        <i class="ri-inbox-line text-2xl text-gray-400"></i>
    </div>
    <p class="text-sm font-medium text-gray-600">No tasks assigned</p>
    <p class="text-xs text-gray-400 mt-1">Check back later or contact your manager.</p>
</div>
@else
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
    @foreach($tasks as $task)
    @php
        $checklist      = json_decode($task->todo_checklist, true) ?? [];
        $totalItems     = count($checklist);
        $doneItems      = $totalItems > 0 ? array_sum($checklist) : 0;
        $progressPct    = $totalItems > 0 ? round(($doneItems / $totalItems) * 100) : 0;
        $progressColor  = $progressPct >= 80 ? 'bg-green-500' : ($progressPct <= 30 ? 'bg-red-400' : 'bg-blue-500');
        $isOverdue      = $task->status !== 'completed' && $task->due_date->isPast();

        $priorityClass = match($task->priority) {
            'high'   => 'bg-red-50 text-red-700 border border-red-100',
            'medium' => 'bg-amber-50 text-amber-700 border border-amber-100',
            default  => 'bg-green-50 text-green-700 border border-green-100',
        };
        $priorityDot = match($task->priority) {
            'high'   => 'bg-red-500',
            'medium' => 'bg-amber-500',
            default  => 'bg-green-500',
        };
        $statusClass = match($task->status) {
            'completed'   => 'bg-green-50 text-green-700 border border-green-100',
            'in_progress' => 'bg-blue-50 text-blue-700 border border-blue-100',
            default       => 'bg-amber-50 text-amber-700 border border-amber-100',
        };
    @endphp

    <div class="bg-white rounded-xl border border-gray-100 hover:border-indigo-200 hover:shadow-sm transition-all duration-150 flex flex-col">

        {{-- Card Top --}}
        <div class="px-5 pt-5 pb-4">

            {{-- Badges --}}
            <div class="flex items-center justify-between mb-3">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium {{ $priorityClass }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ $priorityDot }}"></span>
                    {{ ucfirst($task->priority) }}
                </span>
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $statusClass }}">
                    {{ str_replace('_', ' ', ucfirst($task->status)) }}
                </span>
            </div>

            {{-- Title + Description --}}
            <h2 class="text-sm font-semibold text-gray-900 mb-1 leading-snug">{{ $task->title }}</h2>
            <p class="text-xs text-gray-400 leading-relaxed line-clamp-2">
                {{ Str::limit($task->description, 100) }}
            </p>

            {{-- Meta --}}
            <div class="mt-3 space-y-1.5">
                <div class="flex items-center gap-2 text-xs text-gray-500">
                    <i class="ri-calendar-line text-gray-400"></i>
                    <span class="{{ $isOverdue ? 'text-red-500 font-medium' : '' }}">
                        {{ $task->due_date->format('d M, Y') }}
                        @if($isOverdue) · <span class="text-red-500">Overdue</span> @endif
                    </span>
                </div>
            </div>
        </div>

        {{-- Progress --}}
        @if($totalItems > 0)
        <div class="px-5 pb-4">
            <div class="flex justify-between items-center mb-1.5">
                <span class="text-xs text-gray-400">Progress</span>
                <span class="text-xs font-semibold {{ $progressPct >= 80 ? 'text-green-600' : ($progressPct <= 30 ? 'text-red-500' : 'text-blue-600') }}">
                    {{ $progressPct }}%
                </span>
            </div>
            <div class="w-full bg-gray-100 rounded-full h-1.5">
                <div class="{{ $progressColor }} h-1.5 rounded-full transition-all" style="width: {{ $progressPct }}%"></div>
            </div>
            <p class="text-xs text-gray-400 mt-1">{{ $doneItems }}/{{ $totalItems }} subtasks done</p>
        </div>
        @endif

        {{-- Footer --}}
        <div class="mt-auto px-5 py-3 border-t border-gray-100 flex items-center justify-between">
            <span class="text-xs text-gray-400">{{ $task->updated_at->diffForHumans() }}</span>
            <a href="{{ route('user.tasks.edit', $task->id) }}"
               class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-indigo-600 text-white text-xs font-medium rounded-lg hover:bg-indigo-700 transition-colors">
                <i class="ri-edit-box-line"></i> Update
            </a>
        </div>

    </div>
    @endforeach
</div>
@endif

@endsection
