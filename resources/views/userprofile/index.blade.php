@extends('layouts.userapp')

@section('title', 'My Profile')

@section('content')

{{-- Success Message --}}
@if(session('success'))
<div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm flex items-center gap-2">
    <i class="ri-checkbox-circle-line text-green-500"></i>
    {{ session('success') }}
</div>
@endif

<div class="max-w-4xl mx-auto space-y-6">

    {{-- Profile Header Card --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-8">
            <div class="flex flex-col sm:flex-row items-center sm:items-end gap-5">
                {{-- Avatar --}}
                <div class="relative">
                    <img src="{{ $user->profile_picture ?: asset('useravatar.avif') }}"
                         alt="Profile Picture"
                         class="w-24 h-24 rounded-full border-4 border-white/30 object-cover shadow-lg">
                    <div class="absolute bottom-0 right-0 w-7 h-7 bg-white rounded-full flex items-center justify-center shadow">
                        <i class="ri-user-line text-indigo-600 text-sm"></i>
                    </div>
                </div>

                {{-- Name & Email --}}
                <div class="text-center sm:text-left flex-1">
                    <h1 class="text-2xl font-bold text-white">{{ $user->name }}</h1>
                    <p class="text-indigo-200 text-sm mt-0.5">{{ $user->email }}</p>
                    <div class="mt-2 inline-flex items-center gap-1.5 px-3 py-1 bg-white/20 rounded-full text-xs text-white font-medium">
                        <i class="ri-shield-star-line"></i>
                        {{ strtoupper($user->role ?? 'member') }}
                    </div>
                </div>

                {{-- Edit Button --}}
                <a href="{{ route('userprofile.edit') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-white/20 hover:bg-white/30 text-white text-sm font-medium rounded-lg border border-white/30 transition-colors">
                    <i class="ri-edit-line"></i> Edit Profile
                </a>
            </div>
        </div>

        {{-- Member Since --}}
        <div class="px-6 py-3 bg-gray-50 border-t border-gray-100 flex items-center gap-2 text-xs text-gray-500">
            <i class="ri-calendar-line"></i>
            Member since {{ $user->created_at->format('F j, Y') }}
        </div>
    </div>

    {{-- Stats Grid --}}
{{--
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-center gap-3">
            <div class="p-2.5 rounded-lg bg-indigo-50 text-indigo-600"><i class="ri-stack-line text-lg"></i></div>
            <div>
                <p class="text-xs text-gray-500">Total Tasks</p>
                <p class="text-xl font-bold text-gray-900">{{ $totalTasks }}</p>
            </div>
        </div>
        <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-center gap-3">
            <div class="p-2.5 rounded-lg bg-green-50 text-green-600"><i class="ri-checkbox-circle-line text-lg"></i></div>
            <div>
                <p class="text-xs text-gray-500">Completed</p>
                <p class="text-xl font-bold text-gray-900">{{ $completedTasks }}</p>
            </div>
        </div>
        <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-center gap-3">
            <div class="p-2.5 rounded-lg bg-blue-50 text-blue-600"><i class="ri-loader-4-line text-lg"></i></div>
            <div>
                <p class="text-xs text-gray-500">In Progress</p>
                <p class="text-xl font-bold text-gray-900">{{ $inProgressTasks }}</p>
            </div>
        </div>
        <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-center gap-3">
            <div class="p-2.5 rounded-lg bg-amber-50 text-amber-600"><i class="ri-time-line text-lg"></i></div>
            <div>
                <p class="text-xs text-gray-500">Pending</p>
                <p class="text-xl font-bold text-gray-900">{{ $pendingTasks }}</p>
            </div>
        </div>
    </div> --}}

    {{-- Personal Info + Recent Tasks --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- Personal Info --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
            <h2 class="text-sm font-semibold text-gray-800 mb-4">Personal Information</h2>
            <div class="space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-indigo-50 flex items-center justify-center text-indigo-600">
                        <i class="ri-user-line"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Full Name</p>
                        <p class="text-sm font-medium text-gray-900">{{ $user->name }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-indigo-50 flex items-center justify-center text-indigo-600">
                        <i class="ri-mail-line"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Email Address</p>
                        <p class="text-sm font-medium text-gray-900">{{ $user->email }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-indigo-50 flex items-center justify-center text-indigo-600">
                        <i class="ri-shield-star-line"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Role</p>
                        <p class="text-sm font-medium text-gray-900">{{ ucfirst($user->role ?? 'member') }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-indigo-50 flex items-center justify-center text-indigo-600">
                        <i class="ri-calendar-line"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Joined</p>
                        <p class="text-sm font-medium text-gray-900">{{ $user->created_at->format('F j, Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Recent Tasks --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
            <h2 class="text-sm font-semibold text-gray-800 mb-4">Recent Tasks</h2>
            @if($recentTasks->isEmpty())
            <div class="flex flex-col items-center justify-center py-8 text-center">
                <i class="ri-inbox-line text-2xl text-gray-300 mb-2"></i>
                <p class="text-xs text-gray-400">No tasks assigned yet</p>
            </div>
            @else
            <div class="space-y-3">
                @foreach($recentTasks as $task)
                @php
                    $statusColor = match($task->status) {
                        'completed'   => 'bg-green-50 text-green-700',
                        'in_progress' => 'bg-blue-50 text-blue-700',
                        default       => 'bg-amber-50 text-amber-700',
                    };
                    $priorityDot = match($task->priority) {
                        'high'   => 'bg-red-500',
                        'medium' => 'bg-amber-500',
                        default  => 'bg-green-500',
                    };
                @endphp
                <div class="flex items-center justify-between p-3 rounded-lg bg-gray-50 hover:bg-indigo-50/50 transition-colors">
                    <div class="flex items-center gap-2.5 min-w-0">
                        <span class="w-2 h-2 rounded-full {{ $priorityDot }} flex-shrink-0"></span>
                        <p class="text-sm font-medium text-gray-800 truncate">{{ $task->title }}</p>
                    </div>
                    <span class="text-xs px-2 py-0.5 rounded-full {{ $statusColor }} flex-shrink-0 ml-2">
                        {{ str_replace('_', ' ', ucfirst($task->status)) }}
                    </span>
                </div>
                @endforeach
            </div>
            <a href="{{ route('user.tasks.index') }}"
               class="mt-4 flex items-center justify-center gap-1.5 text-xs text-indigo-600 hover:text-indigo-800 font-medium">
                View all tasks <i class="ri-arrow-right-line"></i>
            </a>
            @endif
        </div>

    </div>

</div>
@endsection
