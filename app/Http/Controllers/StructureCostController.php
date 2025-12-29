<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\StructureCost;
use Illuminate\Http\Request;

class StructureCostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Project $project)
    {
        $this->authorize('view', $project);

        $structureCosts = $project->structureCosts()->latest()->get();

        return view('structure-costs.index', compact('project', 'structureCosts'));
    }

    public function create(Project $project)
    {
        $this->authorize('view', $project);

        $structureTypes = [
            'foundation' => 'Foundation',
            'columns' => 'Columns',
            'beams' => 'Beams',
            'slabs' => 'Slabs',
            'roof' => 'Roof',
            'walls' => 'Walls',
            'other' => 'Other'
        ];

        $units = [
            'sq_ft' => 'Square Feet (sq ft)',
            'sq_meter' => 'Square Meter',
            'cubic_feet' => 'Cubic Feet (cft)',
            'cubic_meter' => 'Cubic Meter',
            'running_ft' => 'Running Feet',
            'pcs' => 'Pieces (pcs)',
            'load' => 'Load/Truck',
        ];

        return view('structure-costs.create', compact('project', 'structureTypes', 'units'));
    }

    public function store(Request $request, Project $project)
    {
        $this->authorize('view', $project);

        $validated = $request->validate([
            'structure_type' => 'required|in:foundation,columns,beams,slabs,roof,walls,other',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'quantity' => 'required|numeric|min:0',
            'unit' => 'required|string|max:50',
            'unit_price' => 'required|numeric|min:0',
            'work_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $validated['project_id'] = $project->id;

        StructureCost::create($validated);

        return redirect()->route('projects.structure-costs.index', $project)
            ->with('success', 'Structure cost added successfully.');
    }

    public function show(Project $project, StructureCost $structureCost)
    {
        $this->authorize('view', $project);

        if ($structureCost->project_id !== $project->id) {
            abort(404);
        }

        return view('structure-costs.show', compact('project', 'structureCost'));
    }

    public function edit(Project $project, StructureCost $structureCost)
    {
        $this->authorize('view', $project);

        if ($structureCost->project_id !== $project->id) {
            abort(404);
        }

        $structureTypes = [
            'foundation' => 'Foundation',
            'columns' => 'Columns',
            'beams' => 'Beams',
            'slabs' => 'Slabs',
            'roof' => 'Roof',
            'walls' => 'Walls',
            'other' => 'Other'
        ];

        $units = [
            'sq_ft' => 'Square Feet (sq ft)',
            'sq_meter' => 'Square Meter',
            'cubic_feet' => 'Cubic Feet (cft)',
            'cubic_meter' => 'Cubic Meter',
            'running_ft' => 'Running Feet',
            'pcs' => 'Pieces (pcs)',
            'load' => 'Load/Truck',
        ];

        return view('structure-costs.edit', compact('project', 'structureCost', 'structureTypes', 'units'));
    }

    public function update(Request $request, Project $project, StructureCost $structureCost)
    {
        $this->authorize('view', $project);

        if ($structureCost->project_id !== $project->id) {
            abort(404);
        }

        $validated = $request->validate([
            'structure_type' => 'required|in:foundation,columns,beams,slabs,roof,walls,other',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'quantity' => 'required|numeric|min:0',
            'unit' => 'required|string|max:50',
            'unit_price' => 'required|numeric|min:0',
            'work_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $structureCost->update($validated);

        return redirect()->route('projects.structure-costs.index', $project)
            ->with('success', 'Structure cost updated successfully.');
    }

    public function destroy(Project $project, StructureCost $structureCost)
    {
        $this->authorize('view', $project);

        if ($structureCost->project_id !== $project->id) {
            abort(404);
        }

        $structureCost->delete();

        return redirect()->route('projects.structure-costs.index', $project)
            ->with('success', 'Structure cost deleted successfully.');
    }
}
