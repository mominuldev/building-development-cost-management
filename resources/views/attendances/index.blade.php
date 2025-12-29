<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Daily Attendance - {{ $project->name }}
            </h2>
            <div class="flex gap-4">
                <a href="{{ route('projects.attendances.calendar', $project) }}" class="btn btn-sm btn-info">
                    Calendar View
                </a>
                <a href="{{ route('projects.show', $project) }}" class="btn btn-sm btn-ghost">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Project
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Date Filter & Stats -->
            <div class="card bg-base-100 shadow-xl mb-6">
                <div class="card-body">
                    <form method="GET" class="mb-4">
                        <div class="flex gap-4 items-center">
                            <label class="label">
                                <span class="label-text">Date:</span>
                            </label>
                            <input type="date" name="date" value="{{ $date }}"
                                   class="input input-bordered" />
                            <button type="submit" class="btn btn-primary">
                                Filter
                            </button>
                            <a href="{{ route('projects.attendances.index', $project) }}" class="btn btn-ghost">Clear</a>
                        </div>
                    </form>

                    <div class="stats stats-vertical lg:stats-horizontal bg-base-200">
                        <div class="stat">
                            <div class="stat-title">Total Workers</div>
                            <div class="stat-value text-primary">{{ $stats['total_workers'] }}</div>
                        </div>
                        <div class="stat">
                            <div class="stat-title">Present</div>
                            <div class="stat-value text-success">{{ $stats['present'] }}</div>
                        </div>
                        <div class="stat">
                            <div class="stat-title">Absent</div>
                            <div class="stat-value text-error">{{ $stats['absent'] }}</div>
                        </div>
                        <div class="stat">
                            <div class="stat-title">Leave</div>
                            <div class="stat-value text-warning">{{ $stats['leave'] }}</div>
                        </div>
                        <div class="stat">
                            <div class="stat-title">Total Wages</div>
                            <div class="stat-value text-secondary">{{ number_format($stats['total_wages'], 2) }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Attendance Marking -->
            <div class="card bg-base-100 shadow-xl mb-6">
                <div class="card-body">
                    <h3 class="card-title">Quick Attendance Marking - {{ \Carbon\Carbon::parse($date)->format('M d, Y') }}</h3>

                    @if($workers->count() > 0)
                        <form method="POST" action="{{ route('projects.attendances.bulk', $project) }}">
                            @csrf
                            <input type="hidden" name="attendance_date" value="{{ $date }}">

                            <div class="overflow-x-auto mt-4">
                                <table class="table table-zebra">
                                    <thead>
                                        <tr>
                                            <th>Worker</th>
                                            <th>Category</th>
                                            <th>Status</th>
                                            <th>Work Description</th>
                                            <th>Notes</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($workers as $worker)
                                            <tr>
                                                <td>
                                                    <div class="font-bold">{{ $worker->name }}</div>
                                                    <div class="text-xs text-gray-500">{{ ucfirst($worker->labor_type) }}</div>
                                                </td>
                                                <td>
                                                    @if($worker->category)
                                                        <div class="badge badge-ghost">{{ ucfirst($worker->category) }}</div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <input type="hidden" name="attendances[{{ $loop->index }}][worker_id]" value="{{ $worker->id }}">
                                                    <select name="attendances[{{ $loop->index }}][status]" class="select select-bordered select-lg">
                                                        <option value="present">Present</option>
                                                        <option value="absent">Absent</option>
                                                        <option value="half_day">Half Day</option>
                                                        <option value="leave">Leave</option>
                                                        <option value="holiday">Holiday</option>
                                                        <option value="overtime">Overtime</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text"
                                                           name="attendances[{{ $loop->index }}][work_description]"
                                                           placeholder="What work did they do?"
                                                           class="input input-bordered input-lg w-full">
                                                </td>
                                                <td>
                                                    <input type="text"
                                                           name="attendances[{{ $loop->index }}][notes]"
                                                           placeholder="Optional notes"
                                                           class="input input-bordered input-lg w-full">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="card-actions justify-end mt-6">
                                <button type="submit" class="btn btn-success">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Save All Attendance
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="alert alert-warning">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            <div>
                                <h3 class="font-bold">No workers yet!</h3>
                                <div class="text-xs">Add workers to start marking attendance.</div>
                            </div>
                            <a href="{{ route('projects.workers.create', $project) }}" class="btn btn-sm btn-primary">Add Worker</a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Detailed Attendance List -->
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h3 class="card-title">Attendance Records</h3>

                    @if($attendances->count() > 0)
                        <div class="overflow-x-auto mt-4">
                            <table class="table table-zebra">
                                <thead>
                                    <tr>
                                        <th>Worker</th>
                                        <th>Status</th>
                                        <th>Hours</th>
                                        <th>Wage</th>
                                        <th>Work Description</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($attendances as $attendance)
                                        <tr>
                                            <td>
                                                <div class="font-bold">{{ $attendance->worker->name }}</div>
                                            </td>
                                            <td>
                                                @if($attendance->status == 'present')
                                                    <div class="badge badge-success">Present</div>
                                                @elseif($attendance->status == 'absent')
                                                    <div class="badge badge-error">Absent</div>
                                                @elseif($attendance->status == 'leave')
                                                    <div class="badge badge-warning">Leave</div>
                                                @elseif($attendance->status == 'half_day')
                                                    <div class="badge badge-info">Half Day</div>
                                                @elseif($attendance->status == 'overtime')
                                                    <div class="badge badge-secondary">Overtime</div>
                                                @else
                                                    <div class="badge badge-ghost">{{ ucfirst($attendance->status) }}</div>
                                                @endif
                                            </td>
                                            <td>{{ $attendance->hours_worked }}</td>
                                            <td>
                                                <div class="font-bold">{{ number_format($attendance->wage_amount, 2) }}</div>
                                            </td>
                                            <td>
                                                @if($attendance->work_description)
                                                    <div>{{ $attendance->work_description }}</div>
                                                @endif
                                                @if($attendance->notes)
                                                    <div class="text-xs text-gray-500">{{ $attendance->notes }}</div>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="flex gap-2">
                                                    <a href="{{ route('projects.attendances.edit', [$project, $attendance]) }}" class="btn btn-xs btn-accent">Edit</a>
                                                    <form action="{{ route('projects.attendances.destroy', [$project, $attendance]) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-xs btn-error">Delete</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info mt-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <h3 class="font-bold">No attendance recorded</h3>
                                <div class="text-xs">Mark attendance for {{ \Carbon\Carbon::parse($date)->format('M d, Y') }} above.</div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
