<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Cards with FlyonUI -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <!-- Total Projects Card -->
                <div class="card bg-base-100 shadow-xl hover:shadow-2xl transition-shadow">
                    <div class="card-body">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-sm text-gray-500 font-medium">Total Projects</h3>
                                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['total_projects'] }}</p>
                            </div>
                            <div class="avatar placeholder">
                                <div class="bg-blue-100 text-blue-600 rounded-full w-14 flex items-center justify-center">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Active Projects Card -->
                <div class="card bg-base-100 shadow-xl hover:shadow-2xl transition-shadow">
                    <div class="card-body">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-sm text-gray-500 font-medium">Active Projects</h3>
                                <p class="text-3xl font-bold text-green-600 mt-2">{{ $stats['active_projects'] }}</p>
                            </div>
                            <div class="avatar placeholder">
                                <div class="bg-green-100 text-green-600 rounded-full w-14">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Completed Projects Card -->
                <div class="card bg-base-100 shadow-xl hover:shadow-2xl transition-shadow">
                    <div class="card-body">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-sm text-gray-500 font-medium">Completed Projects</h3>
                                <p class="text-3xl font-bold text-purple-600 mt-2">{{ $stats['completed_projects'] }}</p>
                            </div>
                            <div class="avatar placeholder">
                                <div class="bg-purple-100 text-purple-600 rounded-full w-14">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Budget Card -->
                <div class="card bg-base-100 shadow-xl hover:shadow-2xl transition-shadow">
                    <div class="card-body">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-sm text-gray-500 font-medium">Total Budget</h3>
                                <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($stats['total_budget'], 2) }}</p>
                            </div>
                            <div class="avatar placeholder">
                                <div class="bg-yellow-100 text-yellow-600 rounded-full w-14">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Budget Alerts -->
            @if($budgetAlerts->count() > 0)
                <div class="alert alert-warning mb-8">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    <div>
                        <h3 class="font-bold">Budget Alert!</h3>
                        <div class="text-xs">{{ $budgetAlerts->count() }} project(s) have exceeded 90% of their budget.</div>
                    </div>
                </div>
            @endif

            <!-- Recent Projects Table -->
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h3 class="card-title">Recent Projects</h3>
                    <div class="overflow-x-auto mt-4">
                        @if($recentProjects->count() > 0)
                            <table class="table table-zebra">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Location</th>
                                        <th>Status</th>
                                        <th>Budget</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentProjects as $project)
                                        <tr>
                                            <td>
                                                <div class="font-bold">{{ $project->name }}</div>
                                            </td>
                                            <td>{{ $project->location ?? '-' }}</td>
                                            <td>
                                                @if($project->status == 'completed')
                                                    <div class="badge badge-success">{{ ucfirst(str_replace('_', ' ', $project->status)) }}</div>
                                                @elseif($project->status == 'in_progress')
                                                    <div class="badge badge-info">{{ ucfirst(str_replace('_', ' ', $project->status)) }}</div>
                                                @elseif($project->status == 'planning')
                                                    <div class="badge badge-warning">{{ ucfirst(str_replace('_', ' ', $project->status)) }}</div>
                                                @else
                                                    <div class="badge badge-neutral">{{ ucfirst(str_replace('_', ' ', $project->status)) }}</div>
                                                @endif
                                            </td>
                                            <td>{{ number_format($project->estimated_budget, 2) }}</td>
                                            <td>
                                                <a href="{{ route('projects.show', $project) }}" class="btn btn-sm btn-primary">View</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="text-center py-8">
                                <p class="text-gray-500 mb-4">No projects yet.</p>
                                <a href="{{ route('projects.create') }}" class="btn btn-primary">Create your first project</a>
                            </div>
                        @endif
                    </div>

                    <!-- Create Project Button -->
                    <div class="card-actions justify-end mt-4">
                        <a href="{{ route('projects.create') }}" class="btn btn-primary gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            New Project
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
