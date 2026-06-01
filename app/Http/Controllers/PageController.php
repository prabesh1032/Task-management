<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function home()
    {
        return view('welcome');
    }
    public function dashboard()
    {
        $totalTasks = Task::count();
        $completedTasks = Task::where('status', 'completed')->count();
        $teamMembersCount = User::where('role', 'member')->count();

        $taskDistribution = Task::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Task Priority Data
        $taskPriority = Task::selectRaw('priority, count(*) as count')
            ->groupBy('priority')
            ->pluck('count', 'priority')
            ->toArray();

        return view('dashboard', compact('taskDistribution', 'taskPriority', 'totalTasks', 'completedTasks', 'teamMembersCount'));
    }

    public function userdashboard()
    {
        $user = auth()->user();

        // Fetch recent tasks assigned to this user, order by created_at desc, limit 5
        $recentTasks = Task::where('assigned_to', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Task Distribution Counts
        $pendingTasks = Task::where('assigned_to', $user->id)
            ->where('status', 'pending')
            ->count();
        $inProgressTasks = Task::where('assigned_to', $user->id)
            ->where('status', 'in_progress')
            ->count();
        $completedTasks = Task::where('assigned_to', $user->id)
            ->where('status', 'completed')
            ->count();

        // Overdue: any non-completed task whose due_date is in the past
        $overdueTasks = Task::where('assigned_to', $user->id)
            ->where('status', '!=', 'completed')
            ->whereDate('due_date', '<', now())
            ->count();

        // Task Priority Counts
        $lowPriorityTasks = Task::where('assigned_to', $user->id)
            ->where('priority', 'low')
            ->count();
        $mediumPriorityTasks = Task::where('assigned_to', $user->id)
            ->where('priority', 'medium')
            ->count();
        $highPriorityTasks = Task::where('assigned_to', $user->id)
            ->where('priority', 'high')
            ->count();

        return view('user.dashboard', [
            'recentTasks' => $recentTasks,
            'pendingTasks' => $pendingTasks,
            'inProgressTasks' => $inProgressTasks,
            'completedTasks' => $completedTasks,
            'overdueTasks' => $overdueTasks,
            'lowPriorityTasks' => $lowPriorityTasks,
            'mediumPriorityTasks' => $mediumPriorityTasks,
            'highPriorityTasks' => $highPriorityTasks,
            'totalTasks' => Task::where('assigned_to', $user->id)->count()
        ]);
    }
}
