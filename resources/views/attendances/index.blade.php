<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <div class="flex items-center gap-3">
                    <h2 class="text-2xl font-bold text-gray-900">Daily Attendance</h2>
                    <div class="badge badge-primary">{{ $project->name }}</div>
                </div>
                <p class="text-gray-500 mt-1">Track worker attendance and calculate wages</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('projects.attendances.calendar', $project) }}" class="btn btn-ghost btn-sm gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Calendar View
                </a>
                <a href="{{ route('projects.show', $project) }}" class="btn btn-ghost btn-sm gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Project
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Date Filter & Stats Section -->
            <div class="card bg-white shadow-xl">
                <div class="card-body">
                    <!-- Date Filter -->
                    <form method="GET" class="mb-6">
                        <div class="flex flex-wrap gap-3 items-end">
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-semibold text-gray-900">Select Date</span>
                                </label>
                                <div class="flex gap-2">
                                    <div class="relative">
                                        <input type="date" name="date" value="{{ $date }}"
                                            class="input input-bordered" />
                                    </div>
                                    <button type="submit" class="btn btn-primary gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                                        </svg>
                                        Filter
                                    </button>
                                    <a href="{{ route('projects.attendances.index', $project) }}" class="btn btn-ghost gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                        </svg>
                                        Today
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Summary Stats Cards -->
                    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                        <!-- Total Workers -->
                        <div class="card bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-200">
                            <div class="card-body p-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-gray-600">Total Workers</p>
                                        <p class="text-3xl font-bold text-blue-600">{{ $stats['total_workers'] }}</p>
                                    </div>
                                    <div class="h-12 w-12 rounded-xl bg-blue-500 flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Present -->
                        <div class="card bg-gradient-to-br from-green-50 to-emerald-50 border border-green-200">
                            <div class="card-body p-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-gray-600">Present</p>
                                        <p class="text-3xl font-bold text-green-600">{{ $stats['present'] }}</p>
                                    </div>
                                    <div class="h-12 w-12 rounded-xl bg-green-500 flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Absent -->
                        <div class="card bg-gradient-to-br from-red-50 to-rose-50 border border-red-200">
                            <div class="card-body p-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-gray-600">Absent</p>
                                        <p class="text-3xl font-bold text-red-600">{{ $stats['absent'] }}</p>
                                    </div>
                                    <div class="h-12 w-12 rounded-xl bg-red-500 flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Leave & Half Day -->
                        <div class="card bg-gradient-to-br from-yellow-50 to-amber-50 border border-yellow-200">
                            <div class="card-body p-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-gray-600">Leave</p>
                                        <p class="text-3xl font-bold text-yellow-600">{{ $stats['leave'] }}</p>
                                        <p class="text-xs text-gray-500 mt-1">Half Day: {{ $stats['half_day'] ?? 0 }}</p>
                                    </div>
                                    <div class="h-12 w-12 rounded-xl bg-yellow-500 flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Wages -->
                        <div class="card bg-gradient-to-br from-purple-50 to-violet-50 border border-purple-200">
                            <div class="card-body p-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-gray-600">Total Wages</p>
                                        <p class="text-2xl font-bold text-purple-600">{{ number_format($stats['total_wages'], 2) }}</p>
                                    </div>
                                    <div class="h-12 w-12 rounded-xl bg-purple-500 flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Attendance Marking -->
            <div class="card bg-white shadow-xl">
                <div class="card-body">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="h-10 w-10 rounded-lg bg-gradient-to-br from-green-500 to-emerald-500 flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Quick Attendance Marking</h3>
                            <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($date)->format('l, F d, Y') }}</p>
                        </div>
                    </div>

                    @if($workers->count() > 0)
                        <form method="POST" action="{{ route('projects.attendances.bulk', $project) }}">
                            @csrf
                            <input type="hidden" name="attendance_date" value="{{ $date }}">

                            <div class="overflow-x-auto">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Worker</th>
                                            <th>Category</th>
                                            <th>Daily Wage</th>
                                            <th>Status</th>
                                            <th>Work Description</th>
                                            <th>Notes</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($workers as $worker)
                                            <tr>
                                                <td>
                                                    <div class="flex items-center gap-3">
                                                        <div class="avatar placeholder">
                                                            <div class="bg-neutral text-neutral-content rounded-lg w-10">
                                                                <span class="text-sm flex justify-center items-center h-full">{{ substr($worker->name, 0, 1) }}</span>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <div class="font-bold text-gray-900">{{ $worker->name }}</div>
                                                            <div class="text-xs text-gray-500">{{ ucfirst($worker->labor_type) }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    @if($worker->category)
                                                        <div class="badge badge-info">{{ ucfirst($worker->category) }}</div>
                                                    @else
                                                        <div class="text-sm text-gray-400">-</div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="font-bold text-purple-600">{{ number_format($worker->daily_wage, 2) }}</div>
                                                </td>
                                                <td>
                                                    <input type="hidden" name="attendances[{{ $loop->index }}][worker_id]" value="{{ $worker->id }}">
                                                    <select name="attendances[{{ $loop->index }}][status]" class="select select-bordered select-md">
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
                                                           placeholder="Work done..."
                                                           class="input input-bordered input-md w-full max-w-xs">
                                                </td>
                                                <td>
                                                    <input type="text"
                                                           name="attendances[{{ $loop->index }}][notes]"
                                                           placeholder="Notes..."
                                                           class="input input-bordered input-md w-full max-w-xs">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="flex justify-end gap-3 mt-6 pt-4 border-t">
                                <a href="{{ route('projects.attendances.create', [$project, 'date' => $date]) }}" class="btn btn-ghost gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Add Single
                                </a>
                                <button type="submit" class="btn btn-success gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Save All Attendance
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="text-center py-12">
                            <div class="inline-flex h-20 w-20 items-center justify-center rounded-full bg-yellow-100 mb-4">
                                <svg class="w-10 h-10 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">No workers yet!</h3>
                            <p class="text-gray-500 mb-6">Add workers to start marking attendance</p>
                            <a href="{{ route('projects.workers.create', $project) }}" class="btn btn-primary gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Add Your First Worker
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Detailed Attendance List -->
            <div class="card bg-white shadow-xl">
                <div class="card-body">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-3">
                            <div class="h-10 w-10 rounded-lg bg-gradient-to-br from-blue-500 to-indigo-500 flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Attendance Records</h3>
                                <p class="text-sm text-gray-500">{{ $attendances->count() }} record{{ $attendances->count() != 1 ? 's' : '' }}</p>
                            </div>
                        </div>
                    </div>

                    @if($attendances->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Worker</th>
                                        <th>Status</th>
                                        <th class="text-right">Hours</th>
                                        <th class="text-right">Wage</th>
                                        <th>Details</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($attendances as $attendance)
                                        <tr class="hover">
                                            <td>
                                                <div class="flex items-center gap-3">
                                                    <div class="avatar placeholder">
                                                        <div class="bg-neutral text-neutral-content rounded-lg w-10">
                                                            <span class="text-sm flex items-center justify-center h-full">{{ substr($attendance->worker->name, 0, 1) }}</span>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="font-bold text-gray-900">{{ $attendance->worker->name }}</div>
                                                        <div class="text-xs text-gray-500">{{ ucfirst($attendance->worker->category ?? 'N/A') }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                @if($attendance->status == 'present')
                                                    <div class="badge badge-success badge-lg">Present</div>
                                                @elseif($attendance->status == 'absent')
                                                    <div class="badge badge-error badge-lg">Absent</div>
                                                @elseif($attendance->status == 'leave')
                                                    <div class="badge badge-warning badge-lg">Leave</div>
                                                @elseif($attendance->status == 'half_day')
                                                    <div class="badge badge-info badge-lg">Half Day</div>
                                                @elseif($attendance->status == 'overtime')
                                                    <div class="badge badge-secondary badge-lg">Overtime</div>
                                                @else
                                                    <div class="badge badge-ghost badge-lg">{{ ucfirst($attendance->status) }}</div>
                                                @endif
                                            </td>
                                            <td class="text-right">
                                                <div class="text-lg font-bold text-gray-900">{{ $attendance->hours_worked ?? '-' }}</div>
                                            </td>
                                            <td class="text-right">
                                                <div class="text-lg font-bold text-purple-600">{{ number_format($attendance->wage_amount, 2) }}</div>
                                            </td>
                                            <td>
                                                @if($attendance->work_description)
                                                    <div class="text-sm text-gray-900">{{ $attendance->work_description }}</div>
                                                @endif
                                                @if($attendance->notes)
                                                    <div class="text-xs text-gray-500">{{ $attendance->notes }}</div>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="flex gap-1 justify-center">
                                                    <a href="{{ route('projects.attendances.edit', [$project, $attendance]) }}" class="btn btn-ghost btn-xs btn-circle text-warning" title="Edit">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                        </svg>
                                                    </a>
                                                    <form action="{{ route('projects.attendances.destroy', [$project, $attendance]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this attendance record?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-ghost btn-xs btn-circle text-error" title="Delete">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="inline-flex h-20 w-20 items-center justify-center rounded-full bg-blue-100 mb-4">
                                <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">No attendance recorded</h3>
                            <p class="text-gray-500 mb-6">Mark attendance for {{ \Carbon\Carbon::parse($date)->format('M d, Y') }} using the form above</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
