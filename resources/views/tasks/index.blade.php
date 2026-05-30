@extends('layouts.app')

@section('title', 'My Tasks')

@section('content')

{{-- Toolbar --}}
<div class="flex flex-wrap items-center justify-between gap-3 mb-5">
    <div class="flex-1 flex flex-wrap items-center gap-2">
        <p class="text-sm text-gray-500 mr-2 hidden sm:block">
            Showing
            <span class="font-medium">{{ $tasks->firstItem() ?? 0 }}</span>
            –
            <span class="font-medium">{{ $tasks->lastItem() ?? 0 }}</span>
            of
            <span class="font-medium">{{ $tasks->total() }}</span>
            tasks
        </p>

        {{-- Status Filter --}}
        <div class="flex items-center gap-1 bg-white border border-gray-200 rounded-lg p-1">
            <a href="{{ request()->fullUrlWithQuery(['status' => null]) }}"
               class="px-3 py-1.5 text-xs font-medium rounded-md transition-colors
                      {{ !request()->has('status') ? 'bg-indigo-600 text-white' : 'text-gray-500 hover:bg-gray-100' }}">
                All
            </a>
            <a href="{{ request()->fullUrlWithQuery(['status' => 'pending']) }}"
               class="px-3 py-1.5 text-xs font-medium rounded-md transition-colors
                      {{ request()->input('status') === 'pending' ? 'bg-amber-500 text-white' : 'text-gray-500 hover:bg-gray-100' }}">
                Pending
            </a>
            <a href="{{ request()->fullUrlWithQuery(['status' => 'in_progress']) }}"
               class="px-3 py-1.5 text-xs font-medium rounded-md transition-colors
                      {{ request()->input('status') === 'in_progress' ? 'bg-blue-500 text-white' : 'text-gray-500 hover:bg-gray-100' }}">
                In Progress
            </a>
            <a href="{{ request()->fullUrlWithQuery(['status' => 'completed']) }}"
               class="px-3 py-1.5 text-xs font-medium rounded-md transition-colors
                      {{ request()->input('status') === 'completed' ? 'bg-green-500 text-white' : 'text-gray-500 hover:bg-gray-100' }}">
                Completed
            </a>
        </div>

        {{-- Priority Filter --}}
        <div class="flex items-center gap-1 bg-white border border-gray-200 rounded-lg p-1">
            <a href="{{ request()->fullUrlWithQuery(['priority' => null]) }}"
               class="px-3 py-1.5 text-xs font-medium rounded-md transition-colors
                      {{ !request()->has('priority') ? 'bg-indigo-600 text-white' : 'text-gray-500 hover:bg-gray-100' }}">
                All
            </a>
            <a href="{{ request()->fullUrlWithQuery(['priority' => 'high']) }}"
               class="px-3 py-1.5 text-xs font-medium rounded-md transition-colors
                      {{ request()->input('priority') === 'high' ? 'bg-red-500 text-white' : 'text-gray-500 hover:bg-gray-100' }}">
                High
            </a>
            <a href="{{ request()->fullUrlWithQuery(['priority' => 'medium']) }}"
               class="px-3 py-1.5 text-xs font-medium rounded-md transition-colors
                      {{ request()->input('priority') === 'medium' ? 'bg-amber-500 text-white' : 'text-gray-500 hover:bg-gray-100' }}">
                Medium
            </a>
            <a href="{{ request()->fullUrlWithQuery(['priority' => 'low']) }}"
               class="px-3 py-1.5 text-xs font-medium rounded-md transition-colors
                      {{ request()->input('priority') === 'low' ? 'bg-green-500 text-white' : 'text-gray-500 hover:bg-gray-100' }}">
                Low
            </a>
        </div>

    </div>

    {{-- Add Task Button (with mobile summary) --}}
    <div class="flex items-center gap-2">
        <p class="text-sm text-gray-500 sm:hidden">
            Showing <span class="font-medium">{{ $tasks->firstItem() ?? 0 }}</span>
            – <span class="font-medium">{{ $tasks->lastItem() ?? 0 }}</span>
            of <span class="font-medium">{{ $tasks->total() }}</span>
        </p>
        <a href="{{ route('tasks.create') }}"
           class="inline-flex items-center gap-2 sm:gap-2 px-3 py-1.5 sm:px-4 sm:py-2 bg-indigo-600 hover:bg-indigo-700
                  text-white text-sm font-medium rounded-lg transition-colors flex-shrink-0">
            <i class="ri-add-line"></i> Add New Task
        </a>
    </div>
</div>

{{-- Task Grid --}}
@if($tasks->isEmpty())
<div class="flex flex-col items-center justify-center py-20 bg-white rounded-xl border border-gray-100">
    <div class="w-14 h-14 rounded-full bg-gray-100 flex items-center justify-center mb-3">
        <i class="ri-task-line text-2xl text-gray-400"></i>
    </div>
    <p class="text-sm font-medium text-gray-600">No tasks found</p>
    <p class="text-xs text-gray-400 mt-1">Try changing filters or create a new task</p>
    <a href="{{ route('tasks.create') }}"
       class="mt-4 inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium
              text-indigo-600 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition-colors">
        <i class="ri-add-line"></i> Create first task
    </a>
