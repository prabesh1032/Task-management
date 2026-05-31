<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'TaskFlow') }} | @yield('title')</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-50">
<div class="flex min-h-screen relative">

    <!-- Mobile Overlay -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black/30 z-20 hidden lg:hidden" onclick="closeSidebar()"></div>

    <!-- Sidebar -->
    <aside id="sidebar" class="fixed lg:sticky top-0 left-0 h-screen w-64 z-30 bg-white border-r border-gray-200
           flex flex-col transform -translate-x-full lg:translate-x-0 transition-transform duration-200">

        <!-- Logo -->
        <div class="flex items-center gap-3 px-5 py-4 border-b border-gray-200">
            <div class="w-8 h-8 rounded-lg bg-indigo-600 flex items-center justify-center flex-shrink-0">
                <div class="w-5 h-5 rounded-md bg-white flex items-center justify-center">
                    <i class="ri-check-line text-indigo-600 text-sm font-bold"></i>
                </div>
            </div>
            <span class="font-semibold text-gray-900 text-lg">TaskFlow</span>
        </div>

        <!-- Nav -->
        <nav class="flex-1 px-3 py-3 space-y-0.5 overflow-y-auto">
            <p class="text-[10px] font-semibold uppercase tracking-widest text-gray-400 px-3 pt-1 pb-1">Main</p>
            <a href="{{ route('dashboard') }}" class="nav-link @if(request()->routeIs('dashboard')) nav-link-active @endif">
                <i class="ri-dashboard-line text-lg"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('user.tasks.index') }}" class="nav-link @if(request()->routeIs('user.tasks.index')) nav-link-active @endif">
                <i class="ri-task-fill text-lg"></i>
                <span>My Tasks</span>
            </a>

            <p class="text-[10px] font-semibold uppercase tracking-widest text-gray-400 px-3 pt-3 pb-1">Workspace</p>
            <a href="{{ route('userprofile.index') }}" class="nav-link @if(request()->routeIs('userprofile.*')) nav-link-active @endif">
                <i class="ri-user-line text-lg"></i>
                <span>Profile</span>
            </a>
        </nav>

        <!-- Footer -->
        <div class="px-3 py-3 border-t border-gray-200">
            <div class="px-3 py-2.5 rounded-lg bg-gray-50 mb-2">
                <p class="text-xs text-gray-500">Welcome back</p>
                <p class="text-sm font-medium text-gray-800">{{ Auth::user()->name }} 👋</p>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-sm text-gray-600 hover:bg-red-50 hover:text-red-600 transition-colors duration-150">
                    <i class="ri-logout-box-r-line text-lg"></i>
                    <span class="font-medium">Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main -->
    <div class="flex-1 flex flex-col min-w-0 lg:ml-0">

        <!-- Header -->
        <header class="sticky top-0 z-10 bg-white border-b border-gray-200">
            <div class="flex items-center justify-between px-4 py-3 gap-3">

                <!-- Hamburger (mobile) + Title -->
                <div class="flex items-center gap-3">
                    <button onclick="openSidebar()" class="lg:hidden w-8 h-8 flex items-center justify-center rounded-lg border border-gray-200 bg-gray-50 text-gray-600 hover:bg-gray-100">
                        <i class="ri-menu-2-line text-lg"></i>
                    </button>
                    <h1 class="text-base font-semibold text-gray-900 lg:text-lg">@yield('title')</h1>
                </div>

                <!-- Right controls -->
                <div class="flex items-center gap-2">
                    <!-- Search (hidden on small) -->
                    <div class="relative hidden sm:block">
                        <input type="text" placeholder="Search..."
                               class="pl-9 pr-3 py-2 w-48 md:w-56 text-sm rounded-lg border border-gray-200 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent focus:bg-white transition">
                        <i class="ri-search-line absolute left-3 top-2.5 text-gray-400 text-sm"></i>
                    </div>

                    <!-- Role Badge -->
                    <div class="hidden sm:flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-indigo-50 text-indigo-700 text-xs font-semibold">
                        <i class="ri-shield-star-line text-sm"></i>
                        {{ strtoupper(auth()->user()->role ?? 'user') }}
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 overflow-y-auto p-4 md:p-6 bg-gray-50">
            @yield('content')
        </main>
    </div>
</div>

<!-- Sidebar JS -->
<script>
function openSidebar() {
    document.getElementById('sidebar').classList.remove('-translate-x-full');
    document.getElementById('sidebar-overlay').classList.remove('hidden');
}
function closeSidebar() {
    document.getElementById('sidebar').classList.add('-translate-x-full');
    document.getElementById('sidebar-overlay').classList.add('hidden');
}
</script>

@stack('scripts')
</body>
</html>
