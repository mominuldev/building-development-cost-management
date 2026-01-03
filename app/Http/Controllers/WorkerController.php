<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Worker;
use App\Models\LaborCost;
use Illuminate\Http\Request;

class WorkerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Project $project)
    {
        $this->authorize('view', $project);

        $workers = $project->workers()
            ->with(['laborCost', 'primaryContractor', 'contractors', 'attendances' => function($query) {
                $query->latest()->limit(5);
            }])
            ->latest()
            ->get();

        // Calculate today's attendance bill
        $todayAttendances = $project->attendances()
            ->whereDate('attendance_date', today())
            ->get();

        $todayStats = [
            'total_workers_present' => $todayAttendances->where('status', 'present')->count(),
            'total_workers_absent' => $todayAttendances->where('status', 'absent')->count(),
            'total_bill' => $todayAttendances->sum('wage_amount'),
            'total_hours' => $todayAttendances->sum('hours_worked'),
        ];

        $categories = [
            'mason' => 'Mason',
            'carpenter' => 'Carpenter',
            'electrician' => 'Electrician',
            'plumber' => 'Plumber',
            'painter' => 'Painter',
            'welder' => 'Welder',
            'helper' => 'Helper',
            'other' => 'Other'
        ];

        $laborTypes = [
            'daily' => 'Daily Labor',
            'contractor' => 'Contractor',
            'skilled' => 'Skilled Worker',
            'unskilled' => 'Unskilled Worker',
            'specialist' => 'Specialist'
        ];

        return view('workers.index', compact(
            'project',
            'workers',
            'todayStats',
            'categories',
            'laborTypes'
        ));
    }

    public function create(Project $project)
    {
        $this->authorize('view', $project);

        $contractors = $project->contractorCosts()->contractors()->get();

        $categories = [
            'mason' => 'Mason',
            'carpenter' => 'Carpenter',
            'electrician' => 'Electrician',
            'plumber' => 'Plumber',
            'painter' => 'Painter',
            'welder' => 'Welder',
            'helper' => 'Helper',
            'other' => 'Other'
        ];

        $laborTypes = [
            'daily' => 'Daily Labor',
            'contractor' => 'Contractor',
            'skilled' => 'Skilled Worker',
            'unskilled' => 'Unskilled Worker',
            'specialist' => 'Specialist'
        ];

        return view('workers.create', compact(
            'project',
            'contractors',
            'categories',
            'laborTypes'
        ));
    }

    public function store(Request $request, Project $project)
    {
        $this->authorize('view', $project);

        $validated = $request->validate([
            'primary_contractor_id' => 'nullable|exists:labor_costs,id',
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'labor_type' => 'required|in:daily,contractor,skilled,unskilled,specialist',
            'category' => 'nullable|string|max:255',
            'daily_wage' => 'required|numeric|min:0',
            'hire_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $validated['project_id'] = $project->id;
        $validated['is_active'] = true;

        // If primary_contractor_id is provided, verify it belongs to this project and is a contractor
        if (!empty($validated['primary_contractor_id'])) {
            $contractor = LaborCost::find($validated['primary_contractor_id']);
            if (!$contractor || $contractor->project_id !== $project->id || $contractor->labor_type !== 'contractor') {
                return back()->withInput()->withErrors(['primary_contractor_id' => 'Invalid contractor selected.']);
            }
        }

        Worker::create($validated);

        return redirect()->route('projects.workers.index', $project)
            ->with('success', 'Worker added successfully.');
    }

    public function show(Project $project, Worker $worker)
    {
        $this->authorize('view', $project);

        if ($worker->project_id !== $project->id) {
            abort(404);
        }

        $worker->load(['attendances' => function($query) {
            $query->latest()->limit(30);
        }, 'primaryContractor', 'contractors']);

        return view('workers.show', compact('project', 'worker'));
    }

    public function edit(Project $project, Worker $worker)
    {
        $this->authorize('view', $project);

        if ($worker->project_id !== $project->id) {
            abort(404);
        }

        $contractors = $project->contractorCosts()->contractors()->get();

        $categories = [
            'mason' => 'Mason',
            'carpenter' => 'Carpenter',
            'electrician' => 'Electrician',
            'plumber' => 'Plumber',
            'painter' => 'Painter',
            'welder' => 'Welder',
            'helper' => 'Helper',
            'other' => 'Other'
        ];

        $laborTypes = [
            'daily' => 'Daily Labor',
            'contractor' => 'Contractor',
            'skilled' => 'Skilled Worker',
            'unskilled' => 'Unskilled Worker',
            'specialist' => 'Specialist'
        ];

        return view('workers.edit', compact(
            'project',
            'worker',
            'contractors',
            'categories',
            'laborTypes'
        ));
    }

    public function update(Request $request, Project $project, Worker $worker)
    {
        $this->authorize('view', $project);

        if ($worker->project_id !== $project->id) {
            abort(404);
        }

        $validated = $request->validate([
            'primary_contractor_id' => 'nullable|exists:labor_costs,id',
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'labor_type' => 'required|in:daily,contractor,skilled,unskilled,specialist',
            'category' => 'nullable|string|max:255',
            'daily_wage' => 'required|numeric|min:0',
            'is_active' => 'nullable|boolean',
            'hire_date' => 'nullable|date',
            'terminate_date' => 'nullable|date|after_or_equal:hire_date',
            'notes' => 'nullable|string',
        ]);

        // Convert checkbox to boolean (if not present, it's unchecked = false)
        $validated['is_active'] = $request->has('is_active');

        // Validate primary_contractor_id belongs to project and is a contractor
        if (!empty($validated['primary_contractor_id'])) {
            $contractor = LaborCost::find($validated['primary_contractor_id']);
            if (!$contractor || $contractor->project_id !== $project->id || $contractor->labor_type !== 'contractor') {
                return back()->withInput()->withErrors(['primary_contractor_id' => 'Invalid contractor selected.']);
            }
        }

        // If deactivating worker and terminate_date is not set, set it to today
        if (!$validated['is_active'] && empty($validated['terminate_date'])) {
            $validated['terminate_date'] = now();
        }

        // If activating worker, clear terminate_date
        if ($validated['is_active']) {
            $validated['terminate_date'] = null;
        }

        $worker->update($validated);

        return redirect()->route('projects.workers.index', $project)
            ->with('success', 'Worker updated successfully.');
    }

    public function destroy(Project $project, Worker $worker)
    {
        $this->authorize('view', $project);

        if ($worker->project_id !== $project->id) {
            abort(404);
        }

        $worker->delete();

        return redirect()->route('projects.workers.index', $project)
            ->with('success', 'Worker deleted successfully.');
    }
}
