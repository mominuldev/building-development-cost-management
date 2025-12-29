<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Structure Costs - ') . $project->name }}
            </h2>
            <a href="{{ route('projects.show', $project) }}" class="btn btn-sm btn-ghost">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Project
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Summary Card -->
            <div class="stats stats-vertical lg:stats-horizontal shadow mb-6 w-full">
                <div class="stat">
                    <div class="stat-title">Total Items</div>
                    <div class="stat-value text-warning">{{ $structureCosts->count() }}</div>
                </div>

                <div class="stat">
                    <div class="stat-title">Total Cost</div>
                    <div class="stat-value text-secondary">{{ number_format($structureCosts->sum('total_cost'), 0) }}</div>
                </div>

                <div class="stat">
                    <div class="stat-title">Most Recent</div>
                    <div class="stat-desc">{{ $structureCosts->first()?->work_date?->format('M d, Y') ?? '-' }}</div>
                </div>
            </div>

            <!-- Structure Costs Table -->
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="card-title">All Structure Costs</h3>
                        <a href="{{ route('projects.structure-costs.create', $project) }}" class="btn btn-warning gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Add Structure Cost
                        </a>
                    </div>

                    @if($structureCosts->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="table table-zebra">
                                <thead>
                                    <tr>
                                        <th>Type</th>
                                        <th>Name</th>
                                        <th>Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Total Cost</th>
                                        <th>Work Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($structureCosts as $structure)
                                        <tr>
                                            <td>
                                                <div class="badge badge-warning">{{ ucfirst($structure->structure_type) }}</div>
                                            </td>
                                            <td>
                                                <div>
                                                    <div class="font-bold">{{ $structure->name }}</div>
                                                    @if($structure->description)
                                                        <div class="text-xs text-gray-500">{{ $structure->description }}</div>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>{{ number_format($structure->quantity, 2) }} {{ $structure->unit }}</td>
                                            <td>{{ number_format($structure->unit_price, 2) }}</td>
                                            <td>
                                                <div class="font-bold text-lg">{{ number_format($structure->total_cost, 2) }}</div>
                                            </td>
                                            <td>{{ $structure->work_date->format('M d, Y') }}</td>
                                            <td>
                                                <div class="flex gap-2">
                                                    <a href="{{ route('projects.structure-costs.edit', [$project, $structure]) }}" class="btn btn-xs btn-info">Edit</a>
                                                    <form action="{{ route('projects.structure-costs.destroy', [$project, $structure]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this structure cost?')">
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            <div>
                                <h3 class="font-bold">No structure costs yet!</h3>
                                <div class="text-xs">Start tracking your structural work costs (foundation, columns, beams, slabs, roof).</div>
                            </div>
                            <a href="{{ route('projects.structure-costs.create', $project) }}" class="btn btn-sm btn-warning">Add First Structure Cost</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
