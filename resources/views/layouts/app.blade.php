<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Task Management') }} - @yield('title')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="flex">
        <div class="w-56 h-screen sticky top-0 bg-gray-200 shadow-lg">
            <div class="flex flex-col items-center mt-5">
                <img src="{{ asset('SS2.png') }}" alt="Logo" class="w-8/12 mx-auto bg-blue-400 p-2 rounded-lg shadow-lg">
                <span class="mt-3 font-bold text-xl">Task Management</span>
            </div>
            <div class="mt-5 space-y-1">
                <a href="{{ route('dashboard') }}" class="p-3 text-gray-700 hover:bg-yellow-300 flex items-center transition duration-200 ease-in-out">
                    <i class="ri-dashboard-line mr-2"></i> Dashboard
                </a>
                <a href="{{ route('tasks.index') }}" class="p-3 text-gray-700 hover:bg-yellow-300 flex items-center transition duration-200 ease-in-out">
                    <i class="ri-tasks-line mr-2"></i> Tasks
                </a>
                <a href="{{ route('tasks.create') }}" class="p-3 text-gray-700 hover:bg-yellow-300 flex items-center transition duration-200 ease-in-out">
                    <i class="ri-add-line mr-2"></i> Create Task
                </a>
                <form action="{{ route('logout') }}" method="POST" class="block p-3 text-gray-700 hover:bg-red-700 text-left transition duration-200 ease-in-out">
                    @csrf
                    <button type="submit" class="w-full flex items-center">
                        <i class="ri-logout-box-line mr-2"></i> Logout
                    </button>
                </form>
            </div>
        </div>
        <div class="flex-1 p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-6xl font-bold">@yield('title')</h1>
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <i class="ri-notification-3-line text-3xl"></i>
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full px-1">3</span>
                    </div>
                    <img src="{{ asset('useravatar.avif') }}" alt="User Avatar" class="w-10 h-10 rounded-full">
                </div>
            </div>
            <hr class="h-1 bg-yellow-100 mb-6">
            <div class="flex justify-between bg-white mb-4 p-4 rounded-lg shadow">
                <div class="space-y-1">
                    <h2 class="text-xl font-semibold">Quick Stats</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div class="bg-yellow-200 p-4 rounded-lg shadow">
                            <p class="text-gray-700">Total Tasks</p>
                            @php
                            $totalTasks = \App\Models\Task::count();
                            @endphp
                            <p class="text-2xl font-bold">{{$totalTasks}}</p>
                        </div>
                    </div>
                </div>
                <div class="flex items-center">
                    <input type="text" placeholder="Search..." class="p-2 rounded border border-gray-300">
                    <button class="bg-yellow-500 text-black p-2 rounded ml-2 transition duration-200 ease-in-out hover:bg-yellow-600"><i class="ri-search-line"></i></button>
                </div>
            </div>
            @yield('content')
        </div>
    </div>
</body>
</html>
