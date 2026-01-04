<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <div class="flex items-center gap-3">
                    <h2 class="text-2xl font-bold text-gray-900">Workers</h2>
                    <div class="badge badge-primary">{{ $project->name }}</div>
                </div>
                <p class="text-gray-500 mt-1">Manage workers and track attendance</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('projects.attendances.calendar', $project) }}" class="btn btn-ghost btn-sm gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Attendance Calendar
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
            <!-- Summary Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Total Workers -->
                <div class="card bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-200 shadow-lg hover:shadow-xl transition-shadow">
                    <div class="card-body p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Total Workers</p>
                                <p class="text-3xl font-bold text-blue-600">{{ $workers->count() }}</p>
                                <p class="text-xs text-gray-400">All workers</p>
                            </div>
                            <div class="h-14 w-14 rounded-xl bg-blue-500 flex items-center justify-center shadow-lg">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Active Workers -->
                <div class="card bg-gradient-to-br from-green-50 to-emerald-50 border border-green-200 shadow-lg hover:shadow-xl transition-shadow">
                    <div class="card-body p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Active Workers</p>
                                <p class="text-3xl font-bold text-green-600">{{ $workers->where('is_active', true)->count() }}</p>
                                <p class="text-xs text-gray-400">Currently working</p>
                            </div>
                            <div class="h-14 w-14 rounded-xl bg-green-500 flex items-center justify-center shadow-lg">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Present Today -->
                <div class="card bg-gradient-to-br from-purple-50 to-violet-50 border border-purple-200 shadow-lg hover:shadow-xl transition-shadow">
                    <div class="card-body p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Present Today</p>
                                <p class="text-3xl font-bold text-purple-600">{{ $workers->where('is_present_today', true)->count() }}</p>
                                <p class="text-xs text-gray-400">{{ today()->format('M d') }}</p>
                            </div>
                            <div class="h-14 w-14 rounded-xl bg-purple-500 flex items-center justify-center shadow-lg">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Wages Paid -->
                <div class="card bg-gradient-to-br from-amber-50 to-orange-50 border border-amber-200 shadow-lg hover:shadow-xl transition-shadow">
                    <div class="card-body p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Total Wages Paid</p>
                                <p class="text-2xl font-bold text-amber-600">{{ number_format($workers->sum('total_wages_earned'), 0) }}</p>
                                <p class="text-xs text-gray-400">All time earnings</p>
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

            <!-- Today's Attendance Bill -->
            <div class="card bg-white shadow-xl">
                <div class="card-body">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="h-10 w-10 rounded-lg bg-gradient-to-br from-rose-500 to-pink-500 flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Today's Attendance Bill</h3>
                                <p class="text-sm text-gray-500">{{ today()->format('l, F d, Y') }}</p>
                            </div>
                        </div>
                        <a href="{{ route('projects.attendances.create', ['project' => $project, 'date' => today()->format('Y-m-d')]) }}" class="btn btn-success btn-sm gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Mark Attendance
                        </a>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="card bg-gradient-to-br from-green-50 to-emerald-50 border border-green-200">
                            <div class="card-body p-4">
                                <div class="text-sm text-gray-600">Workers Present</div>
                                <div class="text-2xl font-bold text-green-600">{{ $todayStats['total_workers_present'] }}</div>
                            </div>
                        </div>
                        <div class="card bg-gradient-to-br from-red-50 to-rose-50 border border-red-200">
                            <div class="card-body p-4">
                                <div class="text-sm text-gray-600">Workers Absent</div>
                                <div class="text-2xl font-bold text-red-600">{{ $todayStats['total_workers_absent'] }}</div>
                            </div>
                        </div>
                        <div class="card bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-200">
                            <div class="card-body p-4">
                                <div class="text-sm text-gray-600">Total Hours</div>
                                <div class="text-2xl font-bold text-blue-600">{{ number_format($todayStats['total_hours'], 1) }}</div>
                            </div>
                        </div>
                        <div class="card bg-gradient-to-br from-purple-50 to-violet-50 border border-purple-200">
                            <div class="card-body p-4">
                                <div class="text-sm text-gray-600">Today's Bill</div>
                                <div class="text-2xl font-bold text-purple-600">{{ number_format($todayStats['total_bill'], 2) }}</div>
                                <div class="text-xs text-gray-500">Total wage amount</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Workers Table -->
            <div class="card bg-white shadow-xl">
                <div class="card-body">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-3">
                            <div class="h-10 w-10 rounded-lg bg-gradient-to-br from-cyan-500 to-blue-500 flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">All Workers</h3>
                                <p class="text-sm text-gray-500">{{ $workers->count() }} worker{{ $workers->count() != 1 ? 's' : '' }}</p>
                            </div>
                        </div>
                        <a href="{{ route('projects.workers.create', $project) }}" class="btn btn-primary btn-sm gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Add Worker
                        </a>
                    </div>

                    @if($workers->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Worker</th>
                                        <th>Type</th>
                                        <th>Category</th>
                                        <th>Contractor</th>
                                        <th class="text-right">Daily Wage</th>
                                        <th class="text-center">Days</th>
                                        <th class="text-right">Total Earned</th>
                                        <th>Status</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($workers as $worker)
                                        <tr class="hover">
                                            <td>
                                                <div class="flex items-center gap-3">
                                                    <div class="avatar placeholder">
                                                        <div class="bg-neutral text-neutral-content rounded-lg w-10">
                                                            <span class="text-sm">{{ substr($worker->name, 0, 1) }}</span>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="font-bold text-gray-900">{{ $worker->name }}</div>
                                                        @if($worker->phone)
                                                            <div class="text-xs text-gray-500">{{ $worker->phone }}</div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="badge badge-primary">{{ $laborTypes[$worker->labor_type] ?? ucfirst($worker->labor_type) }}</div>
                                            </td>
                                            <td>
                                                @if($worker->category)
                                                    <div class="text-sm text-gray-900">{{ ucfirst($worker->category) }}</div>
                                                @else
                                                    <div class="text-sm text-gray-400">-</div>
                                                @endif
                                            </td>
                                            <td>
                                                @if($worker->primaryContractor)
                                                    <div class="badge badge-info">{{ \Illuminate\Support\Str::limit($worker->primaryContractor->name, 15) }}</div>
                                                @elseif($worker->contractors->count() > 0)
                                                    <div class="badge badge-ghost">{{ $worker->contractors->count() }} assigned</div>
                                                @else
                                                    <div class="text-sm text-gray-400">-</div>
                                                @endif
                                            </td>
                                            <td class="text-right">
                                                <div class="text-lg font-bold text-purple-600">{{ number_format($worker->daily_wage, 2) }}</div>
                                            </td>
                                            <td class="text-center">
                                                <div class="text-lg font-bold text-gray-900">{{ $worker->total_days_worked }}</div>
                                            </td>
                                            <td class="text-right">
                                                <div class="text-lg font-bold text-green-600">{{ number_format($worker->total_wages_earned, 2) }}</div>
                                            </td>
                                            <td>
                                                @if($worker->is_active)
                                                    <div class="badge badge-success badge-lg">Active</div>
                                                @else
                                                    <div class="badge badge-error badge-lg">Inactive</div>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="flex gap-1 justify-center">
                                                    <a href="{{ route('projects.workers.show', [$project, $worker]) }}" class="btn btn-ghost btn-xs btn-circle text-info" title="View">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                        </svg>
                                                    </a>
                                                    <a href="{{ route('projects.workers.edit', [$project, $worker]) }}" class="btn btn-ghost btn-xs btn-circle text-warning" title="Edit">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                        </svg>
                                                    </a>
                                                    <form action="{{ route('projects.workers.destroy', [$project, $worker]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this worker?')">
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
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">No workers yet!</h3>
                            <p class="text-gray-500 mb-6">Start tracking your workers and their daily attendance</p>
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
        </div>
    </div>
</x-app-layout>
