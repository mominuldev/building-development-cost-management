<?php

namespace App\Http\Controllers;

use App\Models\LaborCost;
use App\Models\Project;
use Illuminate\Http\Request;

class LaborCostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Project $project)
    {
        $this->authorize('view', $project);

        $laborCosts = $project->contractorCosts()->latest()->get();

        return view('contractors.index', compact('project', 'laborCosts'));
    }

    public function create(Project $project)
    {
        $this->authorize('view', $project);

        // Only show contractor option
        $laborTypes = [
            'contractor' => 'Contractor'
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

        return view('contractors.create', compact('project', 'laborTypes', 'categories'));
    }

    public function store(Request $request, Project $project)
    {
        $this->authorize('view', $project);

        // For contractors, only name and category are required
        $validated = $request->validate([
            'labor_type' => 'required|in:contractor',
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'use_uniform_wage' => 'nullable|boolean',
            'number_of_workers' => 'nullable|integer|min:1',
            'daily_wage' => 'nullable|numeric|min:0',
            'days_worked' => 'nullable|integer|min:1',
            'work_date' => 'nullable|date',
            'description' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $validated['project_id'] = $project->id;
        $validated['is_attendance_based'] = true; // Contractors use attendance-based calculation
        $validated['total_cost'] = 0; // Default value, will be calculated from workers
        $validated['work_date'] = null; // Contractors don't need a specific work date
        $validated['use_uniform_wage'] = $request->has('use_uniform_wage'); // Convert checkbox to boolean

        LaborCost::create($validated);

        return redirect()->route('projects.contractors.index', $project)
            ->with('success', 'Contractor added successfully. Assign workers to calculate costs.');
    }

    public function show(Project $project, LaborCost $laborCost)
    {
        $this->authorize('view', $project);

        if ($laborCost->project_id !== $project->id) {
            abort(404);
        }

        return view('contractors.show', compact('project', 'laborCost'));
    }

    public function edit(Project $project, LaborCost $laborCost)
    {
        $this->authorize('view', $project);

        if ($laborCost->project_id !== $project->id) {
            abort(404);
        }

        $laborTypes = [
            'contractor' => 'Contractor'
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

        return view('contractors.edit', compact('project', 'laborCost', 'laborTypes', 'categories'));
    }

    public function update(Request $request, Project $project, LaborCost $laborCost)
    {
        $this->authorize('view', $project);

        if ($laborCost->project_id !== $project->id) {
            abort(404);
        }

        // For contractors, only name and category are required
        $validated = $request->validate([
            'labor_type' => 'required|in:contractor',
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'use_uniform_wage' => 'nullable|boolean',
            'number_of_workers' => 'nullable|integer|min:1',
            'daily_wage' => 'nullable|numeric|min:0',
            'days_worked' => 'nullable|integer|min:1',
            'work_date' => 'nullable|date',
            'description' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $validated['use_uniform_wage'] = $request->has('use_uniform_wage'); // Convert checkbox to boolean

        $laborCost->update($validated);

        return redirect()->route('projects.contractors.index', $project)
            ->with('success', 'Contractor updated successfully.');
    }

    public function destroy(Project $project, LaborCost $laborCost)
    {
        $this->authorize('view', $project);

        if ($laborCost->project_id !== $project->id) {
            abort(404);
        }

        $laborCost->delete();

        return redirect()->route('projects.contractors.index', $project)
            ->with('success', 'Contractor deleted successfully.');
    }
}
