@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <div class="bg-gradient-to-r from-green-400 to-blue-500 p-6 rounded-lg shadow-lg transform transition-transform hover:scale-105">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-white mb-2">Total Tasks</h2>
            <i class="ri-task-line text-3xl text-white"></i>
        </div>
        <p class="text-white">View and manage all tasks.</p>
        <a href="" class="mt-4 block px-4 py-2 bg-yellow-500 text-black font-bold rounded-full hover:bg-yellow-600 text-center">Manage Tasks</a>
    </div>
    <div class="bg-gradient-to-r from-purple-400 to-pink-500 p-6 rounded-lg shadow-lg transform transition-transform hover:scale-105">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-white mb-2">Completed Tasks</h2>
            <i class="ri-check-line text-3xl text-white"></i>
        </div>
        <p class="text-white">Review completed tasks.</p>
        <a href="" class="mt-4 block px-4 py-2 bg-yellow-500 text-black font-bold rounded-full hover:bg-yellow-600 text-center">View Completed Tasks</a>
    </div>
    <div class="bg-gradient-to-r from-yellow-400 to-orange-500 p-6 rounded-lg shadow-lg transform transition-transform hover:scale-105">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-white mb-2">Pending Tasks</h2>
            <i class="ri-time-line text-3xl text-white"></i>
        </div>
        <p class="text-white">Manage tasks that are pending.</p>
        <a href="" class="mt-4 block px-4 py-2 bg-yellow-500 text-black font-bold rounded-full hover:bg-yellow-600 text-center">View Pending Tasks</a>
    </div>
    <div class="bg-gradient-to-r from-red-400 to-pink-500 p-6 rounded-lg shadow-lg transform transition-transform hover:scale-105">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-white mb-2">Overdue Tasks</h2>
            <i class="ri-alarm-warning-line text-3xl text-white"></i>
        </div>
        <p class="text-white">Monitor tasks that are overdue.</p>
        <a href="" class="mt-4 block px-4 py-2 bg-yellow-500 text-black font-bold rounded-full hover:bg-yellow-600 text-center">View Overdue Tasks</a>
    </div>
    <div class="bg-gradient-to-r from-blue-400 to-purple-500 p-6 rounded-lg shadow-lg transform transition-transform hover:scale-105">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-white mb-2">Team Members</h2>
            <i class="ri-group-line text-3xl text-white"></i>
        </div>
        <p class="text-white">Manage team members and roles.</p>
        <a href="" class="mt-4 block px-4 py-2 bg-yellow-500 text-black font-bold rounded-full hover:bg-yellow-600 text-center">Manage Team</a>
    </div>
    <div class="bg-gradient-to-r from-green-500 to-teal-500 p-6 rounded-lg shadow-lg transform transition-transform hover:scale-105">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-white mb-2">Reports</h2>
            <i class="ri-bar-chart-line text-3xl text-white"></i>
        </div>
        <p class="text-white">Generate and view reports.</p>
        <a href="" class="mt-4 block px-4 py-2 bg-yellow-500 text-black font-bold rounded-full hover:bg-yellow-600 text-center">View Reports</a>
    </div>
</div>
@endsection
