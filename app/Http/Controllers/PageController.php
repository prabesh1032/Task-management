<?php

namespace App\Http\Controllers;

use App\Models\Task;
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
        return view('dashboard');
    }

    public function userdashboard()
    {
        $user = auth()->user();

        // Fetch recent tasks assigned to this user, order by created_at desc, limit 5
        $recentTasks = Task::where('assigned_to', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Calculate task summaries
        $totalTasks = Task::where('assigned_to', $user->id)->count();
        $pendingTasks = Task::where('assigned_to', $user->id)->where('status', 'pending')->count();
        $inProgressTasks = Task::where('assigned_to', $user->id)->where('status', 'in_progress')->count();
        $completedTasks = Task::where('assigned_to', $user->id)->where('status', 'completed')->count();
        $overdueTasks = Task::where('assigned_to', $user->id)->where('status', 'overdue')->count();

        return view('user.dashboard', compact(
            'recentTasks',
            'totalTasks',
            'pendingTasks',
            'inProgressTasks',
            'completedTasks',
            'overdueTasks'
        ));
    }
}
