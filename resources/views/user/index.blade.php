@extends('layouts.userapp')

@section('title', 'My Tasks')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">

    @if($tasks->isEmpty())
    <div class="bg-gradient-to-br from-indigo-50 to-white border border-indigo-100 rounded-2xl p-12 text-center max-w-2xl mx-auto shadow-sm">
        <div class="w-20 h-20 rounded-full bg-indigo-100 flex items-center justify-center mx-auto mb-5">
            <i class="ri-inbox-line text-4xl text-indigo-400"></i>
        </div>
        <h3 class="text-xl font-semibold text-gray-800">No tasks assigned</h3>
        <p class="text-gray-500 mt-2">You currently have no tasks. Check back later or contact your manager.</p>
    </div>
    @else

    <!-- Summary stats bar -->
    @php
        $totalTasksCount = $tasks->count();
        $completedTasks = $tasks->where('status', 'completed')->count();
        $inProgressTasks = $tasks->where('status', 'in_progress')->count();
        $overdueTasks = $tasks->filter(fn($t) => $t->due_date->isPast() && $t->status !== 'completed')->count();
    @endphp
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8 max-w-5xl mx-auto">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex items-center gap-4">
            <div class="w-11 h-11 rounded-xl bg-gray-100 flex items-center justify-center text-gray-600"><i class="ri-stack-line text-xl"></i></div>
            <div>
                <p class="text-2xl font-bold text-gray-900 leading-none">{{ $totalTasksCount }}</p>
                <p class="text-xs text-gray-500 mt-1">Total Tasks</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex items-center gap-4">
            <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600"><i class="ri-loader-4-line text-xl"></i></div>
            <div>
                <p class="text-2xl font-bold text-gray-900 leading-none">{{ $inProgressTasks }}</p>
                <p class="text-xs text-gray-500 mt-1">In Progress</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex items-center gap-4">
            <div class="w-11 h-11 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600"><i class="ri-checkbox-circle-line text-xl"></i></div>
            <div>
                <p class="text-2xl font-bold text-gray-900 leading-none">{{ $completedTasks }}</p>
                <p class="text-xs text-gray-500 mt-1">Completed</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex items-center gap-4">
            <div class="w-11 h-11 rounded-xl bg-red-50 flex items-center justify-center text-red-600"><i class="ri-alarm-warning-line text-xl"></i></div>
            <div>
                <p class="text-2xl font-bold text-gray-900 leading-none">{{ $overdueTasks }}</p>
                <p class="text-xs text-gray-500 mt-1">Overdue</p>
            </div>
        </div>
    </div>

    <!-- Task Cards -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    @foreach($tasks as $task)
    @php
        $isOverdue = $task->due_date->isPast() && $task->status !== 'completed';

        // status color theme
        $statusTheme = match($task->status) {
            'completed'   => ['bg' => 'bg-emerald-500', 'badge' => 'bg-emerald-50 text-emerald-700 border-emerald-200', 'dot' => 'bg-emerald-500'],
            'in_progress' => ['bg' => 'bg-blue-500',    'badge' => 'bg-blue-50 text-blue-700 border-blue-200',    'dot' => 'bg-blue-500'],
            'overdue'     => ['bg' => 'bg-red-500',     'badge' => 'bg-red-50 text-red-700 border-red-200',        'dot' => 'bg-red-500'],
            default       => ['bg' => 'bg-amber-500',   'badge' => 'bg-amber-50 text-amber-700 border-amber-200',  'dot' => 'bg-amber-500'],
        };

        $priorityTheme = match($task->priority) {
            'high'   => ['text' => 'text-red-700',   'bg' => 'bg-red-50',   'icon' => 'ri-fire-fill', 'border' => 'border-red-200'],
            'medium' => ['text' => 'text-amber-700', 'bg' => 'bg-amber-50', 'icon' => 'ri-flag-fill', 'border' => 'border-amber-200'],
            default  => ['text' => 'text-emerald-700','bg' => 'bg-emerald-50','icon' => 'ri-leaf-fill', 'border' => 'border-emerald-200'],
        };

        $checklist = json_decode($task->todo_checklist, true) ?? [];
        $completedCount = is_array($checklist) ? array_sum($checklist) : 0;
        $totalItems = is_array($checklist) ? count($checklist) : 0;
        $checklistPct = $totalItems > 0 ? round(($completedCount / $totalItems) * 100) : 0;
    @endphp

    <div class="group relative bg-white rounded-xl border border-gray-200 overflow-hidden hover:shadow-lg hover:border-gray-300 transition-all duration-200">
        <!-- Top gradient bar based on priority -->
        <div class="p-5 pt-6">
            <!-- Header: Title + Status -->
            <div class="flex justify-between items-start gap-3 mb-4">
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 mb-2">
                        <div class="w-8 h-8 rounded-lg {{ $priorityTheme['bg'] }} flex items-center justify-center {{ $priorityTheme['text'] }}">
                            <i class="{{ $priorityTheme['icon'] }} text-sm"></i>
                        </div>
                        <h3 class="font-bold text-gray-900 text-lg truncate">{{ $task->title }}</h3>
                    </div>
                </div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold border {{ $statusTheme['badge'] }} shrink-0">
                    <span class="w-1.5 h-1.5 rounded-full {{ $statusTheme['dot'] }}"></span>
                    {{ str_replace('_', ' ', ucfirst($task->status)) }}
                </span>
            </div>

            <!-- Meta Info Grid -->
            <div class="grid grid-cols-2 gap-4 mb-4">
                <!-- Created At -->
                <div class="flex items-center gap-2.5 p-2 rounded-lg bg-gray-50/80">
                    <div class="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center text-purple-600">
                        <i class="ri-time-line text-sm"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Assigned</p>
                        <p class="text-sm font-semibold text-gray-800">{{ $task->created_at->diffForHumans() }}</p>
                    </div>
                </div>

                <!-- Due Date -->
                <div class="flex items-center gap-2.5 p-2 rounded-lg {{ $isOverdue ? 'bg-red-50/80' : 'bg-gray-50/80' }}">
                    <div class="w-8 h-8 rounded-full {{ $isOverdue ? 'bg-red-100 text-red-600' : 'bg-blue-100 text-blue-600' }} flex items-center justify-center">
                        <i class="ri-calendar-check-line text-sm"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Due Date</p>
                        <p class="text-sm font-semibold {{ $isOverdue ? 'text-red-600' : 'text-gray-800' }}">
                            {{ $task->due_date->format('M j, Y') }}
                            @if($isOverdue)
                                <span class="text-xs text-red-500 ml-1">(Overdue)</span>
                            @endif
                        </p>
                    </div>
                </div>

                <!-- Priority Tag -->
                <div class="flex items-center gap-2.5 p-2 rounded-lg bg-gray-50/80">
                    <div class="w-8 h-8 rounded-full {{ $priorityTheme['bg'] }} flex items-center justify-center {{ $priorityTheme['text'] }}">
                        <i class="ri-flag-fill text-sm"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Priority</p>
                        <p class="text-sm font-semibold {{ $priorityTheme['text'] }}">{{ ucfirst($task->priority) }}</p>
                    </div>
                </div>
            </div>

            <!-- Checklist Progress Section -->
            @if($totalItems > 0)
            <div class="mb-5 p-3 rounded-lg bg-indigo-50/30 border border-indigo-100">
                <div class="flex justify-between items-center mb-2">
                    <div class="flex items-center gap-2">
                        <i class="ri-checklist-line text-indigo-500 text-sm"></i>
                        <span class="text-sm font-semibold text-gray-700">Checklist Progress</span>
                    </div>
                    <span class="text-xs font-bold text-indigo-600 bg-indigo-100 px-2 py-0.5 rounded-full">{{ $completedCount }}/{{ $totalItems }}</span>
                </div>
                <div class="relative">
                    <div class="w-full bg-indigo-100 rounded-full h-2 overflow-hidden">
                        <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 h-2 rounded-full transition-all duration-700 ease-out"
                             style="width: {{ $checklistPct }}%"></div>
                    </div>
                    <p class="text-right text-xs text-gray-500 mt-1 font-medium">{{ $checklistPct }}% Complete</p>
                </div>
            </div>
            @endif

            <!-- Footer with Action Button -->
            <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                <div class="flex items-center gap-2 text-xs text-gray-400">
                    <i class="ri-history-line"></i>
                    <span>Updated {{ $task->updated_at->diffForHumans() }}</span>
                </div>
                <a href="{{ route('user.tasks.edit', $task->id) }}"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 hover:shadow-md transition-all duration-200 group-hover:scale-105">
                    <i class="ri-edit-box-line"></i>
                    Update Task
                    <i class="ri-arrow-right-line text-sm group-hover:translate-x-0.5 transition-transform"></i>
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>
    @endif
</div>
@endsection
