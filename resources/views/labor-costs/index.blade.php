<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Contractor Costs - {{ $project->name }}
            </h2>
            <a href="{{ route('projects.show', $project) }}" class="text-sm text-gray-600 hover:text-gray-900">
                &larr; Back to Project
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Summary Card -->
            <div class="bg-white rounded-lg shadow mb-6 p-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Total Contractors</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $laborCosts->count() }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Total Cost</p>
                        <p class="text-2xl font-bold text-blue-600">{{ number_format($laborCosts->sum('actual_total_cost'), 2) }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Assigned Workers</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $laborCosts->sum('assigned_workers_count') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Total Due</p>
                        <p class="text-2xl font-bold text-orange-600">{{ number_format($laborCosts->sum('total_due'), 2) }}</p>
                    </div>
                </div>
            </div>

            <!-- Contractors Payment Summary -->
            <div class="card bg-base-100 shadow-xl mb-6">
                <div class="card-body">
                    <h3 class="card-title">Contractors Payment Status</h3>
                    <p class="text-gray-600 mb-4">Track payments and dues for each contractor based on their workers' attendance.</p>

                    @if($laborCosts->where('labor_type', 'contractor')->count() > 0)
                        <div class="overflow-x-auto mt-4">
                            <table class="table table-zebra">
                                <thead>
                                    <tr>
                                        <th>Contractor</th>
                                        <th>Category</th>
                                        <th>Workers Under</th>
                                        <th>Total Due</th>
                                        <th>Paid</th>
                                        <th>Balance</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($laborCosts->where('labor_type', 'contractor') as $contractor)
                                        <tr>
                                            <td>
                                                <div class="font-bold">{{ $contractor->name ?? 'Contractor #' . $contractor->id }}</div>
                                            </td>
                                            <td>
                                                <div class="badge badge-ghost">{{ ucfirst($contractor->category) }}</div>
                                            </td>
                                            <td>
                                                <div class="badge badge-info">{{ $contractor->contractorWorkers->count() }} workers</div>
                                            </td>
                                            <td>
                                                <div class="text-lg font-bold text-error">{{ number_format($contractor->total_due, 2) }}</div>
                                            </td>
                                            <td>
                                                <div class="text-lg font-bold text-success">{{ number_format($contractor->total_payments_received, 2) }}</div>
                                            </td>
                                            <td>
                                                @php
                                                    $balance = $contractor->total_due - $contractor->total_payments_received;
                                                @endphp
                                                <div class="text-lg font-bold {{ $balance > 0 ? 'text-warning' : 'text-success' }}">
                                                    {{ number_format($balance, 2) }}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="flex gap-2">
                                                    <a href="{{ route('projects.contractors.workers.index', [$project, $contractor]) }}" class="btn btn-xs btn-info">View Workers</a>
                                                    <a href="{{ route('projects.payments.index', [$project, 'type' => 'contractor']) }}" class="btn btn-xs btn-primary">Payments</a>
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <h3 class="font-bold">No contractors found</h3>
                                <div class="text-xs">Add contractors to track payments and worker assignments.</div>
                            </div>
                            <a href="{{ route('projects.labor-costs.create', $project) }}" class="btn btn-sm btn-primary">Add Contractor</a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- All Contractors Table -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900">All Contractors</h3>
                    <a href="{{ route('projects.labor-costs.create', $project) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Add Contractor
                    </a>
                </div>
                <div class="p-6">
                    @if($laborCosts->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contractor</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Assigned Workers</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Cost (from attendance)</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($laborCosts as $labor)
                                        <tr>
                                            <td class="px-6 py-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $labor->name ?? 'Contractor #' . $labor->id }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ ucfirst($labor->category) }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="badge badge-info">{{ $labor->assigned_workers_count }} workers</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-bold text-gray-900">{{ number_format($labor->actual_total_cost, 2) }}</div>
                                                <div class="text-xs text-gray-500">From workers' attendance</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @php
                                                    $balance = $labor->total_due - $labor->total_payments_received;
                                                @endphp
                                                @if($balance <= 0)
                                                    <div class="badge badge-success">Paid</div>
                                                @elseif($labor->total_payments_received > 0)
                                                    <div class="badge badge-warning">Partial</div>
                                                @else
                                                    <div class="badge badge-error">Unpaid</div>
                                                @endif
                                                <div class="text-xs text-gray-500 mt-1">
                                                    Due: {{ number_format($labor->total_due, 2) }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                                <a href="{{ route('projects.contractors.workers.index', [$project, $labor]) }}" class="text-indigo-600 hover:text-indigo-900">Workers</a>
                                                <a href="{{ route('projects.labor-costs.edit', [$project, $labor]) }}" class="text-yellow-600 hover:text-yellow-900">Edit</a>
                                                <form action="{{ route('projects.labor-costs.destroy', [$project, $labor]) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this contractor?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-500 mb-4">No contractors added yet.</p>
                            <a href="{{ route('projects.labor-costs.create', $project) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                                Add First Contractor
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
