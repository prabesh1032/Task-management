<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserTaskController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Get all tasks assigned to this user, ordered by creation date (newest first)
        $tasks = Task::where('assigned_to', $user->id)
            ->with('assignedTo') // Eager load the assigner
            ->orderBy('created_at', 'desc') // Newest first
            ->get();

        return view('user.index', compact('tasks'));
    }

    public function edit($id)
    {
        $task = Task::findOrFail($id);

        // Decode the checklist ensuring we get an array
        $checklist = json_decode($task->todo_checklist, true);

        // Handle case where JSON decode fails or returns null
        if (!is_array($checklist)) {
            $checklist = [];
        }

        return view('user.edit', compact('task', 'checklist'));
    }

    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        // Get current checklist
        $checklist = json_decode($task->todo_checklist, true);
        if (!is_array($checklist)) {
            $checklist = [];
        }

        // Update checklist statuses
        foreach ($checklist as $name => &$isChecked) {
            $isChecked = $request->has("checklist.$name");
        }

        // Update task status
        $allCompleted = count($checklist) > 0 && !in_array(false, $checklist, true);
        $task->status = $allCompleted ? 'completed' : 'in_progress';
        $task->todo_checklist = json_encode($checklist);
        $task->save();

        return redirect()->route('user.tasks.index', $task->id)
            ->with('success', 'Checklist updated successfully!');
    }
}
