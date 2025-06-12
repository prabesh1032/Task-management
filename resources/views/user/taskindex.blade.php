@extends('layouts.userapp')

@section('title', 'My Tasks')

@section('content')
<div class="container mx-auto max-w-4xl">
    <h1 class="text-4xl font-extrabold text-gray-800 mb-8 text-center">
        <i class="ri-task-line text-indigo-600 mr-2"></i> My Assigned Tasks
    </h1>

    @if($tasks->isEmpty())
        <div class="bg-gray-100 p-6 rounded-lg shadow-lg text-center">
            <p class="text-lg text-gray-500 font-medium">🎉 You have no tasks assigned yet. Enjoy your free time!</p>
        </div>
    @else
        <div class="space-y-6">
            @foreach($tasks as $task)
                <div class="bg-white border border-gray-200 rounded-xl shadow-md p-6 transition-transform transform hover:scale-105">
                    <h2 class="text-2xl font-bold text-indigo-700 flex items-center">
                        <i class="ri-checkbox-circle-line mr-2"></i> {{ $task->title }}
                    </h2>
                    <p class="text-gray-700 mt-3 text-sm leading-relaxed">
                        {{ $task->description }}
                    </p>

                    <div class="mt-4 grid grid-cols-3 gap-4 text-sm text-gray-600">
                        <div class="flex items-center">
                            <i class="ri-flag-line text-yellow-500 mr-2"></i>
                            <span><strong>Priority:</strong> {{ ucfirst($task->priority) }}</span>
                        </div>
                        <div class="flex items-center">
                            <i class="ri-information-line text-blue-500 mr-2"></i>
                            <span><strong>Status:</strong> {{ ucfirst($task->status) }}</span>
                        </div>
                        <div class="flex items-center">
                            <i class="ri-calendar-line text-green-500 mr-2"></i>
                            <span><strong>Due Date:</strong> {{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}</span>
                        </div>
                    </div>

                    @if($task->todo_checklist)
                        <div class="mt-6">
                            <strong class="text-lg text-gray-800">TODO Checklist:</strong>
                            <ul class="list-disc list-inside text-gray-700 mt-2 space-y-1">
                                @foreach(json_decode($task->todo_checklist) as $checklistItem)
                                    <li class="flex items-center">
                                        <i class="ri-check-double-line text-green-500 mr-2"></i> {{ $checklistItem }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
