<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <div class="flex items-center gap-3">
                    <h2 class="text-2xl font-bold text-gray-900">Finishing Works</h2>
                    <div class="badge badge-primary">{{ $project->name }}</div>
                </div>
                <p class="text-gray-500 mt-1">Track finishing costs (flooring, painting, plumbing, electrical, etc.)</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('projects.finishing-works.create', $project) }}" class="btn btn-primary btn-sm gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Add Finishing Work
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
                <div class="card bg-gradient-to-br from-pink-50 to-rose-50 border border-pink-200 shadow-lg hover:shadow-xl transition-shadow">
                    <div class="card-body p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Total Items</p>
                                <p class="text-3xl font-bold text-pink-600">{{ $finishingWorks->count() }}</p>
                                <p class="text-xs text-gray-400">Finishing items</p>
                            </div>
                            <div class="h-14 w-14 rounded-xl bg-pink-500 flex items-center justify-center shadow-lg">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-5.714-2.143L2 12l5.714-2.143L11 3z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Cost -->
                <div class="card bg-gradient-to-br from-rose-50 to-red-50 border border-rose-200 shadow-lg hover:shadow-xl transition-shadow">
                    <div class="card-body p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Total Cost</p>
                                <p class="text-2xl font-bold text-rose-600">{{ number_format($finishingWorks->sum('total_cost'), 2) }}</p>
                                <p class="text-xs text-gray-400">All finishing works</p>
                            </div>
                            <div class="h-14 w-14 rounded-xl bg-rose-500 flex items-center justify-center shadow-lg">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Average Cost -->
                <div class="card bg-gradient-to-br from-fuchsia-50 to-purple-50 border border-fuchsia-200 shadow-lg hover:shadow-xl transition-shadow">
                    <div class="card-body p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Average Cost</p>
                                <p class="text-3xl font-bold text-fuchsia-600">{{ number_format($finishingWorks->count() > 0 ? $finishingWorks->sum('total_cost') / $finishingWorks->count() : 0, 2) }}</p>
                                <p class="text-xs text-gray-400">Per finishing item</p>
                            </div>
                            <div class="h-14 w-14 rounded-xl bg-fuchsia-500 flex items-center justify-center shadow-lg">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Most Recent -->
                <div class="card bg-gradient-to-br from-violet-50 to-indigo-50 border border-violet-200 shadow-lg hover:shadow-xl transition-shadow">
                    <div class="card-body p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Most Recent</p>
                                <p class="text-lg font-bold text-gray-900">{{ $finishingWorks->first()?->work_date?->format('M d, Y') ?? '-' }}</p>
                                <p class="text-xs text-gray-400">Last work date</p>
                            </div>
                            <div class="h-14 w-14 rounded-xl bg-violet-500 flex items-center justify-center shadow-lg">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Finishing Works Table -->
            <div class="card bg-white shadow-xl">
                <div class="card-body">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-3">
                            <div class="h-10 w-10 rounded-lg bg-gradient-to-br from-pink-500 to-rose-500 flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-5.714-2.143L2 12l5.714-2.143L11 3z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">All Finishing Works</h3>
                                <p class="text-sm text-gray-500">{{ $finishingWorks->count() }} item{{ $finishingWorks->count() != 1 ? 's' : '' }}</p>
                            </div>
                        </div>
                    </div>

                    @if($finishingWorks->count() > 0)
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
                                    @foreach($finishingWorks as $finishing)
                                        <tr class="hover">
                                            <td>
                                                <div class="badge badge-secondary badge-lg">{{ ucfirst(str_replace('_', ' ', $finishing->work_type)) }}</div>
                                            </td>
                                            <td>
                                                <div>
                                                    <div class="font-bold text-gray-900">{{ $finishing->name }}</div>
                                                    @if($finishing->description)
                                                        <div class="text-xs text-gray-500">{{ \Illuminate\Support\Str::limit($finishing->description, 40) }}</div>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="text-right">
                                                <div class="text-lg font-bold text-gray-900">{{ number_format($finishing->quantity, 2) }}</div>
                                                <div class="text-xs text-gray-500">{{ $finishing->unit }}</div>
                                            </td>
                                            <td class="text-right">
                                                <div class="text-lg font-bold text-gray-700">{{ number_format($finishing->unit_price, 2) }}</div>
                                            </td>
                                            <td class="text-right">
                                                <div class="text-lg font-bold text-rose-600">{{ number_format($finishing->total_cost, 2) }}</div>
                                            </td>
                                            <td>
                                                <div class="text-sm text-gray-900">{{ $finishing->work_date->format('M d, Y') }}</div>
                                            </td>
                                            <td>
                                                <div class="flex gap-1 justify-center">
                                                    <a href="{{ route('projects.finishing-works.edit', [$project, $finishing]) }}" class="btn btn-ghost btn-xs btn-circle text-warning" title="Edit">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                        </svg>
                                                    </a>
                                                    <form action="{{ route('projects.finishing-works.destroy', [$project, $finishing]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this finishing work?')">
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
                            <div class="inline-flex h-20 w-20 items-center justify-center rounded-full bg-pink-100 mb-4">
                                <svg class="w-10 h-10 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-5.714-2.143L2 12l5.714-2.143L11 3z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">No finishing works yet!</h3>
                            <p class="text-gray-500 mb-6">Start tracking your finishing costs (flooring, painting, plumbing, electrical, etc.)</p>
                            <a href="{{ route('projects.finishing-works.create', $project) }}" class="btn btn-primary gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Add Your First Finishing Work
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
