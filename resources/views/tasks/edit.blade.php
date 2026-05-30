@extends('layouts.app')

@section('title', 'Update Task')

@section('content')

<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-xl border border-gray-100 overflow-hidden">

        {{-- Card Header --}}
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-indigo-50 flex items-center justify-center">
                    <i class="ri-edit-line text-indigo-600"></i>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-900">Update Task</p>
                    <p class="text-xs text-gray-400">Editing: {{ $task->title }}</p>
                </div>
            </div>
            <a href="{{ route('tasks.index') }}"
               class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400
                      hover:bg-gray-100 hover:text-gray-600 transition-colors">
                <i class="ri-close-line text-lg"></i>
            </a>
        </div>

        {{-- Form --}}
        <form action="{{ route('tasks.update', $task->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="p-6 space-y-5">

                {{-- Title --}}
                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        Task Title <span class="text-red-400">*</span>
                    </label>
                    <input type="text" name="title" required
                           value="{{ old('title', $task->title) }}"
                           placeholder="e.g. Design landing page"
                           class="w-full px-3.5 py-2.5 text-sm rounded-lg border border-gray-200
                                  bg-gray-50 text-gray-900 placeholder-gray-400
                                  focus:outline-none focus:ring-2 focus:ring-indigo-500
                                  focus:border-transparent focus:bg-white transition">
                    @error('title')
                    <p class="text-xs text-red-500 flex items-center gap-1">
                        <i class="ri-error-warning-line"></i> {{ $message }}
                    </p>
                    @enderror
                </div>

                {{-- Description --}}
                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        Description
                    </label>
                    <textarea name="description" rows="3"
                              placeholder="Describe the task in detail..."
                              class="w-full px-3.5 py-2.5 text-sm rounded-lg border border-gray-200
                                     bg-gray-50 text-gray-900 placeholder-gray-400
                                     focus:outline-none focus:ring-2 focus:ring-indigo-500
                                     focus:border-transparent focus:bg-white transition resize-none">{{ old('description', $task->description) }}</textarea>
                    @error('description')
                    <p class="text-xs text-red-500 flex items-center gap-1">
                        <i class="ri-error-warning-line"></i> {{ $message }}
                    </p>
                    @enderror
                </div>

                <div class="border-t border-gray-100"></div>

                {{-- Priority + Due Date + Assign + Status --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

                    {{-- Priority --}}
                    <div class="space-y-1.5">
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Priority <span class="text-red-400">*</span>
                        </label>
                        <select name="priority" required
                                class="w-full px-3.5 py-2.5 text-sm rounded-lg border border-gray-200
                                       bg-gray-50 text-gray-900
                                       focus:outline-none focus:ring-2 focus:ring-indigo-500
                                       focus:border-transparent focus:bg-white transition">
                            <option value="low"    {{ old('priority', $task->priority) == 'low'    ? 'selected' : '' }}>🟢 Low</option>
                            <option value="medium" {{ old('priority', $task->priority) == 'medium' ? 'selected' : '' }}>🟡 Medium</option>
                            <option value="high"   {{ old('priority', $task->priority) == 'high'   ? 'selected' : '' }}>🔴 High</option>
                        </select>
                        @error('priority')
                        <p class="text-xs text-red-500 flex items-center gap-1">
                            <i class="ri-error-warning-line"></i> {{ $message }}
                        </p>
                        @enderror
                    </div>

                    {{-- Status --}}
                    <div class="space-y-1.5">
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Status <span class="text-red-400">*</span>
                        </label>
                        <select name="status" required
                                class="w-full px-3.5 py-2.5 text-sm rounded-lg border border-gray-200
                                       bg-gray-50 text-gray-900
                                       focus:outline-none focus:ring-2 focus:ring-indigo-500
                                       focus:border-transparent focus:bg-white transition">
                            <option value="pending"     {{ old('status', $task->status) == 'pending'     ? 'selected' : '' }}>🟡 Pending</option>
                            <option value="in_progress" {{ old('status', $task->status) == 'in_progress' ? 'selected' : '' }}>🔵 In Progress</option>
                            <option value="completed"   {{ old('status', $task->status) == 'completed'   ? 'selected' : '' }}>🟢 Completed</option>
                        </select>
                        @error('status')
                        <p class="text-xs text-red-500 flex items-center gap-1">
                            <i class="ri-error-warning-line"></i> {{ $message }}
                        </p>
                        @enderror
                    </div>

                    {{-- Due Date --}}
                    <div class="space-y-1.5">
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Due Date <span class="text-red-400">*</span>
                        </label>
                        <input type="date" name="due_date" required
                               value="{{ old('due_date', $task->due_date->format('Y-m-d')) }}"
                               min="{{ now()->toDateString() }}"
                               class="w-full px-3.5 py-2.5 text-sm rounded-lg border border-gray-200
                                      bg-gray-50 text-gray-900
                                      focus:outline-none focus:ring-2 focus:ring-indigo-500
                                      focus:border-transparent focus:bg-white transition">
                        @error('due_date')
                        <p class="text-xs text-red-500 flex items-center gap-1">
                            <i class="ri-error-warning-line"></i> {{ $message }}
                        </p>
                        @enderror
                    </div>

                    {{-- Assign To --}}
                    <div class="space-y-1.5">
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Assign To <span class="text-red-400">*</span>
                        </label>
                        <select name="assigned_to" required
                                class="w-full px-3.5 py-2.5 text-sm rounded-lg border border-gray-200
                                       bg-gray-50 text-gray-900
                                       focus:outline-none focus:ring-2 focus:ring-indigo-500
                                       focus:border-transparent focus:bg-white transition">
                            <option value="">Select member...</option>
                            @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('assigned_to', $task->assigned_to) == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('assigned_to')
                        <p class="text-xs text-red-500 flex items-center gap-1">
                            <i class="ri-error-warning-line"></i> {{ $message }}
                        </p>
                        @enderror
                    </div>

                </div>

                <div class="border-t border-gray-100"></div>

                {{-- Checklist --}}
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            Checklist Items
                        </label>
                        <button type="button" id="add-checklist-item"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium
                                       text-indigo-600 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition-colors">
                            <i class="ri-add-line"></i> Add Item
                        </button>
                    </div>

                    <div id="checklist-container" class="space-y-2">
                        @php
                            $checklistItems = json_decode($task->todo_checklist, true) ?? [];
                            $checklistKeys  = array_keys($checklistItems);
                        @endphp

                        @if(count($checklistKeys) > 0)
                            @foreach($checklistKeys as $key)
                            <div class="flex items-center gap-2 checklist-item">
                                <div class="w-5 h-5 rounded flex-shrink-0 border-2 flex items-center justify-center
                                            {{ $checklistItems[$key] ? 'border-green-400 bg-green-50' : 'border-gray-200' }}">
                                    @if($checklistItems[$key])
                                    <i class="ri-check-line text-green-500 text-xs"></i>
                                    @else
                                    <i class="ri-checkbox-blank-circle-line text-gray-300 text-xs"></i>
                                    @endif
                                </div>
                                <input type="text" name="todo_checklist[]"
                                       value="{{ $key }}"
                                       class="flex-1 px-3.5 py-2 text-sm rounded-lg border border-gray-200
                                              bg-gray-50 text-gray-900 placeholder-gray-400
                                              focus:outline-none focus:ring-2 focus:ring-indigo-500
                                              focus:border-transparent focus:bg-white transition
                                              {{ $checklistItems[$key] ? 'line-through text-gray-400' : '' }}">
                                <button type="button"
                                        class="remove-checklist-item w-7 h-7 flex items-center justify-center
                                               rounded-lg text-gray-300 hover:bg-red-50 hover:text-red-500 transition-colors">
                                    <i class="ri-close-line text-base pointer-events-none"></i>
                                </button>
                            </div>
                            @endforeach
                        @else
                            <div class="flex items-center gap-2 checklist-item">
                                <div class="w-5 h-5 rounded flex-shrink-0 border-2 border-gray-200 flex items-center justify-center">
                                    <i class="ri-checkbox-blank-circle-line text-gray-300 text-xs"></i>
                                </div>
                                <input type="text" name="todo_checklist[]"
                                       placeholder="e.g. Write unit tests"
                                       class="flex-1 px-3.5 py-2 text-sm rounded-lg border border-gray-200
                                              bg-gray-50 text-gray-900 placeholder-gray-400
                                              focus:outline-none focus:ring-2 focus:ring-indigo-500
                                              focus:border-transparent focus:bg-white transition">
                                <button type="button"
                                        class="remove-checklist-item w-7 h-7 flex items-center justify-center
                                               rounded-lg text-gray-300 hover:bg-red-50 hover:text-red-500 transition-colors">
                                    <i class="ri-close-line text-base pointer-events-none"></i>
                                </button>
                            </div>
                        @endif
                    </div>
                </div>

            </div>

            {{-- Card Footer --}}
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex items-center justify-end gap-3">
                <a href="{{ route('tasks.index') }}"
                   class="px-4 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-200
                          rounded-lg hover:bg-gray-100 transition-colors">
                    Cancel
                </a>
                <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2 text-sm font-medium
                               text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg transition-colors">
                    <i class="ri-save-line"></i> Save Changes
                </button>
            </div>

        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
const newChecklistItem = () => `
    <div class="flex items-center gap-2 checklist-item">
        <div class="w-5 h-5 rounded flex-shrink-0 border-2 border-gray-200 flex items-center justify-center">
            <i class="ri-checkbox-blank-circle-line text-gray-300 text-xs"></i>
        </div>
        <input type="text" name="todo_checklist[]"
               placeholder="e.g. Write unit tests"
               class="flex-1 px-3.5 py-2 text-sm rounded-lg border border-gray-200
                      bg-gray-50 text-gray-900 placeholder-gray-400
                      focus:outline-none focus:ring-2 focus:ring-indigo-500
                      focus:border-transparent focus:bg-white transition">
        <button type="button"
                class="remove-checklist-item w-7 h-7 flex items-center justify-center
                       rounded-lg text-gray-300 hover:bg-red-50 hover:text-red-500 transition-colors">
            <i class="ri-close-line text-base pointer-events-none"></i>
        </button>
    </div>
`;

document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('checklist-container');
    const addBtn    = document.getElementById('add-checklist-item');

    addBtn.addEventListener('click', () => {
        container.insertAdjacentHTML('beforeend', newChecklistItem());
        container.lastElementChild.querySelector('input').focus();
    });

    container.addEventListener('click', function (e) {
        if (e.target.closest('.remove-checklist-item')) {
            const items = container.querySelectorAll('.checklist-item');
            const item  = e.target.closest('.checklist-item');
            if (items.length > 1) {
                item.remove();
            } else {
                item.querySelector('input').value = '';
            }
        }
    });
});
</script>
@endpush
