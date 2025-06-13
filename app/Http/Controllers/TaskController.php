<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = Task::with('assignedTo');

        // Status filter
        if ($request->has('status') && in_array($request->status, ['pending', 'in_progress', 'completed'])) {
            $query->where('status', $request->status);
        }

        // Priority filter
        if ($request->has('priority') && in_array($request->priority, ['high', 'medium', 'low'])) {
            $query->where('priority', $request->priority);
        }

        $tasks = $query->get();

        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        $users = User::all(); // Fetch users to assign tasks
        return view('tasks.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'required|date',
            'assigned_to' => 'required|exists:users,id',
            'todo_checklist' => 'nullable|array',
            'todo_checklist.*' => 'nullable|string|max:255',
        ]);

        $taskData = $request->except('todo_checklist');

        // Initialize checklist with false values
        $checklist = [];
        if ($request->has('todo_checklist')) {
            foreach ($request->todo_checklist as $item) {
                if (!empty($item)) {
                    $checklist[$item] = false; // All items start as not completed
                }
            }
        }
        $taskData['todo_checklist'] = json_encode($checklist);

        Task::create($taskData);

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'required|date',
            'assigned_to' => 'required|exists:users,id',
            'todo_checklist' => 'nullable|array',
            'todo_checklist.*' => 'nullable|string|max:255',
        ]);

        $taskData = $request->except('todo_checklist');

        // Get current checklist to preserve completion status
        $currentChecklist = json_decode($task->todo_checklist, true) ?? [];

        // Initialize new checklist
        $newChecklist = [];
        if ($request->has('todo_checklist')) {
            foreach ($request->todo_checklist as $item) {
                if (!empty($item)) {
                    // Preserve completion status if item exists in current checklist
                    $newChecklist[$item] = $currentChecklist[$item] ?? false;
                }
            }
        }
        $taskData['todo_checklist'] = json_encode($newChecklist);

        $task->update($taskData);

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }
    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        $users = User::all(); // Fetch users to reassign tasks
        return view('tasks.edit', compact('task', 'users'));
    }

    public function destroy(Task $task)
    {

        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }
}
