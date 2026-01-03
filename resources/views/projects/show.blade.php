<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ $project->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Project Summary Stats -->
            <div class="stats stats-vertical lg:stats-horizontal shadow mb-8 w-full">
                <div class="stat">
                    <div class="stat-title">Estimated Budget</div>
                    <div class="stat-value text-primary">{{ number_format($project->estimated_budget, 0) }}</div>
                </div>

                <div class="stat">
                    <div class="stat-title">Total Spent</div>
                    <div class="stat-value text-secondary">{{ number_format($project->total_project_cost, 0) }}</div>
                </div>

                <div class="stat">
                    <div class="stat-title">Remaining</div>
                    <div class="stat-value {{ $project->budget_remaining < 0 ? 'text-error' : 'text-success' }}">
                        {{ number_format($project->budget_remaining, 0) }}
                    </div>
                </div>

                <div class="stat">
                    <div class="stat-title">Budget Used</div>
                    <div class="stat-value {{ $project->budget_usage_percentage > 90 ? 'text-error' : '' }}">
                        {{ number_format($project->budget_usage_percentage, 1) }}%
                    </div>
                    @if($project->budget_usage_percentage > 0)
                        <div class="stat-desc">Progress</div>
                        <progress class="progress progress-primary w-56" value="{{ min($project->budget_usage_percentage, 100) }}" max="100"></progress>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Cost Breakdown Card -->
                <div class="card bg-base-100 shadow-xl">
                    <div class="card-body">
                        <h3 class="card-title">Cost Breakdown</h3>
                        <div class="space-y-4 mt-4">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Materials</span>
                                <span class="font-bold">{{ number_format($project->total_material_cost, 2) }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Contractors</span>
                                <span class="font-bold">{{ number_format($project->total_labor_cost, 2) }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Structure</span>
                                <span class="font-bold">{{ number_format($project->total_structure_cost, 2) }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Finishing</span>
                                <span class="font-bold">{{ number_format($project->total_finishing_cost, 2) }}</span>
                            </div>
                            <div class="divider"></div>
                            <div class="flex justify-between items-center">
                                <span class="font-bold text-gray-900">Total</span>
                                <span class="font-bold text-primary text-lg">{{ number_format($project->total_project_cost, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Project Details Card -->
                <div class="card bg-base-100 shadow-xl">
                    <div class="card-body">
                        <h3 class="card-title">Project Details</h3>
                        <div class="space-y-3 mt-4">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Location</span>
                                <span class="font-medium">{{ $project->location ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Status</span>
                                @if($project->status == 'completed')
                                    <div class="badge badge-success">{{ ucfirst(str_replace('_', ' ', $project->status)) }}</div>
                                @elseif($project->status == 'in_progress')
                                    <div class="badge badge-info">{{ ucfirst(str_replace('_', ' ', $project->status)) }}</div>
                                @elseif($project->status == 'planning')
                                    <div class="badge badge-warning">{{ ucfirst(str_replace('_', ' ', $project->status)) }}</div>
                                @else
                                    <div class="badge badge-neutral">{{ ucfirst(str_replace('_', ' ', $project->status)) }}</div>
                                @endif
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Start Date</span>
                                <span class="font-medium">{{ $project->start_date?->format('M d, Y') ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">End Date</span>
                                <span class="font-medium">{{ $project->end_date?->format('M d, Y') ?? '-' }}</span>
                            </div>
                            @if($project->notes)
                                <div class="divider"></div>
                                <div>
                                    <span class="text-gray-600">Notes</span>
                                    <p class="mt-1 text-gray-900">{{ $project->notes }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mb-8">
                <a href="{{ route('projects.edit', $project) }}" class="btn btn-outline btn-primary gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit Project
                </a>
            </div>

            <!-- Cost Management Sections -->
            <div class="space-y-6">
                <!-- Materials Section -->
                <div class="card bg-base-100 shadow-xl">
                    <div class="card-body">
                        <div class="flex justify-between items-center">
                            <h3 class="card-title">Materials</h3>
                            <div class="flex gap-4">
                                <div class="badge badge-neutral">{{ $project->materials->count() }} items</div>
                                <div class="badge badge-primary">{{ number_format($project->total_material_cost, 2) }}</div>
                            </div>
                        </div>

                        @if($project->materials->count() > 0)
                            <div class="overflow-x-auto mt-4">
                                <table class="table table-sm">
                                    <tbody>
                                        @foreach($project->materials->take(3) as $material)
                                            <tr>
                                                <td>
                                                    <div class="flex items-center gap-2">
                                                        <span class="font-bold">{{ $material->name }}</span>
                                                        <div class="badge badge-info badge-sm">{{ ucfirst(str_replace('_', ' ', $material->material_type)) }}</div>
                                                    </div>
                                                </td>
                                                <td class="text-right">{{ number_format($material->total_cost, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif

                        <div class="card-actions justify-end">
                            <a href="{{ route('projects.materials.index', $project) }}" class="btn btn-primary">
                                @if($project->materials->count() > 0)
                                    Manage Materials
                                @else
                                    Add First Material
                                @endif
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Contractor Costs Section -->
                <div class="card bg-base-100 shadow-xl">
                    <div class="card-body">
                        <div class="flex justify-between items-center">
                            <h3 class="card-title">Contractor Costs</h3>
                            <div class="flex gap-4">
                                <div class="badge badge-neutral">{{ $project->contractorCosts->count() }} contractors</div>
                                <div class="badge badge-success">{{ number_format($project->total_labor_cost, 2) }}</div>
                            </div>
                        </div>

                        @if($project->contractorCosts->count() > 0)
                            <div class="overflow-x-auto mt-4">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Contractor</th>
                                            <th class="text-right">Total Bill</th>
                                            <th class="text-right">Paid</th>
                                            <th class="text-right">Due</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($project->contractorCosts->take(3) as $labor)
                                            @php
                                                $balance = $labor->total_due - $labor->total_payments_received;
                                            @endphp
                                            <tr>
                                                <td>
                                                    <div class="flex items-center gap-2">
                                                        <span class="font-bold">{{ $labor->name ?? 'Contractor' }}</span>
                                                        @if($labor->category)
                                                            <span class="badge badge-ghost badge-sm">{{ ucfirst($labor->category) }}</span>
                                                        @endif
                                                        <span class="badge badge-info badge-sm">{{ $labor->assigned_workers_count }} workers</span>
                                                    </div>
                                                </td>
                                                <td class="text-right">
                                                    <div class="font-bold">{{ number_format($labor->actual_total_cost, 2) }}</div>
                                                </td>
                                                <td class="text-right">
                                                    <div class="badge badge-success badge-sm">{{ number_format($labor->total_payments_received, 2) }}</div>
                                                </td>
                                                <td class="text-right">
                                                    @if($balance > 0)
                                                        <div class="badge badge-error badge-sm">{{ number_format($balance, 2) }}</div>
                                                    @else
                                                        <div class="badge badge-success badge-sm">Paid</div>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif

                        <div class="card-actions justify-end">
                            <a href="{{ route('projects.labor-costs.index', $project) }}" class="btn btn-success">
                                @if($project->contractorCosts->count() > 0)
                                    Manage Contractors
                                @else
                                    Add First Contractor
                                @endif
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Workers Section -->
                <div class="card bg-base-100 shadow-xl">
                    <div class="card-body">
                        <div class="flex justify-between items-center">
                            <h3 class="card-title">Workers</h3>
                            <div class="flex gap-4">
                                <div class="badge badge-neutral">{{ $project->total_workers }} workers</div>
                                <div class="badge badge-info">{{ $project->total_present_today }} present today</div>
                            </div>
                        </div>

                        @if($project->workers->count() > 0)
                            <div class="overflow-x-auto mt-4">
                                <table class="table table-sm">
                                    <tbody>
                                        @foreach($project->workers->take(3) as $worker)
                                            <tr>
                                                <td>
                                                    <div class="flex items-center gap-2">
                                                        <span class="font-bold">{{ $worker->name }}</span>
                                                        @if($worker->category)
                                                            <div class="badge badge-ghost badge-sm">{{ ucfirst($worker->category) }}</div>
                                                        @endif
                                                        @if($worker->is_active)
                                                            <div class="badge badge-success badge-sm">Active</div>
                                                        @else
                                                            <div class="badge badge-error badge-sm">Inactive</div>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="text-right">
                                                    <div class="badge badge-primary badge-sm">{{ ucfirst($worker->labor_type) }}</div>
                                                </td>
                                                <td class="text-right">{{ number_format($worker->daily_wage, 2) }}/day</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif

                        <div class="card-actions justify-end">
                            <a href="{{ route('projects.workers.index', $project) }}" class="btn btn-primary">
                                @if($project->workers->count() > 0)
                                    Manage Workers
                                @else
                                    Add First Worker
                                @endif
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Attendance Section -->
                <div class="card bg-base-100 shadow-xl">
                    <div class="card-body">
                        <div class="flex justify-between items-center">
                            <h3 class="card-title">Daily Attendance</h3>
                            <div class="flex gap-4">
                                <div class="badge badge-neutral">{{ $project->attendances()->whereDate('attendance_date', today())->count() }} records today</div>
                                <div class="badge badge-success">{{ number_format($project->attendances()->whereDate('attendance_date', today())->sum('wage_amount'), 2) }} wages today</div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <p class="text-gray-600">Track daily worker attendance, calculate wages automatically, and view attendance history.</p>
                        </div>

                        <div class="card-actions justify-end mt-4">
                            <a href="{{ route('projects.attendances.index', $project) }}" class="btn btn-success">
                                Mark Attendance
                            </a>
                            <a href="{{ route('projects.attendances.calendar', $project) }}" class="btn btn-outline">
                                View Calendar
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Structure Costs Section -->
                <div class="card bg-base-100 shadow-xl">
                    <div class="card-body">
                        <div class="flex justify-between items-center">
                            <h3 class="card-title">Structure Costs</h3>
                            <div class="flex gap-4">
                                <div class="badge badge-neutral">{{ $project->structureCosts->count() }} items</div>
                                <div class="badge badge-warning">{{ number_format($project->total_structure_cost, 2) }}</div>
                            </div>
                        </div>

                        @if($project->structureCosts->count() > 0)
                            <div class="overflow-x-auto mt-4">
                                <table class="table table-sm">
                                    <tbody>
                                        @foreach($project->structureCosts->take(3) as $structure)
                                            <tr>
                                                <td>
                                                    <div>
                                                        <span class="font-bold">{{ $structure->name }}</span>
                                                        @if($structure->description)
                                                            <span class="text-gray-500 text-xs ml-2">{{ Str::limit($structure->description, 30) }}</span>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="text-right">
                                                    <div class="badge badge-warning badge-sm">{{ ucfirst($structure->structure_type) }}</div>
                                                </td>
                                                <td class="text-right">{{ number_format($structure->total_cost, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif

                        <div class="card-actions justify-end">
                            <a href="{{ route('projects.structure-costs.index', $project) }}" class="btn btn-warning">
                                @if($project->structureCosts->count() > 0)
                                    Manage Structure Costs
                                @else
                                    Add First Structure Cost
                                @endif
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Finishing Works Section -->
                <div class="card bg-base-100 shadow-xl">
                    <div class="card-body">
                        <div class="flex justify-between items-center">
                            <h3 class="card-title">Finishing Works</h3>
                            <div class="flex gap-4">
                                <div class="badge badge-neutral">{{ $project->finishingWorks->count() }} items</div>
                                <div class="badge badge-secondary">{{ number_format($project->total_finishing_cost, 2) }}</div>
                            </div>
                        </div>

                        @if($project->finishingWorks->count() > 0)
                            <div class="overflow-x-auto mt-4">
                                <table class="table table-sm">
                                    <tbody>
                                        @foreach($project->finishingWorks->take(3) as $finishing)
                                            <tr>
                                                <td>
                                                    <div>
                                                        <span class="font-bold">{{ $finishing->name }}</span>
                                                        @if($finishing->description)
                                                            <span class="text-gray-500 text-xs ml-2">{{ Str::limit($finishing->description, 30) }}</span>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="text-right">
                                                    <div class="badge badge-secondary badge-sm">{{ ucfirst(str_replace('_', ' ', $finishing->work_type)) }}</div>
                                                </td>
                                                <td class="text-right">{{ number_format($finishing->total_cost, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif

                        <div class="card-actions justify-end">
                            <a href="{{ route('projects.finishing-works.index', $project) }}" class="btn btn-secondary">
                                @if($project->finishingWorks->count() > 0)
                                    Manage Finishing Works
                                @else
                                    Add First Finishing Work
                                @endif
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Payments Section -->
                <div class="card bg-base-100 shadow-xl">
                    <div class="card-body">
                        <div class="flex justify-between items-center">
                            <h3 class="card-title">Payments</h3>
                            <div class="flex gap-4">
                                <div class="badge badge-neutral">{{ $project->payments->count() }} payments</div>
                                <div class="badge badge-accent">{{ number_format($project->total_payments_made, 2) }} paid</div>
                            </div>
                        </div>

                        <div class="stats stats-vertical lg:stats-horizontal bg-base-200 mt-4">
                            <div class="stat">
                                <div class="stat-title">To Contractors</div>
                                <div class="stat-value text-primary">{{ number_format($project->total_contractor_payments, 0) }}</div>
                            </div>
                            <div class="stat">
                                <div class="stat-title">To Workers</div>
                                <div class="stat-value text-secondary">{{ number_format($project->total_worker_payments, 0) }}</div>
                            </div>
                            <div class="stat">
                                <div class="stat-title">Total Paid</div>
                                <div class="stat-value text-accent">{{ number_format($project->total_payments_made, 0) }}</div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <p class="text-gray-600">Track payments to contractors and workers, view payment history, and manage dues.</p>
                        </div>

                        <div class="card-actions justify-end mt-4">
                            <a href="{{ route('projects.payments.index', $project) }}" class="btn btn-accent">
                                @if($project->payments->count() > 0)
                                    View Payment History
                                @else
                                    Record First Payment
                                @endif
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
