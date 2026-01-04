<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <div class="flex items-center gap-3">
                    <h2 class="text-2xl font-bold text-gray-900">Payment History</h2>
                    <div class="badge badge-primary">{{ $project->name }}</div>
                </div>
                <p class="text-gray-500 mt-1">Track payments to contractors and workers</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('projects.payments.create', $project) }}" class="btn btn-primary btn-sm gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Record Payment
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
            <!-- Payment Summary Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Total to Contractors -->
                <div class="card bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-200 shadow-lg hover:shadow-xl transition-shadow">
                    <div class="card-body p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Paid to Contractors</p>
                                <p class="text-3xl font-bold text-blue-600">{{ number_format($paymentStats['total_to_contractors'], 2) }}</p>
                                <p class="text-xs text-gray-400">All contractor payments</p>
                            </div>
                            <div class="h-14 w-14 rounded-xl bg-blue-500 flex items-center justify-center shadow-lg">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total to Workers -->
                <div class="card bg-gradient-to-br from-green-50 to-emerald-50 border border-green-200 shadow-lg hover:shadow-xl transition-shadow">
                    <div class="card-body p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Paid to Workers</p>
                                <p class="text-3xl font-bold text-green-600">{{ number_format($paymentStats['total_to_workers'], 2) }}</p>
                                <p class="text-xs text-gray-400">All worker payments</p>
                            </div>
                            <div class="h-14 w-14 rounded-xl bg-green-500 flex items-center justify-center shadow-lg">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Payments -->
                <div class="card bg-gradient-to-br from-purple-50 to-violet-50 border border-purple-200 shadow-lg hover:shadow-xl transition-shadow">
                    <div class="card-body p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Total Payments</p>
                                <p class="text-3xl font-bold text-purple-600">{{ number_format($paymentStats['total_payments'], 2) }}</p>
                                <p class="text-xs text-gray-400">{{ $payments->count() }} transaction{{ $payments->count() != 1 ? 's' : '' }}</p>
                            </div>
                            <div class="h-14 w-14 rounded-xl bg-purple-500 flex items-center justify-center shadow-lg">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Form -->
            <div class="card bg-white shadow-xl">
                <div class="card-body">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="h-8 w-8 rounded-lg bg-gradient-to-br from-indigo-500 to-purple-500 flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                            </svg>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-900">Filter Payments</h4>
                    </div>
                    <form method="GET">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-semibold text-gray-900">Recipient Type</span>
                                </label>
                                <select name="type" class="select select-bordered">
                                    <option value="">All Types</option>
                                    <option value="contractor" {{ request('type') == 'contractor' ? 'selected' : '' }}>Contractors</option>
                                    <option value="worker" {{ request('type') == 'worker' ? 'selected' : '' }}>Workers</option>
                                </select>
                            </div>
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-semibold text-gray-900">Status</span>
                                </label>
                                <select name="status" class="select select-bordered">
                                    <option value="">All Statuses</option>
                                    <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                                    <option value="partial" {{ request('status') == 'partial' ? 'selected' : '' }}>Partial</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-semibold text-gray-900">&nbsp;</span>
                                </label>
                                <button type="submit" class="btn btn-primary gap-2 w-full">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                                    </svg>
                                    Filter
                                </button>
                            </div>
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-semibold text-gray-900">&nbsp;</span>
                                </label>
                                <a href="{{ route('projects.payments.index', $project) }}" class="btn btn-ghost gap-2 w-full">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                    Clear
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Payments List -->
            <div class="card bg-white shadow-xl">
                <div class="card-body">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-3">
                            <div class="h-10 w-10 rounded-lg bg-gradient-to-br from-emerald-500 to-teal-500 flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Payment Records</h3>
                                <p class="text-sm text-gray-500">{{ $payments->count() }} transaction{{ $payments->count() != 1 ? 's' : '' }}</p>
                            </div>
                        </div>
                    </div>

                    @if($payments->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Recipient</th>
                                        <th>Type</th>
                                        <th class="text-right">Amount</th>
                                        <th>Method</th>
                                        <th>Status</th>
                                        <th>Reference & Notes</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($payments as $payment)
                                        <tr class="hover">
                                            <td>
                                                <div class="text-sm font-bold text-gray-900">{{ $payment->payment_date->format('M d, Y') }}</div>
                                            </td>
                                            <td>
                                                @if($payment->recipient_type == 'contractor')
                                                    @if($payment->recipient)
                                                        <div class="flex items-center gap-2">
                                                            <div class="avatar placeholder">
                                                                <div class="bg-blue-100 text-blue-600 rounded-lg w-8">
                                                                    <span class="text-xs h-full flex items-center justify-center">{{ substr($payment->recipient->name ?? 'C', 0, 1) }}</span>
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <div class="font-bold text-gray-900">{{ $payment->recipient->name ?? 'Contractor #' . $payment->recipient_id }}</div>
                                                                <div class="text-xs h-full text-gray-500 flex items-center justify-center">Contractor</div>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="text-error text-sm">Contractor deleted</div>
                                                    @endif
                                                @else
                                                    @if($payment->recipient)
                                                        <div class="flex items-center gap-2">
                                                            <div class="avatar placeholder">
                                                                <div class="bg-green-100 text-green-600 rounded-lg w-8">
                                                                    <span class="text-xs h-full flex items-center justify-center">{{ substr($payment->recipient->name, 0, 1) }}</span>
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <div class="font-bold text-gray-900">{{ $payment->recipient->name }}</div>
                                                                <div class="text-xs text-gray-500">Worker</div>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="text-error text-sm">Worker deleted</div>
                                                    @endif
                                                @endif
                                            </td>
                                            <td>
                                                @if($payment->recipient_type == 'contractor')
                                                    <div class="badge badge-primary">Contractor</div>
                                                @else
                                                    <div class="badge badge-secondary">Worker</div>
                                                @endif
                                            </td>
                                            <td class="text-right">
                                                <div class="text-lg font-bold text-purple-600">{{ number_format($payment->amount, 2) }}</div>
                                            </td>
                                            <td>
                                                <div class="badge badge-ghost">{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</div>
                                            </td>
                                            <td>
                                                @if($payment->status == 'paid')
                                                    <div class="badge badge-success badge-lg">Paid</div>
                                                @elseif($payment->status == 'partial')
                                                    <div class="badge badge-warning badge-lg">Partial</div>
                                                @elseif($payment->status == 'pending')
                                                    <div class="badge badge-info badge-lg">Pending</div>
                                                @else
                                                    <div class="badge badge-error badge-lg">Cancelled</div>
                                                @endif
                                            </td>
                                            <td>
                                                @if($payment->transaction_reference)
                                                    <div class="text-xs text-gray-900">Ref: {{ $payment->transaction_reference }}</div>
                                                @endif
                                                @if($payment->notes)
                                                    <div class="text-xs text-gray-500">{{ Str::limit($payment->notes, 40) }}</div>
                                                @endif
                                                @if($payment->period_start && $payment->period_end)
                                                    <div class="text-xs text-gray-400">
                                                        {{ $payment->period_start->format('M d') }} - {{ $payment->period_end->format('M d') }}
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="flex gap-1 justify-center">
                                                    <a href="{{ route('projects.payments.edit', [$project, $payment]) }}" class="btn btn-ghost btn-xs btn-circle text-warning" title="Edit">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                        </svg>
                                                    </a>
                                                    <form action="{{ route('projects.payments.destroy', [$project, $payment]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this payment record?')">
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
                            <div class="inline-flex h-20 w-20 items-center justify-center rounded-full bg-purple-100 mb-4">
                                <svg class="w-10 h-10 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">No payments recorded</h3>
                            <p class="text-gray-500 mb-6">Start recording payments to contractors and workers</p>
                            <a href="{{ route('projects.payments.create', $project) }}" class="btn btn-primary gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Record Your First Payment
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
