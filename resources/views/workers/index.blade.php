<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Workers - {{ $project->name }}
            </h2>
            <div class="flex gap-4">
                <a href="{{ route('projects.attendances.calendar', $project) }}" class="text-sm text-gray-600 hover:text-gray-900">
                    View Attendance Calendar
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
            <!-- Summary Stats -->
            <div class="stats stats-vertical lg:stats-horizontal shadow mb-6 w-full">
                <div class="stat">
                    <div class="stat-title">Total Workers</div>
                    <div class="stat-value text-primary">{{ $workers->count() }}</div>
                </div>

                <div class="stat">
                    <div class="stat-title">Active Workers</div>
                    <div class="stat-value text-success">{{ $workers->where('is_active', true)->count() }}</div>
                </div>

                <div class="stat">
                    <div class="stat-title">Present Today</div>
                    <div class="stat-value text-info">{{ $workers->where('is_present_today', true)->count() }}</div>
                </div>

                <div class="stat">
                    <div class="stat-title">Total Wages Paid</div>
                    <div class="stat-value text-secondary">{{ number_format($workers->sum('total_wages_earned'), 0) }}</div>
                </div>
            </div>

            <!-- Today's Attendance Bill -->
            <div class="card bg-base-100 shadow-xl mb-6">
                <div class="card-body">
                    <div class="flex justify-between items-center">
                        <h3 class="card-title">Today's Attendance Bill - {{ today()->format('M d, Y') }}</h3>
                        <a href="{{ route('projects.attendances.create', ['project' => $project, 'date' => today()->format('Y-m-d')]) }}" class="btn btn-sm btn-success">
                            Mark Attendance
                        </a>
                    </div>

                    <div class="stats stats-vertical lg:stats-horizontal bg-base-200 mt-4">
                        <div class="stat">
                            <div class="stat-title">Workers Present</div>
                            <div class="stat-value text-success">{{ $todayStats['total_workers_present'] }}</div>
                        </div>
                        <div class="stat">
                            <div class="stat-title">Workers Absent</div>
                            <div class="stat-value text-error">{{ $todayStats['total_workers_absent'] }}</div>
                        </div>
                        <div class="stat">
                            <div class="stat-title">Total Hours</div>
                            <div class="stat-value text-info">{{ number_format($todayStats['total_hours'], 1) }}</div>
                        </div>
                        <div class="stat">
                            <div class="stat-title">Today's Bill</div>
                            <div class="stat-value text-primary">{{ number_format($todayStats['total_bill'], 2) }}</div>
                            <div class="stat-desc">Total wage amount</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Workers Table -->
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="card-title">All Workers</h3>
                        <a href="{{ route('projects.workers.create', $project) }}" class="btn btn-primary gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Add Worker
                        </a>
                    </div>

                    @if($workers->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="table table-zebra">
                                <thead>
                                    <tr>
                                        <th>Worker</th>
                                        <th>Type</th>
                                        <th>Category</th>
                                        <th>Contractor</th>
                                        <th>Daily Wage</th>
                                        <th>Days Worked</th>
                                        <th>Total Earned</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($workers as $worker)
                                        <tr>
                                            <td>
                                                <div>
                                                    <div class="font-bold">{{ $worker->name }}</div>
                                                    @if($worker->phone)
                                                        <div class="text-xs text-gray-500">{{ $worker->phone }}</div>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <div class="badge badge-primary">{{ $laborTypes[$worker->labor_type] ?? ucfirst($worker->labor_type) }}</div>
                                            </td>
                                            <td>
                                                @if($worker->category)
                                                    <span>{{ ucfirst($worker->category) }}</span>
                                                @else
                                                    <span class="text-gray-400">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($worker->primaryContractor)
                                                    <div class="badge badge-info">{{ \Illuminate\Support\Str::limit($worker->primaryContractor->name, 15) }}</div>
                                                @elseif($worker->contractors->count() > 0)
                                                    <div class="badge badge-ghost">{{ $worker->contractors->count() }} assigned</div>
                                                @else
                                                    <span class="text-gray-400">-</span>
                                                @endif
                                            </td>
                                            <td>{{ number_format($worker->daily_wage, 2) }}</td>
                                            <td>{{ $worker->total_days_worked }}</td>
                                            <td>
                                                <div class="font-bold">{{ number_format($worker->total_wages_earned, 2) }}</div>
                                            </td>
                                            <td>
                                                @if($worker->is_active)
                                                    <div class="badge badge-success">Active</div>
                                                @else
                                                    <div class="badge badge-error">Inactive</div>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="flex gap-2">
                                                    <a href="{{ route('projects.workers.show', [$project, $worker]) }}" class="btn btn-xs btn-info">View</a>
                                                    <a href="{{ route('projects.workers.edit', [$project, $worker]) }}" class="btn btn-xs btn-accent">Edit</a>
                                                    <form action="{{ route('projects.workers.destroy', [$project, $worker]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this worker?')">
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
                        <div class="alert alert-info">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-5.714-2.143L2 12l5.714-2.143L11 3z"></path>
                            </svg>
                            <div>
                                <h3 class="font-bold">No workers yet!</h3>
                                <div class="text-xs">Start tracking your workers and their daily attendance.</div>
                            </div>
                            <a href="{{ route('projects.workers.create', $project) }}" class="btn btn-sm btn-primary">Add First Worker</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
