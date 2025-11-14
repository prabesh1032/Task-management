<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index(Request $request)
    {
        // Validate sort parameter
        $validSorts = ['newest', 'oldest', 'name-asc', 'name-desc'];
        $sort = $request->input('sort', 'newest');

        if (!in_array($sort, $validSorts)) {
            $sort = 'newest';
        }

        // Base query with eager loading
        $query = User::withCount('assignedTasks');

        // Apply sorting
        switch ($sort) {
            case 'oldest':
                $query->oldest();
                break;
            case 'name-asc':
                $query->orderBy('name');
                break;
            case 'name-desc':
                $query->orderByDesc('name');
                break;
            case 'newest':
            default:
                $query->latest();
                break;
        }

        // Paginate results (10 per page)
        $users = $query->paginate(10)
                      ->appends(['sort' => $sort]);

        return view('team', compact('users', 'sort'));
    }
    public function useractivity(Request $request)
    {
        // Base query with counts
        $query = User::withCount([
            'assignedTasks as pending_tasks_count' => function($query) {
                $query->where('status', 'pending');
            },
            'assignedTasks as in_progress_tasks_count' => function($query) {
                $query->where('status', 'in_progress');
            },
            'assignedTasks as completed_tasks_count' => function($query) {
                $query->where('status', 'completed');
            }
        ]);

        // Search functionality
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Pagination
        $users = $query->paginate(10);

        // Additional stats for the summary cards
        $stats = [
            'total_users' => User::count(),
            'active_today' => User::whereDate('last_active_at', today())->count(),
            'total_completed' => \App\Models\Task::where('status', 'completed')->count(),
            'avg_completion' => round(\App\Models\Task::where('status', 'completed')
                ->selectRaw('COUNT(*) / COUNT(DISTINCT assigned_to) as avg')
                ->value('avg'), 1)
        ];

        return view('useractivity', compact('users', 'stats',));
    }
}

