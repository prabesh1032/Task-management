<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with('assignedTo')->get();
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
            'status' => 'pending,completed,overdue',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'required|date',
            'assigned_to' => 'required|exists:users,id',
            'todo_checklist' => 'nullable|array',
            'todo_checklist.*' => 'nullable|string|max:255',
            'attachment' => 'nullable|file|mimes:jpg,png,pdf,docx|max:2048',
        ]);

        $taskData = $request->except('attachment', 'todo_checklist');
        $taskData['todo_checklist'] = json_encode($request->todo_checklist);

        if ($request->hasFile('attachment')) {
            $taskData['attachment'] = $request->file('attachment')->store('attachments', 'public');
        }

        Task::create($taskData);

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
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
        $taskData['todo_checklist'] = json_encode($request->todo_checklist);

        $task->update($taskData);

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    public function destroy(Task $task)
    {

        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }

    public function userTasks()
    {
        $user = Auth::user();

        // Get all tasks assigned to this user, order by due date (or latest)
        $tasks = Task::where('assigned_to', $user->id)
            ->orderBy('due_date', 'asc')
            ->get();

        return view('user.taskindex', compact('tasks'));
    }
}
