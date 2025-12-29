<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ $worker->name }} - Worker Details
            </h2>
            <a href="{{ route('projects.workers.index', $project) }}" class="btn btn-sm btn-ghost">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Workers
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                <!-- Worker Info Card -->
                <div class="card bg-base-100 shadow-xl">
                    <div class="card-body">
                        <h3 class="card-title">Worker Information</h3>
                        <div class="space-y-3 mt-4">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Name</span>
                                <span class="font-medium">{{ $worker->name }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Phone</span>
                                <span class="font-medium">{{ $worker->phone ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Email</span>
                                <span class="font-medium">{{ $worker->email ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Labor Type</span>
                                <span class="font-medium">{{ ucfirst(str_replace('_', ' ', $worker->labor_type)) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Category</span>
                                <span class="font-medium">{{ ucfirst($worker->category) ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Daily Wage</span>
                                <span class="font-medium">{{ number_format($worker->daily_wage, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Status</span>
                                @if($worker->is_active)
                                    <div class="badge badge-success">Active</div>
                                @else
                                    <div class="badge badge-error">Inactive</div>
                                @endif
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Hire Date</span>
                                <span class="font-medium">{{ $worker->hire_date?->format('M d, Y') ?? '-' }}</span>
                            </div>
                        </div>

                        @if($worker->address || $worker->notes)
                            <div class="divider"></div>
                            @if($worker->address)
                                <div>
                                    <span class="text-gray-600">Address</span>
                                    <p class="mt-1">{{ $worker->address }}</p>
                                </div>
                            @endif
                            @if($worker->notes)
                                <div class="mt-3">
                                    <span class="text-gray-600">Notes</span>
                                    <p class="mt-1">{{ $worker->notes }}</p>
                                </div>
                            @endif
                        @endif

                        <div class="card-actions justify-end mt-4">
                            <a href="{{ route('projects.workers.edit', [$project, $worker]) }}" class="btn btn-sm btn-primary">Edit Worker</a>
                        </div>
                    </div>
                </div>

                <!-- Stats Card -->
                <div class="card bg-base-100 shadow-xl">
                    <div class="card-body">
                        <h3 class="card-title">Work Statistics</h3>
                        <div class="stats stats-vertical bg-base-200">
                            <div class="stat">
                                <div class="stat-title">Days Worked</div>
                                <div class="stat-value text-primary">{{ $worker->total_days_worked }}</div>
                            </div>
                            <div class="stat">
                                <div class="stat-title">Total Earned</div>
                                <div class="stat-value text-secondary">{{ number_format($worker->total_wages_earned, 0) }}</div>
                            </div>
                            <div class="stat">
                                <div class="stat-title">Attendance Rate</div>
                                <div class="stat-value text-success">{{ number_format($worker->attendance_percentage, 1) }}%</div>
                            </div>
                        </div>

                        <h3 class="card-title mt-4 mb-0">Assigned Contractors</h3>

                        @if($worker->contractors->count() > 0 || $worker->primaryContractor)
                            <div class="space-y-3 mt-4">
                                @if($worker->primaryContractor)
                                    <div class="alert alert-info">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        <div>
                                            <div class="font-bold">Primary Contractor</div>
                                            <div class="text-sm">{{ $worker->primaryContractor->name }}</div>
                                            <div class="badge badge-ghost badge-sm mt-1">{{ ucfirst($worker->primaryContractor->category) }}</div>
                                        </div>
                                    </div>
                                @endif

                                @if($worker->contractors->count() > 0)
                                    <div class="divider">@if($worker->primaryContractor) Other Contractors @else Contractors @endif</div>
                                    @foreach($worker->contractors as $contractor)
                                        @if($worker->primaryContractor && $contractor->id === $worker->primaryContractor->id)
                                            @continue
                                        @endif
                                        <div class="card bg-base-200">
                                            <div class="card-body p-4">
                                                <div class="flex justify-between items-center">
                                                    <div>
                                                        <div class="font-bold">{{ $contractor->name }}</div>
                                                        <div class="badge badge-ghost badge-sm">{{ ucfirst($contractor->category) }}</div>
                                                    </div>
                                                    <a href="{{ route('projects.contractors.workers.index', [$project, $contractor]) }}"
                                                       class="btn btn-xs btn-outline">View</a>
                                                </div>
                                                @if($contractor->pivot->notes)
                                                    <div class="text-xs text-gray-600 mt-2">{{ $contractor->pivot->notes }}</div>
                                                @endif
                                                @if($contractor->pivot->assigned_date)
                                                    <div class="text-xs text-gray-500 mt-1">
                                                        Assigned: {{ $contractor->pivot->assigned_date->format('M d, Y') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        @else
                            <div class="alert alert-warning mt-4">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                                <div>
                                    <h3 class="font-bold">No Contractor Assigned</h3>
                                    <div class="text-xs">This worker is not assigned to any contractor.</div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Quick Actions Card -->
                <div class="card bg-base-100 shadow-xl">
                    <div class="card-body">
                        <h3 class="card-title">Quick Actions</h3>
                        <div class="space-y-3 mt-4">
                            <a href="{{ route('projects.attendances.create', ['project' => $project, 'worker_id' => $worker->id]) }}"
                               class="btn btn-success btn-block">
                                Mark Attendance Today
                            </a>
                            <a href="{{ route('projects.attendances.calendar', ['project' => $project, 'date' => now()->format('Y-m')]) }}"
                               class="btn btn-info btn-block">
                                View Attendance Calendar
                            </a>
                            <a href="{{ route('projects.attendances.index', ['project' => $project, 'worker_id' => $worker->id]) }}"
                               class="btn btn-outline btn-block">
                                View Attendance History
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Attendance History -->
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h3 class="card-title">Recent Attendance (Last 30 Days)</h3>

                    @if($worker->attendances->count() > 0)
                        <div class="overflow-x-auto mt-4">
                            <table class="table table-zebra">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Hours</th>
                                        <th>Wage</th>
                                        <th>Work Description</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($worker->attendances as $attendance)
                                        <tr>
                                            <td>{{ $attendance->attendance_date->format('M d, Y') }}</td>
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
                                            <td>{{ number_format($attendance->wage_amount, 2) }}</td>
                                            <td>{{ $attendance->work_description ?? '-' }}</td>
                                            <td>
                                                <a href="{{ route('projects.attendances.edit', [$project, $attendance]) }}"
                                                   class="btn btn-xs btn-accent">Edit</a>
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
                                <div class="text-xs">Start tracking this worker's daily attendance.</div>
                            </div>
                            <a href="{{ route('projects.attendances.create', ['project' => $project, 'worker_id' => $worker->id]) }}"
                               class="btn btn-sm btn-success">Mark Attendance</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
