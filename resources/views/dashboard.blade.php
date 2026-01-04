<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Dashboard</h2>
                <p class="text-gray-500 mt-1">Welcome back! Here's your project overview.</p>
            </div>
            <a href="{{ route('projects.create') }}" class="btn btn-primary btn-sm gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                New Project
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Total Projects Card -->
                <div class="card bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-200 shadow-lg hover:shadow-xl transition-shadow">
                    <div class="card-body p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Total Projects</p>
                                <p class="text-3xl font-bold text-blue-600">{{ $stats['total_projects'] }}</p>
                                <p class="text-xs text-gray-400">All projects</p>
                            </div>
                            <div class="h-14 w-14 rounded-xl bg-blue-500 flex items-center justify-center shadow-lg">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Active Projects Card -->
                <div class="card bg-gradient-to-br from-green-50 to-emerald-50 border border-green-200 shadow-lg hover:shadow-xl transition-shadow">
                    <div class="card-body p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Active Projects</p>
                                <p class="text-3xl font-bold text-green-600">{{ $stats['active_projects'] }}</p>
                                <p class="text-xs text-gray-400">Currently in progress</p>
                            </div>
                            <div class="h-14 w-14 rounded-xl bg-green-500 flex items-center justify-center shadow-lg">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Completed Projects Card -->
                <div class="card bg-gradient-to-br from-purple-50 to-violet-50 border border-purple-200 shadow-lg hover:shadow-xl transition-shadow">
                    <div class="card-body p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Completed Projects</p>
                                <p class="text-3xl font-bold text-purple-600">{{ $stats['completed_projects'] }}</p>
                                <p class="text-xs text-gray-400">Successfully finished</p>
                            </div>
                            <div class="h-14 w-14 rounded-xl bg-purple-500 flex items-center justify-center shadow-lg">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Budget Card -->
                <div class="card bg-gradient-to-br from-amber-50 to-yellow-50 border border-amber-200 shadow-lg hover:shadow-xl transition-shadow">
                    <div class="card-body p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Total Budget</p>
                                <p class="text-2xl font-bold text-amber-600">{{ number_format($stats['total_budget'], 2) }}</p>
                                <p class="text-xs text-gray-400">Across all projects</p>
                            </div>
                            <div class="h-14 w-14 rounded-xl bg-amber-500 flex items-center justify-center shadow-lg">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Budget Alerts -->
            @if($budgetAlerts->count() > 0)
                <div class="alert alert-warning shadow-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    <div>
                        <h3 class="font-bold">Budget Alert!</h3>
                        <div class="text-sm">{{ $budgetAlerts->count() }} project{{ $budgetAlerts->count() != 1 ? 's have' : ' has' }} exceeded 90% of their budget.</div>
                    </div>
                </div>
            @endif

            <!-- Recent Projects Table -->
            <div class="card bg-white shadow-xl">
                <div class="card-body">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-3">
                            <div class="h-10 w-10 rounded-lg bg-gradient-to-br from-blue-500 to-indigo-500 flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Recent Projects</h3>
                                <p class="text-sm text-gray-500">{{ $recentProjects->count() }} project{{ $recentProjects->count() != 1 ? 's' : '' }}</p>
                            </div>
                        </div>
                    </div>

                    @if($recentProjects->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Location</th>
                                        <th>Status</th>
                                        <th class="text-right">Budget</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentProjects as $project)
                                        <tr class="hover">
                                            <td>
                                                <div class="font-bold text-gray-900">{{ $project->name }}</div>
                                                <div class="text-xs text-gray-500">{{ $project->client_name ?? '-' }}</div>
                                            </td>
                                            <td>
                                                <div class="flex items-center gap-2">
                                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    </svg>
                                                    <span class="text-gray-700">{{ $project->location ?? '-' }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                @if($project->status == 'completed')
                                                    <div class="badge badge-success badge-lg">{{ ucfirst(str_replace('_', ' ', $project->status)) }}</div>
                                                @elseif($project->status == 'in_progress')
                                                    <div class="badge badge-info badge-lg">{{ ucfirst(str_replace('_', ' ', $project->status)) }}</div>
                                                @elseif($project->status == 'planning')
                                                    <div class="badge badge-warning badge-lg">{{ ucfirst(str_replace('_', ' ', $project->status)) }}</div>
                                                @else
                                                    <div class="badge badge-neutral badge-lg">{{ ucfirst(str_replace('_', ' ', $project->status)) }}</div>
                                                @endif
                                            </td>
                                            <td class="text-right">
                                                <div class="text-lg font-bold text-gray-900">{{ number_format($project->estimated_budget, 2) }}</div>
                                            </td>
                                            <td>
                                                <div class="flex gap-1 justify-center">
                                                    <a href="{{ route('projects.show', $project) }}" class="btn btn-ghost btn-xs btn-circle text-primary" title="View Project">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                        </svg>
                                                    </a>
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
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">No projects yet!</h3>
                            <p class="text-gray-500 mb-6">Start tracking your construction projects</p>
                            <a href="{{ route('projects.create') }}" class="btn btn-primary gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Create Your First Project
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
