<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Workers under {{ $contractor->name ?? 'Contractor #' . $contractor->id }} - {{ $project->name }}
            </h2>
            <a href="{{ route('projects.labor-costs.index', $project) }}" class="btn btn-sm btn-ghost">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Contractors
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Contractor Info -->
            <div class="card bg-base-100 shadow-xl mb-6">
                <div class="card-body">
                    <h3 class="card-title">Contractor Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                        <div class="bg-base-200 rounded-lg p-4">
                            <div class="text-sm text-gray-600">Contractor</div>
                            <div class="font-bold text-lg">{{ $contractor->name ?? 'Unnamed Contractor' }}</div>
                            <div class="text-xs text-gray-500">{{ ucfirst($contractor->category) }}</div>
                        </div>
                        <div class="bg-base-200 rounded-lg p-4">
                            <div class="text-sm text-gray-600">Wage Calculation</div>
                            @if($contractor->use_uniform_wage)
                                <div class="font-bold text-lg">Uniform Daily</div>
                                <div class="text-xs text-gray-500">Using worker's daily wage × days worked</div>
                            @else
                                <div class="font-bold text-lg">Individual</div>
                                <div class="text-xs text-gray-500">Based on attendance wages</div>
                            @endif
                        </div>
                        <div class="bg-base-200 rounded-lg p-4">
                            <div class="text-sm text-gray-600">Total Bill</div>
                            <div class="font-bold text-lg">{{ number_format($contractor->actual_total_cost, 2) }}</div>
                            <div class="text-xs text-gray-500">From workers' attendance</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Summary -->
            <div class="card bg-base-100 shadow-xl mb-6">
                <div class="card-body">
                    <h3 class="card-title">Payment Summary</h3>
                    <div class="stats stats-vertical lg:stats-horizontal bg-base-200">
                        <div class="stat">
                            <div class="stat-title">Total Wages Earned</div>
                            <div class="stat-value text-primary">{{ number_format($workers->sum('total_wages_earned'), 2) }}</div>
                        </div>
                        <div class="stat">
                            <div class="stat-title">Paid to Workers</div>
                            <div class="stat-value text-success">{{ number_format($workers->sum('total_payments_received'), 2) }}</div>
                        </div>
                        <div class="stat">
                            <div class="stat-title">Due to Workers</div>
                            <div class="stat-value text-warning">{{ number_format($workers->sum(function($w) { return $w->amount_due; }), 2) }}</div>
                        </div>
                        <div class="stat">
                            <div class="stat-title">Paid to Contractor</div>
                            <div class="stat-value text-secondary">{{ number_format($contractor->total_payments_received, 2) }}</div>
                        </div>
                    </div>
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
                            <div class="stat-title">Active Workers</div>
                            <div class="stat-value text-success">{{ $todayStats['active_workers'] }}</div>
                            <div class="stat-desc">of {{ $todayStats['total_workers'] }} total</div>
                        </div>
                        <div class="stat">
                            <div class="stat-title">Present Today</div>
                            <div class="stat-value text-info">{{ $todayStats['total_present_today'] }}</div>
                        </div>
                        <div class="stat">
                            <div class="stat-title">Absent Today</div>
                            <div class="stat-value text-error">{{ $todayStats['total_absent_today'] }}</div>
                        </div>
                        <div class="stat">
                            <div class="stat-title">Total Hours</div>
                            <div class="stat-value">{{ number_format($todayStats['total_hours_today'], 1) }}</div>
                        </div>
                        <div class="stat">
                            <div class="stat-title">Today's Bill</div>
                            <div class="stat-value text-primary">{{ number_format($todayStats['total_bill_today'], 2) }}</div>
                            <div class="stat-desc">Total wage amount</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Assign Worker Form -->
            <div class="card bg-base-100 shadow-xl mb-6">
                <div class="card-body">
                    <h3 class="card-title">Assign Worker to Contractor</h3>
                    <form method="POST" action="{{ route('projects.contractors.workers.attach', [$project, $contractor]) }}" class="mt-4">
                        @csrf
                        <div class="flex gap-4 items-end">
                            <div class="form-control flex-1">
                                <label class="label">
                                    <span class="label-text">Select Worker</span>
                                </label>
                                <select name="worker_id" class="select select-bordered" required>
                                    <option value="">Select Worker...</option>
                                    @foreach($project->workers()->active()->whereNotIn('id', $workers->pluck('id'))->get() as $worker)
                                        <option value="{{ $worker->id }}">{{ $worker->name }} - {{ ucfirst($worker->category) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">Assigned Date</span>
                                </label>
                                <input type="date" name="assigned_date" value="{{ today()->toDateString() }}" class="input input-bordered" />
                            </div>
                            <button type="submit" class="btn btn-primary">Assign Worker</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Workers List -->
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h3 class="card-title">Assigned Workers ({{ $workers->count() }})</h3>

                    @if($workers->count() > 0)
                        <div class="overflow-x-auto mt-4">
                            <table class="table table-zebra">
                                <thead>
                                    <tr>
                                        <th>Worker</th>
                                        <th>Category</th>
                                        <th>Days Worked</th>
                                        <th>Wages Earned</th>
                                        <th>Paid</th>
                                        <th>Due</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($workers as $worker)
                                        <tr>
                                            <td>
                                                <div class="font-bold">{{ $worker->name }}</div>
                                                @if($worker->phone)
                                                    <div class="text-xs text-gray-500">{{ $worker->phone }}</div>
                                                @endif
                                            </td>
                                            <td>
                                                @if($worker->category)
                                                    <div class="badge badge-ghost">{{ ucfirst($worker->category) }}</div>
                                                @endif
                                                <div class="text-xs text-gray-500">{{ ucfirst($worker->labor_type) }}</div>
                                            </td>
                                            <td>
                                                <div class="font-bold">{{ $worker->total_days_worked }}</div>
                                                <div class="text-xs text-gray-500">{{ $worker->daily_wage }}/day</div>
                                            </td>
                                            <td>
                                                <div class="font-bold">{{ number_format($worker->total_wages_earned, 2) }}</div>
                                            </td>
                                            <td>
                                                <div class="font-bold text-success">{{ number_format($worker->total_payments_received, 2) }}</div>
                                            </td>
                                            <td>
                                                <div class="font-bold {{ $worker->amount_due > 0 ? 'text-warning' : 'text-success' }}">
                                                    {{ number_format($worker->amount_due, 2) }}
                                                </div>
                                            </td>
                                            <td>
                                                @if($worker->payment_status == 'paid')
                                                    <div class="badge badge-success">Paid</div>
                                                @elseif($worker->payment_status == 'partial')
                                                    <div class="badge badge-warning">Partial</div>
                                                @else
                                                    <div class="badge badge-error">Pending</div>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="flex gap-2">
                                                    <a href="{{ route('projects.workers.show', [$project, $worker]) }}" class="btn btn-xs btn-info">View</a>
                                                    <form action="{{ route('projects.contractors.workers.detach', [$project, $contractor, $worker]) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove this worker from the contractor?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-xs btn-error">Remove</button>
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
                                <h3 class="font-bold">No workers assigned</h3>
                                <div class="text-xs">Assign workers to this contractor to track their payments.</div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
