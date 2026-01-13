<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <div class="flex items-center gap-3">
                    <h2 class="text-2xl font-bold text-gray-900">{{ $contractor->name ?? 'Contractor' }}</h2>
                    <div class="badge badge-primary">{{ $project->name }}</div>
                </div>
                <p class="text-gray-500 mt-1">Workers assigned to {{ $contractor->name ?? 'this contractor' }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('projects.contractors.index', $project) }}" class="btn btn-ghost btn-sm gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Contractors
                </a>
                <a href="{{ route('projects.attendances.create', ['project' => $project, 'date' => today()->format('Y-m-d')]) }}" class="btn btn-success btn-sm gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                    </svg>
                    Mark Attendance
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Contractor Info Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Contractor Details -->
                <div class="card bg-white shadow-lg hover:shadow-xl transition-shadow">
                    <div class="card-body p-5">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-500 flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900">{{ $contractor->name ?? 'Unnamed' }}</h3>
                                <div class="badge badge-ghost badge-sm">{{ ucfirst($contractor->category) }}</div>
                            </div>
                        </div>
                        <div class="divider my-2"></div>
                        <div class="text-sm text-gray-600">
                            <div class="flex justify-between">
                                <span>Contractor ID:</span>
                                <span class="font-medium">#{{ $contractor->id }}</span>
                            </div>
                            @if($contractor->description)
                                <div class="mt-2 text-gray-500">{{ Str::limit($contractor->description, 60) }}</div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Wage Calculation Type -->
                <div class="card bg-white shadow-lg hover:shadow-xl transition-shadow">
                    <div class="card-body p-5">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900">Wage Calculation</h3>
                            </div>
                        </div>
                        <div class="divider my-2"></div>
                        @if($contractor->use_uniform_wage)
                            <div class="text-center">
                                <div class="badge badge-success badge-lg mb-2">Uniform Daily Wage</div>
                                <p class="text-sm text-gray-600">Worker's daily wage × days worked</p>
                            </div>
                        @else
                            <div class="text-center">
                                <div class="badge badge-info badge-lg mb-2">Individual Wage</div>
                                <p class="text-sm text-gray-600">Based on attendance-specific wages</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Total Bill -->
                <div class="card bg-white shadow-lg hover:shadow-xl transition-shadow">
                    <div class="card-body p-5">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-green-500 to-emerald-500 flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900">Total Bill</h3>
                            </div>
                        </div>
                        <div class="divider my-2"></div>
                        <div class="text-center">
                            @php
                                $totalBill = $contractor->actual_total_cost ?? 0;
                            @endphp
                            <div class="text-3xl font-bold text-green-600">{{ number_format($totalBill, 2) }}</div>
                            <p class="text-sm text-gray-500">From workers' attendance</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Summary Stats -->
            <div class="card bg-white shadow-xl">
                <div class="card-body">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="h-10 w-10 rounded-lg bg-gradient-to-br from-blue-500 to-indigo-500 flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="card-title mb-0">Payment Summary</h3>
                            <p class="text-sm text-gray-500">Overview of wages and payments</p>
                        </div>
                    </div>

                    <div class="@if($contractor->use_uniform_wage) grid grid-cols-1 md:grid-cols-3 gap-4 @else grid grid-cols-2 lg:grid-cols-5 gap-4 @endif">
                        <!-- Total Wages -->
                        <div class="bg-blue-50 rounded-lg p-4">
                            <div class="flex items-center gap-2 mb-2">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-sm font-semibold text-blue-900">Total Wages</span>
                            </div>
                            <div class="text-2xl font-bold text-blue-600">{{ number_format($workers->sum('total_wages_earned'), 2) }}</div>
                            @if($contractor->use_uniform_wage)
                                <div class="text-xs text-gray-500 mt-1">Worker daily wage × days worked</div>
                            @endif
                        </div>

                        @if(!$contractor->use_uniform_wage)
                            <!-- Paid to Workers -->
                            <div class="bg-green-50 rounded-lg p-4">
                                <div class="flex items-center gap-2 mb-2">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="text-sm font-semibold text-green-900">Paid to Workers</span>
                                </div>
                                <div class="text-2xl font-bold text-green-600">{{ number_format($workers->sum('total_payments_received'), 2) }}</div>
                            </div>

                            <!-- Due to Workers -->
                            <div class="bg-orange-50 rounded-lg p-4">
                                <div class="flex items-center gap-2 mb-2">
                                    <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="text-sm font-semibold text-orange-900">Due to Workers</span>
                                </div>
                                <div class="text-2xl font-bold text-orange-600">{{ number_format($workers->sum(function($w) { return $w->amount_due; }), 2) }}</div>
                            </div>
                        @endif

                        <!-- Paid to Contractor -->
                        <div class="bg-purple-50 rounded-lg p-4">
                            <div class="flex items-center gap-2 mb-2">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <span class="text-sm font-semibold text-purple-900">Paid to Contractor</span>
                            </div>
                            <div class="text-2xl font-bold text-purple-600">{{ number_format($contractor->total_payments_received, 2) }}</div>
                        </div>

                        <!-- Due to Contractor -->
                        <div class="bg-red-50 rounded-lg p-4">
                            <div class="flex items-center gap-2 mb-2">
                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-sm font-semibold text-red-900">Due to Contractor</span>
                            </div>
                            @php
                                $dueToContractor = max(0, $contractor->actual_total_cost - $contractor->total_payments_received);
                            @endphp
                            <div class="text-2xl font-bold @if($dueToContractor > 0) text-red-600 @else text-green-600 @endif">{{ number_format($dueToContractor, 2) }}</div>
                            @if($dueToContractor == 0 && $contractor->actual_total_cost > 0)
                                <div class="text-xs text-green-600 mt-1 font-semibold">Fully Paid</div>
                            @elseif($dueToContractor > 0)
                                <div class="text-xs text-gray-500 mt-1">{{ number_format($contractor->actual_total_cost, 2) }} total bill</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Today's Attendance -->
            <div class="card bg-white shadow-xl">
                <div class="card-body">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-3">
                            <div class="h-10 w-10 rounded-lg bg-gradient-to-br from-emerald-500 to-teal-500 flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="card-title mb-0">Today's Attendance</h3>
                                <p class="text-sm text-gray-500">{{ today()->format('F j, Y') }}</p>
                            </div>
                        </div>
                        <a href="{{ route('projects.attendances.create', ['project' => $project, 'date' => today()->format('Y-m-d')]) }}" class="btn btn-success btn-sm gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Mark Attendance
                        </a>
                    </div>

                    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
                        <!-- Active Workers -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="text-sm text-gray-600 mb-1">Active Workers</div>
                            <div class="text-2xl font-bold text-gray-900">{{ $todayStats['active_workers'] }}</div>
                            <div class="text-xs text-gray-500">of {{ $todayStats['total_workers'] }} total</div>
                        </div>

                        <!-- Present -->
                        <div class="bg-emerald-50 rounded-lg p-4">
                            <div class="text-sm text-emerald-700 mb-1">Present Today</div>
                            <div class="text-2xl font-bold text-emerald-600">{{ $todayStats['total_present_today'] }}</div>
                        </div>

                        <!-- Absent -->
                        <div class="bg-red-50 rounded-lg p-4">
                            <div class="text-sm text-red-700 mb-1">Absent Today</div>
                            <div class="text-2xl font-bold text-red-600">{{ $todayStats['total_absent_today'] }}</div>
                        </div>

                        <!-- Total Hours -->
                        <div class="bg-blue-50 rounded-lg p-4">
                            <div class="text-sm text-blue-700 mb-1">Total Hours</div>
                            <div class="text-2xl font-bold text-blue-600">{{ number_format($todayStats['total_hours_today'], 1) }}</div>
                        </div>

                        <!-- Today's Bill -->
                        <div class="bg-purple-50 rounded-lg p-4">
                            <div class="text-sm text-purple-700 mb-1">Today's Bill</div>
                            <div class="text-2xl font-bold text-purple-600">{{ number_format($todayStats['total_bill_today'], 2) }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Assign Worker Form -->
            @if($project->workers()->active()->whereNotIn('id', $workers->pluck('id'))->count() > 0)
            <div class="card bg-gradient-to-r from-blue-500 to-indigo-500 text-white shadow-xl">
                <div class="card-body">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="h-10 w-10 rounded-lg bg-white/20 backdrop-blur-sm flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-bold">Assign New Worker</h3>
                            <p class="text-sm text-blue-100">Add workers to this contractor</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('projects.contractors.workers.attach', [$project, $contractor]) }}">
                        @csrf
                        <div class="flex gap-3 items-end">
                            <div class="flex-1">
                                <select name="worker_id" class="select select-bordered w-full bg-white" required>
                                    <option value="">Select Worker...</option>
                                    @foreach($project->workers()->active()->whereNotIn('id', $workers->pluck('id'))->get() as $worker)
                                        <option value="{{ $worker->id }}">{{ $worker->name }} - {{ ucfirst($worker->category) }} ({{ $worker->daily_wage }}/day)</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <input type="date" name="assigned_date" value="{{ today()->toDateString() }}" class="input input-bordered bg-white" />
                            </div>
                            <button type="submit" class="btn btn-white btn-primary gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Assign
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @endif

            <!-- Workers List -->
            <div class="card bg-white shadow-xl">
                <div class="card-body">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-3">
                            <div class="h-10 w-10 rounded-lg bg-gradient-to-br from-violet-500 to-purple-500 flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Assigned Workers</h3>
                                <p class="text-sm text-gray-500">{{ $workers->count() }} worker{{ $workers->count() != 1 ? 's' : '' }}</p>
                            </div>
                        </div>
                    </div>

                    @if($contractor->use_uniform_wage)
                    <div class="alert alert-info mb-4 flex gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h4 class="font-bold text-sm">Uniform Wage Calculation Mode</h4>
                            <p class="text-xs">Payments processed at contractor level. Individual worker payment tracking is hidden.</p>
                        </div>
                    </div>
                    @endif

                    @if($workers->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Worker</th>
                                    <th>Category</th>
                                    <th class="text-right">Days Worked</th>
                                    <th class="text-right">Wages Earned</th>
                                    @if(!$contractor->use_uniform_wage)
                                        <th class="text-right">Paid</th>
                                        <th class="text-right">Due</th>
                                        <th class="text-center">Status</th>
                                    @endif
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
                                                        <span class="flex items-center justify-center h-full">{{ substr($worker->name, 0, 1) }}</span>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="font-bold text-gray-900">{{ $worker->name }}</div>
                                                    @if($worker->phone)
                                                        <div class="text-xs text-gray-500 flex items-center gap-1">
                                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13 2.257a1 1 0 01-1.21.502l-4.493-1.498a1 1 0 01-.684-.949V5a2 2 0 012-2h3.28c-.18.36-.338.68-.48 1a10.007 10.007 0 019.987 1.464c.342.142.68.29 1.008.48z"></path>
                                                            </svg>
                                                            {{ $worker->phone }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="badge badge-ghost badge-lg">{{ ucfirst($worker->category) }}</div>
                                            <div class="text-xs text-gray-500 mt-1">{{ ucfirst($worker->labor_type) }}</div>
                                        </td>
                                        <td class="text-right">
                                            <div class="text-lg font-bold text-gray-900">{{ $worker->total_days_worked }}</div>
                                            <div class="text-xs text-gray-500">{{ $worker->daily_wage }}/day</div>
                                        </td>
                                        <td class="text-right">
                                            <div class="text-lg font-bold text-gray-900">{{ number_format($worker->total_wages_earned, 2) }}</div>
                                        </td>
                                        @if(!$contractor->use_uniform_wage)
                                            <td class="text-right">
                                                <div class="text-lg font-bold text-green-600">{{ number_format($worker->total_payments_received, 2) }}</div>
                                            </td>
                                            <td class="text-right">
                                                <div class="text-lg font-bold {{ $worker->amount_due > 0 ? 'text-orange-600' : 'text-green-600' }}">
                                                    {{ number_format($worker->amount_due, 2) }}
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                @if($worker->payment_status == 'paid')
                                                    <div class="badge badge-success badge-lg gap-1">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                        </svg>
                                                        Paid
                                                    </div>
                                                @elseif($worker->payment_status == 'partial')
                                                    <div class="badge badge-warning badge-lg">Partial</div>
                                                @else
                                                    <div class="badge badge-error badge-lg">Pending</div>
                                                @endif
                                            </td>
                                        @endif
                                        <td>
                                            <div class="flex gap-1 justify-center">
                                                <a href="{{ route('projects.workers.show', [$project, $worker]) }}" class="btn btn-ghost btn-xs btn-circle" title="View Details">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    </svg>
                                                </a>
                                                <form action="{{ route('projects.contractors.workers.detach', [$project, $contractor, $worker]) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove {{ $worker->name }} from this contractor?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-ghost btn-xs btn-circle text-error" title="Remove Worker">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
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
                        <div class="inline-flex h-20 w-20 items-center justify-center rounded-full bg-gray-100 mb-4">
                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">No workers assigned yet</h3>
                        <p class="text-gray-500 mb-6">Assign workers to this contractor to start tracking their attendance and payments</p>
                        @if($project->workers()->active()->count() == 0)
                            <a href="{{ route('projects.workers.create', $project) }}" class="btn btn-primary gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Add Your First Worker
                            </a>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
