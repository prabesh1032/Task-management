<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Task Management') }}</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans bg-white text-gray-800">
    <!-- Navbar -->
    <nav class="bg-black top-0 sticky z-10 text-white py-6">
    <div class="container mx-auto px-6 md:px-0 grid grid-cols-2 items-center">
        <div class="flex items-center space-x-4">
            <img src="" alt="" class="">
            <a href="{{ route('home') }}" class="text-4xl font-bold">Task Management</a>
        </div>
        <div class="flex justify-end space-x-8 text-xl">
        <a href="{{ route('home') }}" class="hover:text-yellow-500">Home</a>
        <a href="{{ route('login') }}" class="hover:text-yellow-500">Login</a>
        </div>
    </div>
</nav>

    <main class="container mx-auto my-10 px-6">
        @yield('content')
    </main>
    <footer class="bg-gray-800 text-white py-10">
    <div class="container mx-auto px-6 md:px-0 grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Column 1 -->
        <div>
            <h3 class="text-xl font-bold mb-4">Task Management</h3>
            <p class="text-gray-400">
                Manage your tasks efficiently and effectively with our user-friendly task management system.
            </p>
        </div>
        <!-- Column 2 -->
        <div>
            <h3 class="text-xl font-bold mb-4">Quick Links</h3>
            <ul class="space-y-2">
                <li><a href="{{ route('home') }}" class="hover:text-yellow-500">Home</a></li>
                <li><a href="{{ route('login') }}" class="hover:text-yellow-500">Login</a></li>
                <li><a href="{{ route('dashboard') }}" class="hover:text-yellow-500">Dashboard</a></li>
            </ul>
        </div>
        <!-- Column 3 -->
        <div>
            <h3 class="text-xl font-bold mb-4">Contact Us</h3>
            <p class="text-gray-400">
                Email: <a href="" class="hover:text-yellow-500">support@taskmanagement.com</a>
            </p>
            <p class="text-gray-400">
                Phone: <a href="" class="hover:text-yellow-500">+1 234 567 890</a>
            </p>
        </div>
    </div>
    <div class="border-t border-gray-700 mt-8 pt-4">
        <div class="container mx-auto px-6 md:px-0 flex flex-col md:flex-row justify-between items-center">
            <p class="text-gray-400 text-sm">
                &copy; 2024 Task Management. All rights reserved.
            </p>
            <div class="flex space-x-4 mt-4 md:mt-0">
                <a href="#" class="hover:text-yellow-500">Privacy Policy</a>
                <a href="#" class="hover:text-yellow-500">Terms of Service</a>
            </div>
        </div>
    </div>
</footer>

</body>
</html>
