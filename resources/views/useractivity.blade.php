@extends('layouts.app')

@section('title', 'User Activity')

@section('content')
<div class="space-y-8">
    <!-- User Activity Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
        @forelse($users as $user)
        @php
            $total = max($user->pending_tasks_count + $user->in_progress_tasks_count + $user->completed_tasks_count, 1);
            $pendingPct = round(($user->pending_tasks_count / $total) * 100);
            $progressPct = round(($user->in_progress_tasks_count / $total) * 100);
            $completedPct = round(($user->completed_tasks_count / $total) * 100);
            $totalTasks = $user->pending_tasks_count + $user->in_progress_tasks_count + $user->completed_tasks_count;
        @endphp
        <div class="group bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <!-- Gradient banner -->
            <div class="h-16 bg-gradient-to-r {{ $user->is_admin ? 'from-purple-500 to-indigo-500' : 'from-sky-400 to-blue-500' }}"></div>

            <div class="px-5 pb-5 -mt-8">
                <div class="flex items-end justify-between">
                    <!-- User Avatar -->
                    <div class="relative">
                        <img class="h-16 w-16 rounded-2xl object-cover ring-4 ring-white shadow-md"
                            src="{{ $user->profile_picture ?: asset('useravatar.avif') }}"
                            alt="{{ $user->name }}">
                        <span class="absolute -bottom-0.5 -right-0.5 bg-green-500 rounded-full w-4 h-4 border-2 border-white" title="Online"></span>
                    </div>

                    <span class="px-3 py-1 rounded-full text-xs font-semibold mt-8
                        {{ $user->is_admin ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
                        <i class="{{ $user->is_admin ? 'ri-shield-star-line' : 'ri-user-3-line' }} mr-1"></i>
                        {{ $user->is_admin ? 'Admin' : 'Member' }}
                    </span>
                </div>

                <!-- User Info -->
                <div class="mt-3">
                    <h3 class="text-lg font-bold text-gray-900 truncate">{{ $user->name }}</h3>
                    <p class="text-sm text-gray-500 flex items-center truncate">
                        <i class="ri-mail-line mr-1.5 text-gray-400"></i>
                        <span class="truncate">{{ $user->email }}</span>
                    </p>
                </div>

                <!-- Combined progress bar -->
                <div class="mt-4">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-medium text-gray-500">Task Overview</span>
                        <span class="text-xs font-semibold text-gray-700">{{ $totalTasks }} total</span>
                    </div>
                    <div class="flex w-full h-2.5 rounded-full overflow-hidden bg-gray-100">
                        <div class="bg-blue-500 h-full transition-all duration-500" style="width: {{ $pendingPct }}%" title="Pending"></div>
                        <div class="bg-amber-400 h-full transition-all duration-500" style="width: {{ $progressPct }}%" title="In Progress"></div>
                        <div class="bg-emerald-500 h-full transition-all duration-500" style="width: {{ $completedPct }}%" title="Completed"></div>
                    </div>
                </div>

                <!-- Task stat chips -->
                <div class="mt-4 grid grid-cols-3 gap-2 text-center">
                    <div class="rounded-xl bg-blue-50 py-2.5">
                        <p class="text-lg font-bold text-blue-600 leading-none">{{ $user->pending_tasks_count }}</p>
                        <p class="text-[11px] font-medium text-blue-500/80 mt-1">Pending</p>
                    </div>
                    <div class="rounded-xl bg-amber-50 py-2.5">
                        <p class="text-lg font-bold text-amber-600 leading-none">{{ $user->in_progress_tasks_count }}</p>
                        <p class="text-[11px] font-medium text-amber-500/80 mt-1">In Progress</p>
                    </div>
                    <div class="rounded-xl bg-emerald-50 py-2.5">
                        <p class="text-lg font-bold text-emerald-600 leading-none">{{ $user->completed_tasks_count }}</p>
                        <p class="text-[11px] font-medium text-emerald-500/80 mt-1">Completed</p>
                    </div>
                </div>
            </div>

            <!-- Footer with action buttons -->
            @php
    $totalTasks = $user->pending_tasks_count + $user->in_progress_tasks_count + $user->completed_tasks_count;
    $rate = $totalTasks ? round(($user->completed_tasks_count / $totalTasks) * 100) : 0;
@endphp
<div class="bg-gray-50/80 px-5 py-3 border-t border-gray-100 flex items-center justify-between">
    <span class="text-xs font-medium text-gray-500">Completion Rate</span>
    <span class="text-sm font-bold {{ $rate >= 70 ? 'text-emerald-600' : ($rate >= 40 ? 'text-amber-600' : 'text-red-500') }}">
        {{ $rate }}%
    </span>
</div>

        </div>
        @empty
        <div class="col-span-full flex flex-col items-center justify-center py-16 text-center">
            <div class="w-20 h-20 rounded-full bg-gray-100 flex items-center justify-center mb-4">
                <i class="ri-user-search-line text-3xl text-gray-400"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-700">No users found</h3>
            <p class="text-sm text-gray-500 mt-1">There are no users to display right now.</p>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($users->hasPages())
    <div class="bg-white px-4 py-4 flex items-center justify-between border border-gray-100 rounded-2xl shadow-sm">
        <div class="flex-1 flex justify-between sm:hidden">
            @if($users->onFirstPage())
                <span class="relative inline-flex items-center px-4 py-2 border border-gray-200 text-sm font-medium rounded-xl text-gray-300 bg-white cursor-not-allowed">
                    Previous
                </span>
            @else
                <a href="{{ $users->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 border border-gray-200 text-sm font-medium rounded-xl text-gray-700 bg-white hover:bg-gray-50">
                    Previous
                </a>
            @endif

            @if($users->hasMorePages())
                <a href="{{ $users->nextPageUrl() }}" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-200 text-sm font-medium rounded-xl text-gray-700 bg-white hover:bg-gray-50">
                    Next
                </a>
            @else
                <span class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-200 text-sm font-medium rounded-xl text-gray-300 bg-white cursor-not-allowed">
                    Next
                </span>
            @endif
        </div>
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <p class="text-sm text-gray-600">
                Showing <span class="font-semibold text-gray-900">{{ $users->firstItem() }}</span>
                to <span class="font-semibold text-gray-900">{{ $users->lastItem() }}</span>
                of <span class="font-semibold text-gray-900">{{ $users->total() }}</span> results
            </p>
            <div>
                {{ $users->links() }}
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
