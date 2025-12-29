<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\LaborCost;
use App\Models\Worker;
use Illuminate\Http\Request;

class ContractorWorkerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Project $project, LaborCost $contractor)
    {
        $this->authorize('view', $project);

        if ($contractor->project_id !== $project->id || $contractor->labor_type !== 'contractor') {
            abort(404);
        }

        $workers = $contractor->contractorWorkers()->with('attendances')->get();

        return view('contractor-workers.index', compact('project', 'contractor', 'workers'));
    }

    public function attach(Request $request, Project $project, LaborCost $contractor)
    {
        $this->authorize('view', $project);

        if ($contractor->project_id !== $project->id || $contractor->labor_type !== 'contractor') {
            abort(404);
        }

        $validated = $request->validate([
            'worker_id' => 'required|exists:workers,id',
            'assigned_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $worker = Worker::find($validated['worker_id']);
        if ($worker->project_id !== $project->id) {
            return back()->withErrors(['worker_id' => 'Invalid worker selected.']);
        }

        $contractor->contractorWorkers()->attach($worker->id, [
            'assigned_date' => $validated['assigned_date'] ?? now(),
            'notes' => $validated['notes'] ?? null,
        ]);

        return back()->with('success', 'Worker assigned to contractor successfully.');
    }

    public function detach(Project $project, LaborCost $contractor, Worker $worker)
    {
        $this->authorize('view', $project);

        if ($contractor->project_id !== $project->id || $contractor->labor_type !== 'contractor') {
            abort(404);
        }

        if ($worker->project_id !== $project->id) {
            abort(404);
        }

        $contractor->contractorWorkers()->updateExistingPivot($worker->id, [
            'removed_date' => now(),
            'is_active' => false,
        ]);

        return back()->with('success', 'Worker removed from contractor successfully.');
    }
}
