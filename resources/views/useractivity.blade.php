@extends('layouts.app')

@section('title', 'User Activity')

@section('content')
<div class="space-y-6">
    <!-- Header with search and filter -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <h2 class="text-2xl font-bold text-gray-800">User Activity</h2>

    </div>
    <!-- User Activity Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @foreach($users as $user)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow duration-200">
            <div class="p-5">
                <div class="flex items-start">
                    <!-- User Avatar -->
                    <div class="flex-shrink-0 relative">
                        <img class="h-10 w-10 rounded-full object-cover"
                            src="{{ $user->profile_picture ? asset('images/' . $user->profile_picture) : asset('useravatar.avif') }}"
                            alt="{{ $user->name }}">
                        <span class="absolute bottom-0 right-0 bg-green-500 rounded-full w-3 h-3 border-2 border-white"></span>
                    </div>

                    <!-- User Info -->
                    <div class="ml-4 flex-1">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">{{ $user->name }}</h3>
                                <p class="text-sm text-gray-500 flex items-center">
                                    <i class="ri-mail-line mr-1"></i> {{ $user->email }}
                                </p>
                            </div>
                            <span class="px-2 py-1 rounded-full text-xs font-medium
                                {{ $user->is_admin ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $user->is_admin ? 'Admin' : 'Member' }}
                            </span>
                        </div>

                        <!-- Task Stats with Progress Bars -->
                        <div class="mt-4 space-y-3">
                            <!-- Pending Tasks -->
                            <div>
                                <div class="flex justify-between text-xs text-gray-500 mb-1">
                                    <span>Pending ({{ $user->pending_tasks_count }})</span>
                                    <span>{{ $user->pending_tasks_count }} tasks</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-blue-500 h-2 rounded-full"
                                         style="width: {{ ($user->pending_tasks_count / max($user->pending_tasks_count + $user->in_progress_tasks_count + $user->completed_tasks_count, 1)) * 100 }}%"></div>
                                </div>
                            </div>

                            <!-- In Progress Tasks -->
                            <div>
                                <div class="flex justify-between text-xs text-gray-500 mb-1">
                                    <span>In Progress ({{ $user->in_progress_tasks_count }})</span>
                                    <span>{{ $user->in_progress_tasks_count }} tasks</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-yellow-500 h-2 rounded-full"
                                         style="width: {{ ($user->in_progress_tasks_count / max($user->pending_tasks_count + $user->in_progress_tasks_count + $user->completed_tasks_count, 1)) * 100 }}%"></div>
                                </div>
                            </div>

                            <!-- Completed Tasks -->
                            <div>
                                <div class="flex justify-between text-xs text-gray-500 mb-1">
                                    <span>Completed ({{ $user->completed_tasks_count }})</span>
                                    <span>{{ $user->completed_tasks_count }} tasks</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-green-500 h-2 rounded-full"
                                         style="width: {{ ($user->completed_tasks_count / max($user->pending_tasks_count + $user->in_progress_tasks_count + $user->completed_tasks_count, 1)) * 100 }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer with action buttons -->
            <div class="bg-gray-50 px-5 py-3 border-t border-gray-200 flex justify-end space-x-3">
                <button class="text-indigo-600 hover:text-indigo-900 p-2 rounded-full hover:bg-indigo-50">
                    <i class="ri-chat-3-line"></i>
                </button>
                <button class="text-gray-600 hover:text-gray-900 p-2 rounded-full hover:bg-gray-100">
                    <i class="ri-user-settings-line"></i>
                </button>
                <button class="text-blue-600 hover:text-blue-900 p-2 rounded-full hover:bg-blue-50">
                    <i class="ri-task-line"></i>
                </button>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    @if($users->hasPages())
    <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6 rounded-b-lg">
        <div class="flex-1 flex justify-between sm:hidden">
            @if($users->onFirstPage())
                <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-300 bg-white">
                    Previous
                </span>
            @else
                <a href="{{ $users->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Previous
                </a>
            @endif

            @if($users->hasMorePages())
                <a href="{{ $users->nextPageUrl() }}" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Next
                </a>
            @else
                <span class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-300 bg-white">
                    Next
                </span>
            @endif
        </div>
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-700">
                    Showing <span class="font-medium">{{ $users->firstItem() }}</span>
                    to <span class="font-medium">{{ $users->lastItem() }}</span>
                    of <span class="font-medium">{{ $users->total() }}</span> results
                </p>
            </div>
            <div>
                {{ $users->links() }}
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
