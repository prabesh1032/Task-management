@extends('layouts.userapp')

@section('title', 'Update Checklist')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b flex items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-lg bg-gradient-to-tr from-indigo-500 to-purple-500 flex items-center justify-center text-white shadow-sm">
                    <i class="ri-edit-line text-lg"></i>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-900">Update Checklist</p>
                    <p class="text-xs text-gray-400">{{ $task->title }}</p>
                    <div class="mt-1 flex items-center gap-2 text-xs">
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700">{{ ucfirst($task->priority) }}</span>
                        <span class="text-gray-400">Due {{ $task->due_date->format('M j, Y') }}</span>
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-3">
                @if($task->assignedTo)
                <div class="flex items-center gap-3">
                    <img src="{{ $task->assignedTo->profile_picture ?? asset('useravatar.avif') }}" alt="{{ $task->assignedTo->name }}" class="w-9 h-9 rounded-full border border-gray-100">
                    <div class="text-right">
                        <p class="text-sm font-medium text-gray-800">{{ $task->assignedTo->name }}</p>
                        <p class="text-xs text-gray-400">Assignee</p>
                    </div>
                </div>
                @endif
                <a href="{{ route('user.tasks.index') }}" class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:bg-gray-100 transition-colors">
                    <i class="ri-close-line text-lg"></i>
                </a>
            </div>
        </div>

        <form action="{{ route('user.tasks.update', $task->id) }}" method="POST">
            @csrf
            @method('PATCH')

            <div class="p-6 space-y-5">

                {{-- Task Info --}}
                <div>
                    <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Task Details</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-3 mb-4">
                        <div>
                            <h3 class="font-medium text-gray-700">Priority</h3>
                            <p class="text-gray-600 capitalize">{{ $task->priority }}</p>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-700">Due Date</h3>
                            <p class="text-gray-600">{{ $task->due_date->format('M j, Y') }}</p>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-700">Status</h3>
                            <p class="text-gray-600 capitalize">{{ str_replace('_', ' ', $task->status) }}</p>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h3 class="font-medium text-gray-700 mb-1">Description</h3>
                        <p class="text-gray-600">{{ $task->description ?? 'No description provided' }}</p>
                    </div>
                </div>

                {{-- Checklist --}}
                <div>
                    <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-3">Checklist Items</h2>

                        @if(count($checklist) > 0)
                            <div class="space-y-2 mb-6">
                                @foreach($checklist as $name => $isChecked)
                                <label class="group flex items-center justify-between p-3 rounded-lg border border-gray-100 hover:shadow-sm transition-colors bg-white"
                                       for="checklist-{{ $loop->index }}">
                                    <div class="flex items-center gap-3">
                                        <input type="checkbox"
                                               id="checklist-{{ $loop->index }}"
                                               name="checklist[{{ $name }}]"
                                               value="1"
                                               {{ $isChecked ? 'checked' : '' }}
                                               class="check-input w-5 h-5 text-indigo-600 rounded border-gray-300 focus:ring-indigo-500">
                                        <div class="flex flex-col">
                                            <span class="check-label text-gray-800">{{ $name }}</span>
                                            <span class="text-xs text-gray-400 mt-0.5">{{ $task->updated_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <button type="button" class="edit-item text-indigo-600 hover:text-indigo-800">Edit</button>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 mb-6">No checklist items available</p>
                        @endif
                </div>

            </div>

            <div class="px-6 py-4 bg-gray-50 border-t flex items-center justify-end gap-3">
                <a href="{{ route('user.tasks.index') }}" class="px-4 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-100 transition-colors">Cancel</a>
                <button type="submit" class="inline-flex items-center gap-2 px-5 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg transition-colors">
                    <i class="ri-save-line"></i> Update Checklist
                </button>
            </div>
        </form>

    </div>
</div>
@endsection

@push('styles')
<style>
    /* checked item style will be toggled via JS */
    .checked-item {
        background-color: #eef2ff; /* indigo-50 */
    }
    .checked-item .check-label { text-decoration: line-through; color: #9ca3af; }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.check-input').forEach(function (el) {
        // initialize state classes
        toggleCheckedClass(el);
        el.addEventListener('change', function () {
            toggleCheckedClass(el);
        });
    });

    function toggleCheckedClass(el) {
        const wrapper = el.closest('label.group');
        if (!wrapper) return;
        if (el.checked) wrapper.classList.add('checked-item'); else wrapper.classList.remove('checked-item');
    }
});
</script>
@endpush
