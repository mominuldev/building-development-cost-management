<?php

namespace App\Http\Controllers;

use App\Models\FinishingWork;
use App\Models\Project;
use Illuminate\Http\Request;

class FinishingWorkController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Project $project)
    {
        $this->authorize('view', $project);

        $finishingWorks = $project->finishingWorks()->latest()->get();

        return view('finishing-works.index', compact('project', 'finishingWorks'));
    }

    public function create(Project $project)
    {
        $this->authorize('view', $project);

        $workTypes = [
            'flooring' => 'Flooring',
            'painting' => 'Painting',
            'plumbing' => 'Plumbing',
            'electrical' => 'Electrical',
            'doors_windows' => 'Doors & Windows',
            'ceiling' => 'Ceiling',
            'kitchen' => 'Kitchen',
            'bathroom' => 'Bathroom',
            'other' => 'Other'
        ];

        $units = [
            'sq_ft' => 'Square Feet (sq ft)',
            'sq_meter' => 'Square Meter',
            'running_ft' => 'Running Feet',
            'pcs' => 'Pieces (pcs)',
            'rooms' => 'Rooms',
            'sets' => 'Sets',
        ];

        return view('finishing-works.create', compact('project', 'workTypes', 'units'));
    }

    public function store(Request $request, Project $project)
    {
        $this->authorize('view', $project);

        $validated = $request->validate([
            'work_type' => 'required|in:flooring,painting,plumbing,electrical,doors_windows,ceiling,kitchen,bathroom,other',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'quantity' => 'required|numeric|min:0',
            'unit' => 'required|string|max:50',
            'unit_price' => 'required|numeric|min:0',
            'work_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $validated['project_id'] = $project->id;

        FinishingWork::create($validated);

        return redirect()->route('projects.finishing-works.index', $project)
            ->with('success', 'Finishing work added successfully.');
    }

    public function show(Project $project, FinishingWork $finishingWork)
    {
        $this->authorize('view', $project);

        if ($finishingWork->project_id !== $project->id) {
            abort(404);
        }

        return view('finishing-works.show', compact('project', 'finishingWork'));
    }

    public function edit(Project $project, FinishingWork $finishingWork)
    {
        $this->authorize('view', $project);

        if ($finishingWork->project_id !== $project->id) {
            abort(404);
        }

        $workTypes = [
            'flooring' => 'Flooring',
            'painting' => 'Painting',
            'plumbing' => 'Plumbing',
            'electrical' => 'Electrical',
            'doors_windows' => 'Doors & Windows',
            'ceiling' => 'Ceiling',
            'kitchen' => 'Kitchen',
            'bathroom' => 'Bathroom',
            'other' => 'Other'
        ];

        $units = [
            'sq_ft' => 'Square Feet (sq ft)',
            'sq_meter' => 'Square Meter',
            'running_ft' => 'Running Feet',
            'pcs' => 'Pieces (pcs)',
            'rooms' => 'Rooms',
            'sets' => 'Sets',
        ];

        return view('finishing-works.edit', compact('project', 'finishingWork', 'workTypes', 'units'));
    }

    public function update(Request $request, Project $project, FinishingWork $finishingWork)
    {
        $this->authorize('view', $project);

        if ($finishingWork->project_id !== $project->id) {
            abort(404);
        }

        $validated = $request->validate([
            'work_type' => 'required|in:flooring,painting,plumbing,electrical,doors_windows,ceiling,kitchen,bathroom,other',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'quantity' => 'required|numeric|min:0',
            'unit' => 'required|string|max:50',
            'unit_price' => 'required|numeric|min:0',
            'work_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $finishingWork->update($validated);

        return redirect()->route('projects.finishing-works.index', $project)
            ->with('success', 'Finishing work updated successfully.');
    }

    public function destroy(Project $project, FinishingWork $finishingWork)
    {
        $this->authorize('view', $project);

        if ($finishingWork->project_id !== $project->id) {
            abort(404);
        }

        $finishingWork->delete();

        return redirect()->route('projects.finishing-works.index', $project)
            ->with('success', 'Finishing work deleted successfully.');
    }
}
