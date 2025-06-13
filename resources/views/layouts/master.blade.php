<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Modern task management platform for teams and individuals">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'TaskFlow') }} | @yield('title')</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Remix Icons -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900">
    <!-- Navbar -->
    <nav class="bg-white shadow-sm sticky top-0 z-50 backdrop-blur-sm bg-opacity-80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center space-x-2">
                        <div class="w-9 h-9 rounded-lg bg-gradient-to-r from-indigo-600 to-purple-600 flex items-center justify-center">
                            <i class="ri-task-line text-white text-xl"></i>
                        </div>
                        <span class="text-xl font-bold text-gray-900">TaskFlow</span>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-indigo-600 px-1 pt-1 text-sm font-medium transition-colors duration-200">
                        Home
                    </a>
                    <div class="flex items-center space-x-4 ml-6">
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-indigo-600 text-sm font-medium transition-colors duration-200">
                            Sign In
                        </a>
                        <a href="{{ route('register') }}" class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:shadow-md transition-all duration-200">
                            Get Started
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

   <!-- Footer -->
<footer class="bg-gray-900 text-gray-300">
    <div class="container mx-auto px-6 py-12">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
            <!-- Brand Column -->
            <div class="col-span-2 md:col-span-1 space-y-4">
                <div class="flex items-center space-x-2">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-r from-indigo-600 to-purple-600 flex items-center justify-center">
                        <i class="ri-task-line text-white text-lg"></i>
                    </div>
                    <span class="text-xl font-bold text-white">TaskFlow</span>
                </div>
                <p class="text-gray-400 text-sm">
                    Modern task management for productive teams.
                </p>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        <i class="ri-twitter-fill text-xl"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        <i class="ri-linkedin-fill text-xl"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        <i class="ri-github-fill text-xl"></i>
                    </a>
                </div>
            </div>

            <!-- Links Columns -->
            <div>
                <h3 class="text-white font-semibold mb-4">Resources</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Docs</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Blog</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Support</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-white font-semibold mb-4">Company</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="#" class="text-gray-400 hover:text-white transition-colors">About</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Careers</a></li>
                    <li><a href="#contact" class="text-gray-400 hover:text-white transition-colors">Contact</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-white font-semibold mb-4">Legal</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Privacy</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Terms</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Cookies</a></li>
                </ul>
            </div>
        </div>

        <!-- Copyright -->
        <div class="border-t border-gray-800 mt-8 pt-8 text-center md:text-left">
            <p class="text-gray-500 text-sm">
                &copy; {{ now()->year }} TaskFlow. All rights reserved.
            </p>
        </div>
    </div>
</footer>
    @stack('scripts')
</body>
</html>
