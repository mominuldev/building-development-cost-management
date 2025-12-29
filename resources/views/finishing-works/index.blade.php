<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Finishing Works - ') . $project->name }}
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
                    <div class="stat-value text-secondary">{{ $finishingWorks->count() }}</div>
                </div>

                <div class="stat">
                    <div class="stat-title">Total Cost</div>
                    <div class="stat-value text-secondary">{{ number_format($finishingWorks->sum('total_cost'), 0) }}</div>
                </div>

                <div class="stat">
                    <div class="stat-title">Most Recent</div>
                    <div class="stat-desc">{{ $finishingWorks->first()?->work_date?->format('M d, Y') ?? '-' }}</div>
                </div>
            </div>

            <!-- Finishing Works Table -->
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="card-title">All Finishing Works</h3>
                        <a href="{{ route('projects.finishing-works.create', $project) }}" class="btn btn-secondary gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Add Finishing Work
                        </a>
                    </div>

                    @if($finishingWorks->count() > 0)
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
                                    @foreach($finishingWorks as $finishing)
                                        <tr>
                                            <td>
                                                <div class="badge badge-secondary">{{ ucfirst(str_replace('_', ' ', $finishing->work_type)) }}</div>
                                            </td>
                                            <td>
                                                <div>
                                                    <div class="font-bold">{{ $finishing->name }}</div>
                                                    @if($finishing->description)
                                                        <div class="text-xs text-gray-500">{{ $finishing->description }}</div>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>{{ number_format($finishing->quantity, 2) }} {{ $finishing->unit }}</td>
                                            <td>{{ number_format($finishing->unit_price, 2) }}</td>
                                            <td>
                                                <div class="font-bold text-lg">{{ number_format($finishing->total_cost, 2) }}</div>
                                            </td>
                                            <td>{{ $finishing->work_date->format('M d, Y') }}</td>
                                            <td>
                                                <div class="flex gap-2">
                                                    <a href="{{ route('projects.finishing-works.edit', [$project, $finishing]) }}" class="btn btn-xs btn-accent">Edit</a>
                                                    <form action="{{ route('projects.finishing-works.destroy', [$project, $finishing]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this finishing work?')">
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-5.714-2.143L2 12l5.714-2.143L11 3z"></path>
                            </svg>
                            <div>
                                <h3 class="font-bold">No finishing works yet!</h3>
                                <div class="text-xs">Start tracking your finishing costs (flooring, painting, plumbing, electrical, etc.).</div>
                            </div>
                            <a href="{{ route('projects.finishing-works.create', $project) }}" class="btn btn-sm btn-secondary">Add First Finishing Work</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
