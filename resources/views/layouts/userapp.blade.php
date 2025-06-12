<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'TaskFlow') }} | @yield('title')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="w-64 h-screen sticky top-0 bg-white shadow-md border-r border-gray-200 flex flex-col">
            <!-- Logo -->
            <div class="flex items-center justify-center p-6 border-b border-gray-200">
                <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-indigo-600 to-purple-600 flex items-center justify-center">
                    <i class="ri-task-line text-white text-xl"></i>
                </div>
                <span class="ml-3 font-bold text-xl text-gray-800">TaskFlow</span>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
                <a href="{{ route('dashboard') }}" class="flex items-center p-3 rounded-lg text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-colors duration-200">
                    <i class="ri-dashboard-line mr-3 text-lg"></i>
                    <span class="font-medium">Dashboard</span>
                </a>
                <a href="{{ route('user.tasks.index') }}" class="flex items-center p-3 rounded-lg text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-colors duration-200">
                    <i class="ri-task-fill mr-3 text-lg"></i>
                    <span class="font-medium">My Tasks</span>
                </a>
            </nav>

            <!-- User & Logout -->
            <div class="p-4 border-t border-gray-200">
                <div class="flex items-center mb-4 p-2 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                    <img src="{{ asset('useravatar.avif') }}" alt="User Avatar" class="w-10 h-10 rounded-full mr-3">
                    <div>
                        <p class="font-medium text-gray-800">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center p-3 rounded-lg text-gray-700 hover:bg-red-50 hover:text-red-600 transition-colors duration-200">
                        <i class="ri-logout-box-r-line mr-3 text-lg"></i>
                        <span class="font-medium">Logout</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Header -->
            <header class="bg-white shadow-sm z-10">
                <div class="flex items-center justify-between p-4">
                    <h1 class="text-2xl font-bold text-gray-800">@yield('title')</h1>

                    <div class="flex items-center space-x-4">
                        <!-- Search -->
                        <div class="relative">
                            <input type="text" placeholder="Search..."
                                   class="pl-10 pr-4 py-2 w-64 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            <i class="ri-search-line absolute left-3 top-2.5 text-gray-400"></i>
                        </div>

                        <!-- Notifications -->
                        <button class="relative p-2 rounded-full hover:bg-gray-100">
                            <i class="ri-notification-3-line text-xl text-gray-600"></i>
                            <span class="absolute top-0 right-0 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">3</span>
                        </button>

                        <!-- User Avatar -->
                        <div class="flex items-center space-x-2">
                            <img src="{{ asset('useravatar.avif') }}" alt="User Avatar" class="w-9 h-9 rounded-full">
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto p-6 bg-gray-50">
                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Total Tasks</p>
                                <p class="text-2xl font-bold mt-1">{{ \App\Models\Task::count() }}</p>
                            </div>
                            <div class="p-3 rounded-lg bg-indigo-50 text-indigo-600">
                                <i class="ri-todo-line text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Completed</p>
                                <p class="text-2xl font-bold mt-1">{{ \App\Models\Task::where('completed', true)->count() }}</p>
                            </div>
                            <div class="p-3 rounded-lg bg-green-50 text-green-600">
                                <i class="ri-checkbox-circle-line text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Team Members</p>
                                <p class="text-2xl font-bold mt-1">{{ \App\Models\User::count() }}</p>
                            </div>
                            <div class="p-3 rounded-lg bg-purple-50 text-purple-600">
                                <i class="ri-team-line text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dynamic Content -->
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
