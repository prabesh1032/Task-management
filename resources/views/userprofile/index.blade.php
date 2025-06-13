@extends('layouts.userapp')

@section('title', 'My Profile')

@section('content')
<div class="container mx-auto max-w-4xl py-8">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <!-- Profile Header -->
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 p-6 text-white">
            <a href="{{ route('userprofile.edit') }}"
               class="absolute top-4 right-4 flex items-center px-4 py-2 bg-white/20 hover:bg-white/30 text-white rounded-lg transition-all duration-200 border border-white/30">
                <i class="ri-edit-line mr-2"></i> Edit Profile
            </a>
            <div class="flex flex-col md:flex-row items-center">
                <div class="relative mb-4 md:mb-0">
                    <img src="{{ $user->profile_picture ? asset('images/' . $user->profile_picture) : asset('useravatar.avif') }}"
                         alt="Profile Picture"
                         class="w-24 h-24 md:w-32 md:h-32 rounded-full border-4 border-white/20 object-cover shadow-lg">
                    <div class="absolute bottom-0 right-0 bg-white rounded-full p-2 shadow-md">
                        <i class="ri-user-line text-indigo-600"></i>
                    </div>
                </div>
                <div class="md:ml-8 text-center md:text-left">
                    <h1 class="text-2xl md:text-3xl font-bold">{{ $user->name }}</h1>
                    <p class="text-indigo-100 mt-1">{{ $user->email }}</p>
                    <div class="mt-3">
                        <span class="inline-block px-3 py-1 bg-white/20 rounded-full text-sm font-medium">
                            Member since {{ $user->created_at->format('M Y') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Content -->
        <div class="p-6 md:p-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Personal Info -->
                <div class="md:col-span-2">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold text-gray-800">Personal Information</h2>
                        <a href="{{ route('userprofile.edit') }}"
                           class="flex items-center text-indigo-600 hover:text-indigo-800">
                            <i class="ri-edit-line mr-2"></i> Edit Profile
                        </a>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 h-10 w-10 rounded-lg bg-indigo-50 flex items-center justify-center text-indigo-600">
                                <i class="ri-user-line"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-gray-500">Full Name</h3>
                                <p class="text-sm text-gray-900 mt-1">{{ $user->name }}</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex-shrink-0 h-10 w-10 rounded-lg bg-indigo-50 flex items-center justify-center text-indigo-600">
                                <i class="ri-mail-line"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-gray-500">Email Address</h3>
                                <p class="text-sm text-gray-900 mt-1">{{ $user->email }}</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex-shrink-0 h-10 w-10 rounded-lg bg-indigo-50 flex items-center justify-center text-indigo-600">
                                <i class="ri-calendar-line"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-gray-500">Account Created</h3>
                                <p class="text-sm text-gray-900 mt-1">{{ $user->created_at->format('F j, Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stats -->
                <div class="border-t md:border-t-0 md:border-l border-gray-200 pt-6 md:pt-0 md:pl-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-6">Your Activity</h2>

                    <div class="space-y-4">
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 rounded-lg bg-green-50 flex items-center justify-center text-green-600">
                                    <i class="ri-task-line"></i>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-sm font-medium text-gray-500">Total Tasks</h3>
                                    <p class="text-lg font-semibold text-gray-900 mt-1">42</p>
                                </div>
                            </div>
                        </div>

                        <div class="p-4 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600">
                                    <i class="ri-checkbox-circle-line"></i>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-sm font-medium text-gray-500">Completed</h3>
                                    <p class="text-lg font-semibold text-gray-900 mt-1">28</p>
                                </div>
                            </div>
                        </div>

                        <div class="p-4 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 rounded-lg bg-purple-50 flex items-center justify-center text-purple-600">
                                    <i class="ri-star-line"></i>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-sm font-medium text-gray-500">Achievements</h3>
                                    <p class="text-lg font-semibold text-gray-900 mt-1">5</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="border-t border-gray-200 p-6 md:p-8">
            <h2 class="text-xl font-bold text-gray-800 mb-6">Recent Activity</h2>

            <div class="space-y-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600">
                        <i class="ri-check-line"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-700">You completed <span class="font-medium">"Design Homepage"</span> task</p>
                        <p class="text-xs text-gray-500 mt-1">2 hours ago</p>
                    </div>
                </div>

                <div class="flex items-start">
                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                        <i class="ri-add-line"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-700">You created <span class="font-medium">"Update Dashboard"</span> task</p>
                        <p class="text-xs text-gray-500 mt-1">1 day ago</p>
                    </div>
                </div>

                <div class="flex items-start">
                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                        <i class="ri-team-line"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-700">You shared <span class="font-medium">"Marketing Plan"</span> with your team</p>
                        <p class="text-xs text-gray-500 mt-1">3 days ago</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
