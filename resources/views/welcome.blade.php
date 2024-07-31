<!-- resources/views/welcome.blade.php -->

@extends('layouts.master')

@section('content')
    <!-- Header -->
    <header class="relative h-screen bg-cover bg-center" style="background-image: url('https://projectsly.com/images/task-management-screenshot-1.png?v=1691124479409199525');">
        <div class="absolute inset-0 bg-black opacity-50"></div>
        <div class="relative container mx-auto h-full flex flex-col justify-center items-center text-center text-white">
            <h1 class="text-4xl md:text-6xl font-bold">Welcome to Task Management</h1>
            <p class="text-md md:text-xl mt-4">Manage your tasks efficiently and effectively</p>
            <a href="#" class="mt-6 px-5 py-3 bg-yellow-500 text-black font-bold rounded-full hover:bg-yellow-600">Get Started</a>
        </div>
    </header>

    <!-- Main Content -->
    <div class="mt-20">
        <h2 class="text-3xl font-bold mb-6 text-center">Features</h2>
        <p class="text-lg text-center mb-10">Our task management system helps you organize and prioritize your work.</p>
        <div class="container mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h3 class="text-2xl font-bold mb-2">Create Tasks</h3>
                <p class="text-gray-700">Easily create and manage tasks to stay on top of your work.</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h3 class="text-2xl font-bold mb-2">Organize Tasks</h3>
                <p class="text-gray-700">Organize your tasks by priority, deadline, and category.</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h3 class="text-2xl font-bold mb-2">Track Progress</h3>
                <p class="text-gray-700">Monitor your progress and stay motivated by tracking your task completion.</p>
            </div>
        </div>
    </div>
@endsection
