<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <div class="flex items-center gap-3">
                    <h2 class="text-2xl font-bold text-gray-900">Structure Costs</h2>
                    <div class="badge badge-primary">{{ $project->name }}</div>
                </div>
                <p class="text-gray-500 mt-1">Track structural work costs (foundation, columns, beams, slabs, roof)</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('projects.structure-costs.create', $project) }}" class="btn btn-primary btn-sm gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Add Structure Cost
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
            <!-- Summary Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Total Items -->
                <div class="card bg-gradient-to-br from-amber-50 to-orange-50 border border-amber-200 shadow-lg hover:shadow-xl transition-shadow">
                    <div class="card-body p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Total Items</p>
                                <p class="text-3xl font-bold text-amber-600">{{ $structureCosts->count() }}</p>
                                <p class="text-xs text-gray-400">Structure items</p>
                            </div>
                            <div class="h-14 w-14 rounded-xl bg-amber-500 flex items-center justify-center shadow-lg">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Cost -->
                <div class="card bg-gradient-to-br from-orange-50 to-red-50 border border-orange-200 shadow-lg hover:shadow-xl transition-shadow">
                    <div class="card-body p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Total Cost</p>
                                <p class="text-2xl font-bold text-orange-600">{{ number_format($structureCosts->sum('total_cost'), 2) }}</p>
                                <p class="text-xs text-gray-400">All structure costs</p>
                            </div>
                            <div class="h-14 w-14 rounded-xl bg-orange-500 flex items-center justify-center shadow-lg">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Average Cost -->
                <div class="card bg-gradient-to-br from-yellow-50 to-amber-50 border border-yellow-200 shadow-lg hover:shadow-xl transition-shadow">
                    <div class="card-body p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Average Cost</p>
                                <p class="text-3xl font-bold text-yellow-600">{{ number_format($structureCosts->count() > 0 ? $structureCosts->sum('total_cost') / $structureCosts->count() : 0, 2) }}</p>
                                <p class="text-xs text-gray-400">Per structure item</p>
                            </div>
                            <div class="h-14 w-14 rounded-xl bg-yellow-500 flex items-center justify-center shadow-lg">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Most Recent -->
                <div class="card bg-gradient-to-br from-rose-50 to-pink-50 border border-rose-200 shadow-lg hover:shadow-xl transition-shadow">
                    <div class="card-body p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Most Recent</p>
                                <p class="text-lg font-bold text-gray-900">{{ $structureCosts->first()?->work_date?->format('M d, Y') ?? '-' }}</p>
                                <p class="text-xs text-gray-400">Last work date</p>
                            </div>
                            <div class="h-14 w-14 rounded-xl bg-rose-500 flex items-center justify-center shadow-lg">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Structure Costs Table -->
            <div class="card bg-white shadow-xl">
                <div class="card-body">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-3">
                            <div class="h-10 w-10 rounded-lg bg-gradient-to-br from-amber-500 to-orange-500 flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">All Structure Costs</h3>
                                <p class="text-sm text-gray-500">{{ $structureCosts->count() }} item{{ $structureCosts->count() != 1 ? 's' : '' }}</p>
                            </div>
                        </div>
                    </div>

                    @if($structureCosts->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Type</th>
                                        <th>Name</th>
                                        <th class="text-right">Quantity</th>
                                        <th class="text-right">Unit Price</th>
                                        <th class="text-right">Total Cost</th>
                                        <th>Work Date</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($structureCosts as $structure)
                                        <tr class="hover">
                                            <td>
                                                <div class="badge badge-warning badge-lg">{{ ucfirst($structure->structure_type) }}</div>
                                            </td>
                                            <td>
                                                <div>
                                                    <div class="font-bold text-gray-900">{{ $structure->name }}</div>
                                                    @if($structure->description)
                                                        <div class="text-xs text-gray-500">{{ \Illuminate\Support\Str::limit($structure->description, 40) }}</div>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="text-right">
                                                <div class="text-lg font-bold text-gray-900">{{ number_format($structure->quantity, 2) }}</div>
                                                <div class="text-xs text-gray-500">{{ $structure->unit }}</div>
                                            </td>
                                            <td class="text-right">
                                                <div class="text-lg font-bold text-gray-700">{{ number_format($structure->unit_price, 2) }}</div>
                                            </td>
                                            <td class="text-right">
                                                <div class="text-lg font-bold text-orange-600">{{ number_format($structure->total_cost, 2) }}</div>
                                            </td>
                                            <td>
                                                <div class="text-sm text-gray-900">{{ $structure->work_date->format('M d, Y') }}</div>
                                            </td>
                                            <td>
                                                <div class="flex gap-1 justify-center">
                                                    <a href="{{ route('projects.structure-costs.edit', [$project, $structure]) }}" class="btn btn-ghost btn-xs btn-circle text-warning" title="Edit">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                        </svg>
                                                    </a>
                                                    <form action="{{ route('projects.structure-costs.destroy', [$project, $structure]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this structure cost?')">
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
                            <div class="inline-flex h-20 w-20 items-center justify-center rounded-full bg-amber-100 mb-4">
                                <svg class="w-10 h-10 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">No structure costs yet!</h3>
                            <p class="text-gray-500 mb-6">Start tracking your structural work costs (foundation, columns, beams, slabs, roof)</p>
                            <a href="{{ route('projects.structure-costs.create', $project) }}" class="btn btn-primary gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Add Your First Structure Cost
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
