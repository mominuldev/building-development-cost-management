<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();

        $stats = [
            'total_projects' => $user->projects()->count(),
            'active_projects' => $user->projects()->where('status', 'in_progress')->count(),
            'completed_projects' => $user->projects()->where('status', 'completed')->count(),
            'total_budget' => $user->projects()->sum('estimated_budget'),
        ];

        $recentProjects = $user->projects()->latest()->limit(5)->get();

        $activeProjects = $user->projects()->where('status', 'in_progress')->latest()->get();

        $budgetAlerts = collect();
        foreach ($user->projects as $project) {
            if ($project->budget_usage_percentage > 90) {
                $budgetAlerts->push($project);
            }
        }

        return view('dashboard', compact('stats', 'recentProjects', 'activeProjects', 'budgetAlerts'));
    }
}
