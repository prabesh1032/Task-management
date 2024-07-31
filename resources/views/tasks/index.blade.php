@extends('layouts.app')

@section('title', 'Tasks')

@section('content')
<div class="container mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-4xl font-bold">Tasks</h1>
        <a href="{{ route('tasks.create') }}" class="bg-green-500 text-white px-4 py-2 rounded">Add Task</a>
    </div>

    @if(session('success'))
        <div class="bg-green-200 text-green-800 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <table class="min-w-full bg-white">
        <thead>
            <tr>
                <th class="py-2">Title</th>
                <th class="py-2">Description</th>
                <th class="py-2">Status</th>
                <th class="py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tasks as $task)
                <tr>
                    <td class="py-2">{{ $task->title }}</td>
                    <td class="py-2">{{ $task->description }}</td>
                    <td class="py-2">{{ $task->status }}</td>
                    <td class="py-2 flex space-x-2">
                        <a href="{{ route('tasks.edit', $task) }}" class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</a>
                        <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
