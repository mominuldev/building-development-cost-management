<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Materials - ') . $project->name }}
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
                    <div class="stat-title">Total Materials</div>
                    <div class="stat-value text-primary">{{ $materials->count() }}</div>
                </div>

                <div class="stat">
                    <div class="stat-title">Total Cost</div>
                    <div class="stat-value text-secondary">{{ number_format($materials->sum('total_cost'), 0) }}</div>
                </div>

                <div class="stat">
                    <div class="stat-title">Most Recent</div>
                    <div class="stat-desc">{{ $materials->first()?->purchase_date?->format('M d, Y') ?? '-' }}</div>
                </div>
            </div>

            <!-- Materials Table -->
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="card-title">All Materials</h3>
                        <a href="{{ route('projects.materials.create', $project) }}" class="btn btn-primary gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Add Material
                        </a>
                    </div>

                    @if($materials->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="table table-zebra">
                                <thead>
                                    <tr>
                                        <th>Type</th>
                                        <th>Name</th>
                                        <th>Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Total Cost</th>
                                        <th>Purchase Date</th>
                                        <th>Supplier</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($materials as $material)
                                        <tr>
                                            <td>
                                                <div class="badge badge-info">{{ ucfirst(str_replace('_', ' ', $material->material_type)) }}</div>
                                            </td>
                                            <td>
                                                <div class="font-bold">{{ $material->name }}</div>
                                            </td>
                                            <td>{{ number_format($material->quantity, 2) }} {{ $material->unit }}</td>
                                            <td>{{ number_format($material->unit_price, 2) }}</td>
                                            <td>
                                                <div class="font-bold text-lg">{{ number_format($material->total_cost, 2) }}</div>
                                            </td>
                                            <td>{{ $material->purchase_date->format('M d, Y') }}</td>
                                            <td>{{ $material->supplier ?? '-' }}</td>
                                            <td>
                                                <div class="flex gap-2">
                                                    <a href="{{ route('projects.materials.edit', [$project, $material]) }}" class="btn btn-xs btn-warning">Edit</a>
                                                    <form action="{{ route('projects.materials.destroy', [$project, $material]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this material?')">
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
                        <div class="alert alert-info flex gap-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <h3 class="font-bold">No materials yet!</h3>
                                <div class="text-xs mb-2">Start tracking your construction materials.</div>
                                <a href="{{ route('projects.materials.create', $project) }}" class="btn btn-sm btn-primary">Add First Material</a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
