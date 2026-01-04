<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <div class="flex items-center gap-3">
                    <h2 class="text-2xl font-bold text-gray-900">{{ $project->name }}</h2>
                    @if($project->status == 'completed')
                        <div class="badge badge-success gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Completed
                        </div>
                    @elseif($project->status == 'in_progress')
                        <div class="badge badge-info gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            In Progress
                        </div>
                    @elseif($project->status == 'planning')
                        <div class="badge badge-warning gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            Planning
                        </div>
                    @else
                        <div class="badge badge-neutral">{{ ucfirst(str_replace('_', ' ', $project->status)) }}</div>
                    @endif
                </div>
                @if($project->location)
                    <p class="text-gray-500 mt-1 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        {{ $project->location }}
                    </p>
                @endif
            </div>
            <div class="flex gap-2">
                <a href="{{ route('projects.index') }}" class="btn btn-ghost btn-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back
                </a>
                <a href="{{ route('projects.edit', $project) }}" class="btn btn-primary btn-sm gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit Project
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Budget Overview Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Budget Card -->
                <div class="stats shadow bg-white">
                    <div class="stat">
                        <div class="stat-figure text-primary">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="stat-title">Estimated Budget</div>
                        <div class="stat-value text-primary">{{ number_format($project->estimated_budget, 0) }}</div>
                        <div class="stat-desc">Total project budget</div>
                    </div>
                </div>

                <!-- Spent Card -->
                <div class="stats shadow bg-white">
                    <div class="stat">
                        <div class="stat-figure text-secondary">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <div class="stat-title">Total Spent</div>
                        <div class="stat-value text-secondary">{{ number_format($project->total_project_cost, 0) }}</div>
                        <div class="stat-desc">{{ number_format(($project->total_project_cost / max($project->estimated_budget, 1)) * 100, 1) }}% used</div>
                    </div>
                </div>

                <!-- Remaining Card -->
                <div class="stats shadow bg-white">
                    <div class="stat">
                        <div class="stat-figure {{ $project->budget_remaining >= 0 ? 'text-success' : 'text-error' }}">
                            @if($project->budget_remaining >= 0)
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            @else
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            @endif
                        </div>
                        <div class="stat-title">Remaining</div>
                        <div class="stat-value {{ $project->budget_remaining >= 0 ? 'text-success' : 'text-error' }}">
                            {{ number_format($project->budget_remaining, 0) }}
                        </div>
                        <div class="stat-desc">{{ $project->budget_remaining >= 0 ? 'Under budget' : 'Over budget' }}</div>
                    </div>
                </div>

                <!-- Progress Card -->
                <div class="stats shadow bg-white">
                    <div class="stat">
                        <div class="stat-figure">
                            <div class="radial-progress text-primary {{ $project->budget_usage_percentage > 90 ? 'text-error' : '' }}" style="--value:{{ min($project->budget_usage_percentage, 100) }}; --size:3rem;">
                                {{ number_format($project->budget_usage_percentage, 0) }}%
                            </div>
                        </div>
                        <div class="stat-title">Budget Usage</div>
                        <div class="stat-desc text-xs">Project completion</div>
                        <progress class="progress progress-primary w-full mt-2" value="{{ min($project->budget_usage_percentage, 100) }}" max="100"></progress>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card bg-white shadow-xl">
                <div class="card-body">
                    <h3 class="card-title text-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Quick Actions
                    </h3>
                    <div class="grid grid-cols-2 md:grid-cols-5 gap-3 mt-6">
                        <!-- Mark Attendance -->
                        <a href="{{ route('projects.attendances.create', [$project, 'date' => now()->format('Y-m-d')]) }}" class="group flex items-center gap-3 rounded-lg bg-gradient-to-r from-emerald-600 to-emerald-500 px-4 py-3 text-white shadow-lg shadow-emerald-200 transition-all duration-300 hover:shadow-xl hover:shadow-emerald-300 hover:-translate-y-0.5">
                            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-white/20 backdrop-blur-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <div class="text-sm font-semibold">Mark Attendance</div>
                                <div class="text-xs text-emerald-100">Daily tracking</div>
                            </div>
                        </a>

                        <!-- Record Payment -->
                        <a href="{{ route('projects.payments.create', $project) }}" class="group flex items-center gap-3 rounded-lg bg-gradient-to-r from-blue-600 to-blue-500 px-4 py-3 text-white shadow-lg shadow-blue-200 transition-all duration-300 hover:shadow-xl hover:shadow-blue-300 hover:-translate-y-0.5">
                            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-white/20 backdrop-blur-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <div class="text-sm font-semibold">Record Payment</div>
                                <div class="text-xs text-blue-100">Pay workers</div>
                            </div>
                        </a>

                        <!-- Add Material -->
                        <a href="{{ route('projects.materials.create', $project) }}" class="group flex items-center gap-3 rounded-lg bg-gradient-to-r from-purple-600 to-purple-500 px-4 py-3 text-white shadow-lg shadow-purple-200 transition-all duration-300 hover:shadow-xl hover:shadow-purple-300 hover:-translate-y-0.5">
                            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-white/20 backdrop-blur-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <div class="text-sm font-semibold">Add Material</div>
                                <div class="text-xs text-purple-100">Track supplies</div>
                            </div>
                        </a>

                        <!-- Add Contractor -->
                        <a href="{{ route('projects.labor-costs.create', $project) }}" class="group flex items-center gap-3 rounded-lg bg-gradient-to-r from-orange-600 to-orange-500 px-4 py-3 text-white shadow-lg shadow-orange-200 transition-all duration-300 hover:shadow-xl hover:shadow-orange-300 hover:-translate-y-0.5">
                            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-white/20 backdrop-blur-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <div class="text-sm font-semibold">Add Contractor</div>
                                <div class="text-xs text-orange-100">Hire teams</div>
                            </div>
                        </a>

                        <!-- Add Worker -->
                        <a href="{{ route('projects.workers.create', $project) }}" class="group flex items-center gap-3 rounded-lg bg-gradient-to-r from-pink-600 to-pink-500 px-4 py-3 text-white shadow-lg shadow-pink-200 transition-all duration-300 hover:shadow-xl hover:shadow-pink-300 hover:-translate-y-0.5">
                            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-white/20 backdrop-blur-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <div class="text-sm font-semibold">Add Worker</div>
                                <div class="text-xs text-pink-100">New employee</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Cost Breakdown & Project Info -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Cost Breakdown -->
                <div class="lg:col-span-2 card bg-white shadow-xl">
                    <div class="card-body">
                        <h3 class="card-title text-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                            </svg>
                            Cost Breakdown
                        </h3>
                        <div class="space-y-3 mt-4">
                            <!-- Materials -->
                            <div class="flex items-center justify-between p-3 bg-base-200 rounded-lg">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="font-semibold">Materials</div>
                                        <div class="text-sm text-gray-500">{{ $project->materials->count() }} items</div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-lg font-bold text-primary">{{ number_format($project->total_material_cost, 2) }}</div>
                                    <div class="text-xs text-gray-500">{{ number_format(($project->total_material_cost / max($project->total_project_cost, 1)) * 100, 1) }}% of total</div>
                                </div>
                            </div>

                            <!-- Contractors -->
                            <div class="flex items-center justify-between p-3 bg-base-200 rounded-lg">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-success/10 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="font-semibold">Contractors</div>
                                        <div class="text-sm text-gray-500">{{ $project->contractorCosts->count() }} contractors</div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-lg font-bold text-success">{{ number_format($project->total_labor_cost, 2) }}</div>
                                    <div class="text-xs text-gray-500">{{ number_format(($project->total_labor_cost / max($project->total_project_cost, 1)) * 100, 1) }}% of total</div>
                                </div>
                            </div>

                            <!-- Structure -->
                            <div class="flex items-center justify-between p-3 bg-base-200 rounded-lg">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-warning/10 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-warning" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="font-semibold">Structure</div>
                                        <div class="text-sm text-gray-500">{{ $project->structureCosts->count() }} items</div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-lg font-bold text-warning">{{ number_format($project->total_structure_cost, 2) }}</div>
                                    <div class="text-xs text-gray-500">{{ number_format(($project->total_structure_cost / max($project->total_project_cost, 1)) * 100, 1) }}% of total</div>
                                </div>
                            </div>

                            <!-- Finishing -->
                            <div class="flex items-center justify-between p-3 bg-base-200 rounded-lg">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-secondary/10 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="font-semibold">Finishing</div>
                                        <div class="text-sm text-gray-500">{{ $project->finishingWorks->count() }} items</div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-lg font-bold text-secondary">{{ number_format($project->total_finishing_cost, 2) }}</div>
                                    <div class="text-xs text-gray-500">{{ number_format(($project->total_finishing_cost / max($project->total_project_cost, 1)) * 100, 1) }}% of total</div>
                                </div>
                            </div>

                            <div class="divider my-2"></div>

                            <!-- Total -->
                            <div class="flex items-center justify-between">
                                <span class="text-lg font-bold">Total Cost</span>
                                <span class="text-2xl font-bold text-primary">{{ number_format($project->total_project_cost, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Project Details -->
                <div class="card bg-white shadow-xl">
                    <div class="card-body">
                        <h3 class="card-title text-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Project Details
                        </h3>
                        <div class="space-y-4 mt-4">
                            @if($project->start_date || $project->end_date)
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-gray-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <div>
                                    <div class="text-sm text-gray-500">Timeline</div>
                                    <div class="font-medium">{{ $project->start_date?->format('M d, Y') ?? 'Not set' }} - {{ $project->end_date?->format('M d, Y') ?? 'Not set' }}</div>
                                </div>
                            </div>
                            @endif

                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-gray-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <div>
                                    <div class="text-sm text-gray-500">Workers</div>
                                    <div class="font-medium">{{ $project->total_workers }} active workers</div>
                                </div>
                            </div>

                            @if($project->notes)
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-gray-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <div class="flex-1">
                                    <div class="text-sm text-gray-500">Notes</div>
                                    <div class="text-sm mt-1 p-2 bg-base-200 rounded">{{ $project->notes }}</div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sections Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Materials -->
                <div class="card bg-white shadow-xl hover:shadow-2xl transition-shadow">
                    <div class="card-body">
                        <div class="flex items-center justify-between">
                            <h3 class="card-title">
                                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                Materials
                            </h3>
                            <div class="badge badge-primary">{{ number_format($project->total_material_cost, 2) }}</div>
                        </div>
                        <p class="text-sm text-gray-500 mt-2">{{ $project->materials->count() }} items recorded</p>
                        @if($project->materials->count() > 0)
                            <div class="mt-4 space-y-2">
                                @foreach($project->materials->take(3) as $material)
                                    <div class="flex justify-between items-center text-sm">
                                        <span class="truncate">{{ $material->name }}</span>
                                        <span class="font-medium">{{ number_format($material->total_cost, 2) }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        <div class="card-actions mt-4">
                            <a href="{{ route('projects.materials.index', $project) }}" class="btn btn-primary btn-sm flex-1">
                                {{ $project->materials->count() > 0 ? 'Manage Materials' : 'Add Materials' }}
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Contractors -->
                <div class="card bg-white shadow-xl hover:shadow-2xl transition-shadow">
                    <div class="card-body">
                        <div class="flex items-center justify-between">
                            <h3 class="card-title">
                                <svg class="w-5 h-5 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                Contractors
                            </h3>
                            <div class="badge badge-success">{{ number_format($project->total_labor_cost, 2) }}</div>
                        </div>
                        <p class="text-sm text-gray-500 mt-2">{{ $project->contractorCosts->count() }} contractors</p>
                        @if($project->contractorCosts->count() > 0)
                            <div class="mt-4 space-y-2">
                                @php
                                    $totalDue = $project->contractorCosts->sum(function($c) { return $c->total_due - $c->total_payments_received; });
                                @endphp
                                <div class="flex justify-between items-center text-sm">
                                    <span>Total Due:</span>
                                    <span class="font-medium text-error">{{ number_format($totalDue, 2) }}</span>
                                </div>
                                <div class="flex justify-between items-center text-sm">
                                    <span>Paid:</span>
                                    <span class="font-medium text-success">{{ number_format($project->total_contractor_payments, 2) }}</span>
                                </div>
                            </div>
                        @endif
                        <div class="card-actions mt-4">
                            <a href="{{ route('projects.labor-costs.index', $project) }}" class="btn btn-success btn-sm flex-1">
                                {{ $project->contractorCosts->count() > 0 ? 'Manage Contractors' : 'Add Contractors' }}
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Workers -->
                <div class="card bg-white shadow-xl hover:shadow-2xl transition-shadow">
                    <div class="card-body">
                        <div class="flex items-center justify-between">
                            <h3 class="card-title">
                                <svg class="w-5 h-5 text-info" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                Workers
                            </h3>
                            <div class="badge badge-info">{{ $project->total_workers }}</div>
                        </div>
                        <p class="text-sm text-gray-500 mt-2">{{ $project->total_present_today }} present today</p>
                        @if($project->workers->count() > 0)
                            <div class="mt-4 space-y-2">
                                @foreach($project->workers->take(2) as $worker)
                                    <div class="flex items-center gap-2 text-sm">
                                        <div class="avatar placeholder">
                                            <div class="bg-neutral text-neutral-content rounded-full w-8">
                                                <span class="text-xs">{{ substr($worker->name, 0, 1) }}</span>
                                            </div>
                                        </div>
                                        <span class="truncate flex-1">{{ $worker->name }}</span>
                                        @if($worker->is_active)
                                            <div class="badge badge-success badge-xs">Active</div>
                                        @else
                                            <div class="badge badge-error badge-xs">Inactive</div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        <div class="card-actions mt-4">
                            <a href="{{ route('projects.workers.index', $project) }}" class="btn btn-info btn-sm flex-1">
                                {{ $project->workers->count() > 0 ? 'Manage Workers' : 'Add Workers' }}
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Structure -->
                <div class="card bg-white shadow-xl hover:shadow-2xl transition-shadow">
                    <div class="card-body">
                        <div class="flex items-center justify-between">
                            <h3 class="card-title">
                                <svg class="w-5 h-5 text-warning" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                Structure
                            </h3>
                            <div class="badge badge-warning">{{ number_format($project->total_structure_cost, 2) }}</div>
                        </div>
                        <p class="text-sm text-gray-500 mt-2">{{ $project->structureCosts->count() }} items</p>
                        <div class="card-actions mt-4">
                            <a href="{{ route('projects.structure-costs.index', $project) }}" class="btn btn-warning btn-sm flex-1">
                                {{ $project->structureCosts->count() > 0 ? 'Manage Structure' : 'Add Structure' }}
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Finishing -->
                <div class="card bg-white shadow-xl hover:shadow-2xl transition-shadow">
                    <div class="card-body">
                        <div class="flex items-center justify-between">
                            <h3 class="card-title">
                                <svg class="w-5 h-5 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                                </svg>
                                Finishing
                            </h3>
                            <div class="badge badge-secondary">{{ number_format($project->total_finishing_cost, 2) }}</div>
                        </div>
                        <p class="text-sm text-gray-500 mt-2">{{ $project->finishingWorks->count() }} items</p>
                        <div class="card-actions mt-4">
                            <a href="{{ route('projects.finishing-works.index', $project) }}" class="btn btn-secondary btn-sm flex-1">
                                {{ $project->finishingWorks->count() > 0 ? 'Manage Finishing' : 'Add Finishing' }}
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Payments -->
                <div class="card bg-white shadow-xl hover:shadow-2xl transition-shadow">
                    <div class="card-body">
                        <div class="flex items-center justify-between">
                            <h3 class="card-title">
                                <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Payments
                            </h3>
                            <div class="badge badge-accent">{{ number_format($project->total_payments_made, 2) }}</div>
                        </div>
                        <p class="text-sm text-gray-500 mt-2">{{ $project->payments->count() }} payments made</p>
                        <div class="mt-4 space-y-2">
                            <div class="flex justify-between text-sm">
                                <span>To Contractors:</span>
                                <span class="font-medium">{{ number_format($project->total_contractor_payments, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span>To Workers:</span>
                                <span class="font-medium">{{ number_format($project->total_worker_payments, 2) }}</span>
                            </div>
                        </div>
                        <div class="card-actions mt-4">
                            <a href="{{ route('projects.payments.index', $project) }}" class="btn btn-accent btn-sm flex-1">
                                {{ $project->payments->count() > 0 ? 'View Payments' : 'Record Payment' }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
