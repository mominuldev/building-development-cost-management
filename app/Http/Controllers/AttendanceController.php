<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Worker;
use App\Models\Attendance;
use App\Models\LaborCost;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Project $project, Request $request)
    {
        $this->authorize('view', $project);

        $date = $request->get('date', today()->toDateString());
        $category = $request->get('category');
        $status = $request->get('status');

        $query = $project->attendances()
            ->with('worker')
            ->where('attendance_date', $date);

        if ($category) {
            $query->whereHas('worker', function($q) use ($category) {
                $q->where('category', $category);
            });
        }

        if ($status) {
            $query->where('status', $status);
        }

        $attendances = $query->latest()->get();
        $workers = $project->workers()->active()->get();

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

        $stats = [
            'total_workers' => $workers->count(),
            'present' => $attendances->where('status', 'present')->count(),
            'absent' => $attendances->where('status', 'absent')->count(),
            'leave' => $attendances->where('status', 'leave')->count(),
            'half_day' => $attendances->where('status', 'half_day')->count(),
            'total_wages' => $attendances->sum('wage_amount'),
        ];

        return view('attendances.index', compact(
            'project',
            'attendances',
            'workers',
            'categories',
            'date',
            'stats'
        ));
    }

    public function calendar(Project $project, Request $request)
    {
        $this->authorize('view', $project);

        $date = $request->get('date') ? Carbon::parse($request->get('date')) : now();

        $attendances = $project->attendances()
            ->with('worker')
            ->whereMonth('attendance_date', $date->month)
            ->whereYear('attendance_date', $date->year)
            ->get()
            ->keyBy(function($item) {
                return $item->worker_id . '_' . $item->attendance_date->toDateString();
            });

        $workers = $project->workers()->active()->latest()->get();

        $daysInMonth = $date->daysInMonth;
        $dates = collect();
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $dates->push(Carbon::create($date->year, $date->month, $day));
        }

        return view('attendances.calendar', compact(
            'project',
            'workers',
            'attendances',
            'dates',
            'date'
        ));
    }

    public function create(Project $project, Request $request)
    {
        $this->authorize('view', $project);

        $date = $request->get('date', today()->toDateString());
        $workerId = $request->get('worker_id');

        $workers = $project->workers()->active()->get();
        $laborCosts = $project->contractorCosts()->attendanceBased()->get();

        return view('attendances.create', compact(
            'project',
            'workers',
            'laborCosts',
            'date',
            'workerId'
        ));
    }

    public function store(Request $request, Project $project)
    {
        $this->authorize('view', $project);

        $validated = $request->validate([
            'worker_id' => 'required|exists:workers,id',
            'labor_cost_id' => 'nullable|exists:labor_costs,id',
            'attendance_date' => 'required|date',
            'status' => 'required|in:present,absent,leave,half_day,holiday,overtime',
            'hours_worked' => 'nullable|numeric|min:0|max:24',
            'work_description' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        // Validate worker belongs to project
        $worker = Worker::find($validated['worker_id']);
        if ($worker->project_id !== $project->id) {
            return back()->withInput()->withErrors(['worker_id' => 'Invalid worker selected.']);
        }

        // Validate labor_cost_id if provided
        if (!empty($validated['labor_cost_id'])) {
            $laborCost = LaborCost::find($validated['labor_cost_id']);
            if ($laborCost && $laborCost->project_id !== $project->id) {
                return back()->withInput()->withErrors(['labor_cost_id' => 'Invalid labor cost selected.']);
            }
        }

        $validated['project_id'] = $project->id;

        // Check for existing record first and update or create
        $attendance = Attendance::where('worker_id', $validated['worker_id'])
            ->where('attendance_date', $validated['attendance_date'])
            ->first();

        if ($attendance) {
            $attendance->update($validated);
            $message = 'Attendance updated successfully.';
        } else {
            Attendance::create($validated);
            $message = 'Attendance recorded successfully.';
        }

        return redirect()->route('projects.attendances.index', [
            'project' => $project,
            'date' => $validated['attendance_date']
        ])->with('success', $message);
    }

    public function bulkStore(Request $request, Project $project)
    {
        $this->authorize('view', $project);

        $validated = $request->validate([
            'attendance_date' => 'required|date',
            'labor_cost_id' => 'nullable|exists:labor_costs,id',
            'attendances' => 'required|array',
            'attendances.*.worker_id' => 'required|exists:workers,id',
            'attendances.*.status' => 'required|in:present,absent,leave,half_day,holiday,overtime',
            'attendances.*.work_description' => 'nullable|string',
            'attendances.*.notes' => 'nullable|string',
        ]);

        // Validate labor_cost_id if provided
        if (!empty($validated['labor_cost_id'])) {
            $laborCost = LaborCost::find($validated['labor_cost_id']);
            if ($laborCost && $laborCost->project_id !== $project->id) {
                return back()->withErrors(['labor_cost_id' => 'Invalid labor cost selected.']);
            }
        }

        $created = 0;
        $updated = 0;
        $skipped = 0;

        foreach ($validated['attendances'] as $attendanceData) {
            // Verify worker belongs to project
            $worker = Worker::find($attendanceData['worker_id']);
            if ($worker->project_id !== $project->id) {
                $skipped++;
                continue;
            }

            $attendanceData['project_id'] = $project->id;
            $attendanceData['labor_cost_id'] = $validated['labor_cost_id'] ?? null;
            $attendanceData['attendance_date'] = $validated['attendance_date'];

            $attendance = Attendance::where('worker_id', $attendanceData['worker_id'])
                ->where('attendance_date', $attendanceData['attendance_date'])
                ->first();

            if ($attendance) {
                $attendance->update($attendanceData);
                $updated++;
            } else {
                Attendance::create($attendanceData);
                $created++;
            }
        }

        return redirect()->route('projects.attendances.index', [
            'project' => $project,
            'date' => $validated['attendance_date']
        ])->with('success', "Attendance recorded: {$created} created, {$updated} updated, {$skipped} skipped.");
    }

    public function show(Project $project, Attendance $attendance)
    {
        $this->authorize('view', $project);

        if ($attendance->project_id !== $project->id) {
            abort(404);
        }

        $attendance->load('worker');

        return view('attendances.show', compact('project', 'attendance'));
    }

    public function edit(Project $project, Attendance $attendance)
    {
        $this->authorize('view', $project);

        if ($attendance->project_id !== $project->id) {
            abort(404);
        }

        $workers = $project->workers()->active()->get();
        $laborCosts = $project->contractorCosts()->attendanceBased()->get();

        return view('attendances.edit', compact(
            'project',
            'attendance',
            'workers',
            'laborCosts'
        ));
    }

    public function update(Request $request, Project $project, Attendance $attendance)
    {
        $this->authorize('view', $project);

        if ($attendance->project_id !== $project->id) {
            abort(404);
        }

        $validated = $request->validate([
            'worker_id' => 'required|exists:workers,id',
            'labor_cost_id' => 'nullable|exists:labor_costs,id',
            'attendance_date' => 'required|date',
            'status' => 'required|in:present,absent,leave,half_day,holiday,overtime',
            'hours_worked' => 'nullable|numeric|min:0|max:24',
            'work_description' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        // Validate worker belongs to project
        $worker = Worker::find($validated['worker_id']);
        if ($worker->project_id !== $project->id) {
            return back()->withInput()->withErrors(['worker_id' => 'Invalid worker selected.']);
        }

        $attendance->update($validated);

        return redirect()->route('projects.attendances.index', [
            'project' => $project,
            'date' => $attendance->attendance_date
        ])->with('success', 'Attendance updated successfully.');
    }

    public function destroy(Project $project, Attendance $attendance)
    {
        $this->authorize('view', $project);

        if ($attendance->project_id !== $project->id) {
            abort(404);
        }

        $date = $attendance->attendance_date;
        $attendance->delete();

        return redirect()->route('projects.attendances.index', [
            'project' => $project,
            'date' => $date
        ])->with('success', 'Attendance deleted successfully.');
    }
}
