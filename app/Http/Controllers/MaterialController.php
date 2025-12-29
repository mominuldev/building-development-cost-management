<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaterialController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Project $project)
    {
        $this->authorize('view', $project);

        $materials = $project->materials()->latest()->get();

        return view('materials.index', compact('project', 'materials'));
    }

    public function create(Project $project)
    {
        $this->authorize('view', $project);

        $materialTypes = [
            'bricks' => 'Bricks',
            'brick_chips' => 'Brick Chips',
            'cement' => 'Cement',
            'steel' => 'Steel (Rod)',
            'sand' => 'Sand',
            'stone' => 'Stone',
            'other' => 'Other'
        ];

        $units = [
            'pcs' => 'Pieces (pcs)',
            'bags' => 'Bags',
            'kg' => 'Kilograms (kg)',
            'tons' => 'Tons',
            'cubic_feet' => 'Cubic Feet (cft)',
            'cubic_meter' => 'Cubic Meter',
            'sq_ft' => 'Square Feet (sq ft)',
            'sq_meter' => 'Square Meter',
            'running_ft' => 'Running Feet',
            'load' => 'Load/Truck',
        ];

        return view('materials.create', compact('project', 'materialTypes', 'units'));
    }

    public function store(Request $request, Project $project)
    {
        $this->authorize('view', $project);

        $validated = $request->validate([
            'material_type' => 'required|in:bricks,brick_chips,cement,steel,sand,stone,other',
            'name' => 'required|string|max:255',
            'quantity' => 'required|numeric|min:0',
            'unit' => 'required|string|max:50',
            'unit_price' => 'required|numeric|min:0',
            'purchase_date' => 'required|date',
            'supplier' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $validated['project_id'] = $project->id;

        Material::create($validated);

        return redirect()->route('projects.materials.index', $project)
            ->with('success', 'Material added successfully.');
    }

    public function show(Project $project, Material $material)
    {
        $this->authorize('view', $project);

        if ($material->project_id !== $project->id) {
            abort(404);
        }

        return view('materials.show', compact('project', 'material'));
    }

    public function edit(Project $project, Material $material)
    {
        $this->authorize('view', $project);

        if ($material->project_id !== $project->id) {
            abort(404);
        }

        $materialTypes = [
            'bricks' => 'Bricks',
            'brick_chips' => 'Brick Chips',
            'cement' => 'Cement',
            'steel' => 'Steel (Rod)',
            'sand' => 'Sand',
            'stone' => 'Stone',
            'other' => 'Other'
        ];

        $units = [
            'pcs' => 'Pieces (pcs)',
            'bags' => 'Bags',
            'kg' => 'Kilograms (kg)',
            'tons' => 'Tons',
            'cubic_feet' => 'Cubic Feet (cft)',
            'cubic_meter' => 'Cubic Meter',
            'sq_ft' => 'Square Feet (sq ft)',
            'sq_meter' => 'Square Meter',
            'running_ft' => 'Running Feet',
            'load' => 'Load/Truck',
        ];

        return view('materials.edit', compact('project', 'material', 'materialTypes', 'units'));
    }

    public function update(Request $request, Project $project, Material $material)
    {
        $this->authorize('view', $project);

        if ($material->project_id !== $project->id) {
            abort(404);
        }

        $validated = $request->validate([
            'material_type' => 'required|in:bricks,brick_chips,cement,steel,sand,stone,other',
            'name' => 'required|string|max:255',
            'quantity' => 'required|numeric|min:0',
            'unit' => 'required|string|max:50',
            'unit_price' => 'required|numeric|min:0',
            'purchase_date' => 'required|date',
            'supplier' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $material->update($validated);

        return redirect()->route('projects.materials.index', $project)
            ->with('success', 'Material updated successfully.');
    }

    public function destroy(Project $project, Material $material)
    {
        $this->authorize('view', $project);

        if ($material->project_id !== $project->id) {
            abort(404);
        }

        $material->delete();

        return redirect()->route('projects.materials.index', $project)
            ->with('success', 'Material deleted successfully.');
    }
}