</div>
@else
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
    @foreach($tasks as $task)
    @php
        $checklist         = json_decode($task->todo_checklist, true) ?? [];
        $totalTasks        = count($checklist);
        $completedTasks    = $totalTasks > 0 ? array_sum($checklist) : 0;
        $progressPct       = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;

        $progressColor = $progressPct >= 80 ? 'bg-green-500' : ($progressPct <= 30 ? 'bg-red-400' : 'bg-blue-500');

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

        $isOverdue = $task->status !== 'completed' && $task->due_date->isPast();
    @endphp

    <div class="bg-white rounded-xl border border-gray-100 hover:border-indigo-200 hover:shadow-sm
                transition-all duration-150 flex flex-col">

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
                <div class="flex items-center gap-2 text-xs text-gray-500">
                    <i class="ri-user-line text-gray-400"></i>
                    <span>{{ $task->assignedTo->name ?? 'Unassigned' }}</span>
                </div>
            </div>

        </div>

        {{-- Progress --}}
        @if($totalTasks > 0)
        <div class="px-5 pb-4">
            <div class="flex justify-between items-center mb-1.5">
                <span class="text-xs text-gray-400">Progress</span>
                <span class="text-xs font-semibold
                    {{ $progressPct >= 80 ? 'text-green-600' : ($progressPct <= 30 ? 'text-red-500' : 'text-blue-600') }}">
                    {{ $progressPct }}%
                </span>
            </div>
            <div class="w-full bg-gray-100 rounded-full h-1.5">
                <div class="{{ $progressColor }} h-1.5 rounded-full transition-all"
                     style="width: {{ $progressPct }}%"></div>
            </div>
            <p class="text-xs text-gray-400 mt-1">{{ $completedTasks }}/{{ $totalTasks }} subtasks done</p>
        </div>
        @endif

        {{-- Card Footer --}}
        <div class="mt-auto px-5 py-3 border-t border-gray-100 flex items-center justify-between">
            <span class="text-xs text-gray-400">
                {{ $task->updated_at->diffForHumans() }}
            </span>
            <div class="flex items-center gap-1">
                <a href="{{ route('tasks.edit', $task->id) }}"
                   title="Edit"
                   class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400
                          hover:bg-indigo-50 hover:text-indigo-600 transition-colors">
                    <i class="ri-pencil-line text-base"></i>
                </a>
                <button type="button"
                        data-url="{{ route('tasks.destroy', $task->id) }}"
                        data-title="{{ $task->title }}"
                        title="Delete"
                        class="task-delete-btn w-8 h-8 flex items-center justify-center rounded-lg text-gray-400
                               hover:bg-red-50 hover:text-red-600 transition-colors">
                    <i class="ri-delete-bin-line text-base"></i>
                </button>
            </div>
        </div>

    </div>
    @endforeach
</div>
    @endif

    {{-- Pagination for tasks --}}
    @if($tasks->hasPages())
        <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6 mt-4 rounded-xl">
            <div class="flex-1 flex justify-between sm:hidden">
                <a href="{{ $tasks->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Previous
                </a>
                <a href="{{ $tasks->nextPageUrl() }}" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Next
                </a>
            </div>
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm text-gray-700">
                        Showing
                        <span class="font-medium">{{ $tasks->firstItem() }}</span>
                        to
                        <span class="font-medium">{{ $tasks->lastItem() }}</span>
                        of
                        <span class="font-medium">{{ $tasks->total() }}</span>
                        results
                    </p>
                </div>
                <div>
                    {{ $tasks->links() }}
                </div>
            </div>
        </div>
    @endif

@endsection

<!-- Delete Confirmation Modal for Tasks -->
<div id="taskDeleteModal" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
        <h3 class="text-lg font-semibold mb-2">Delete Task</h3>
        <p id="taskDeleteModalText" class="text-sm text-gray-600 mb-4">Are you sure you want to delete this task? This action cannot be undone.</p>

        <form id="taskDeleteForm" method="POST" action="">
            @csrf
            @method('DELETE')
            <div class="flex justify-end gap-2">
                <button type="button" id="cancelTaskDelete" class="px-4 py-2 bg-gray-100 rounded">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded">Delete</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('taskDeleteModal');
    const deleteForm = document.getElementById('taskDeleteForm');
    const deleteModalText = document.getElementById('taskDeleteModalText');
    const cancelBtn = document.getElementById('cancelTaskDelete');
    const submitBtn = deleteForm.querySelector('button[type="submit"]');

    let lastClicked = null;
    let submitting = false;

    document.querySelectorAll('.task-delete-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const url = btn.getAttribute('data-url');
            const title = btn.getAttribute('data-title');
            deleteForm.action = url;
            deleteModalText.textContent = `Are you sure you want to delete "${title}"? This action cannot be undone.`;
            lastClicked = btn;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        });
    });

    deleteForm.addEventListener('submit', function (e) {
        if (submitting) {
            e.preventDefault();
            return;
        }
        submitting = true;
        if (submitBtn) submitBtn.disabled = true;
        if (lastClicked) lastClicked.disabled = true;
    });

    cancelBtn.addEventListener('click', function () {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        if (submitBtn) submitBtn.disabled = false;
        if (lastClicked) lastClicked.disabled = false;
        submitting = false;
        lastClicked = null;
    });

    modal.addEventListener('click', function (e) {
        if (e.target === modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            if (submitBtn) submitBtn.disabled = false;
            if (lastClicked) lastClicked.disabled = false;
            submitting = false;
            lastClicked = null;
        }
    });
});
</script>
@endpush
