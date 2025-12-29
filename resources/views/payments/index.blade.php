<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Payment History - {{ $project->name }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('projects.payments.create', $project) }}" class="btn btn-sm btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Record Payment
                </a>
                <a href="{{ route('projects.show', $project) }}" class="btn btn-sm btn-ghost">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Project
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Payment Stats -->
            <div class="card bg-base-100 shadow-xl mb-6">
                <div class="card-body">
                    <h3 class="card-title">Payment Summary</h3>
                    <div class="stats stats-vertical lg:stats-horizontal bg-base-200">
                        <div class="stat">
                            <div class="stat-title">Total to Contractors</div>
                            <div class="stat-value text-primary">{{ number_format($paymentStats['total_to_contractors'], 2) }}</div>
                        </div>
                        <div class="stat">
                            <div class="stat-title">Total to Workers</div>
                            <div class="stat-value text-secondary">{{ number_format($paymentStats['total_to_workers'], 2) }}</div>
                        </div>
                        <div class="stat">
                            <div class="stat-title">Total Payments</div>
                            <div class="stat-value text-accent">{{ number_format($paymentStats['total_payments'], 2) }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Form -->
            <div class="card bg-base-100 shadow-xl mb-6">
                <div class="card-body">
                    <form method="GET" class="flex gap-4 items-end">
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Recipient Type</span>
                            </label>
                            <select name="type" class="select select-bordered">
                                <option value="">All Types</option>
                                <option value="contractor" {{ request('type') == 'contractor' ? 'selected' : '' }}>Contractors</option>
                                <option value="worker" {{ request('type') == 'worker' ? 'selected' : '' }}>Workers</option>
                            </select>
                        </div>
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Status</span>
                            </label>
                            <select name="status" class="select select-bordered">
                                <option value="">All Statuses</option>
                                <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="partial" {{ request('status') == 'partial' ? 'selected' : '' }}>Partial</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Filter</button>
                        <a href="{{ route('projects.payments.index', $project) }}" class="btn btn-ghost">Clear</a>
                    </form>
                </div>
            </div>

            <!-- Payments List -->
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h3 class="card-title">Payment Records</h3>

                    @if($payments->count() > 0)
                        <div class="overflow-x-auto mt-4">
                            <table class="table table-zebra">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Recipient</th>
                                        <th>Type</th>
                                        <th>Amount</th>
                                        <th>Method</th>
                                        <th>Status</th>
                                        <th>Notes</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($payments as $payment)
                                        <tr>
                                            <td>{{ $payment->payment_date->format('M d, Y') }}</td>
                                            <td>
                                                @if($payment->recipient_type == 'contractor')
                                                    @if($payment->recipient)
                                                        <div class="font-bold">{{ $payment->recipient->name ?? 'Contractor #' . $payment->recipient_id }}</div>
                                                        <div class="text-xs text-gray-500">Contractor</div>
                                                    @else
                                                        <div class="text-error">Contractor deleted</div>
                                                    @endif
                                                @else
                                                    @if($payment->recipient)
                                                        <div class="font-bold">{{ $payment->recipient->name }}</div>
                                                        <div class="text-xs text-gray-500">Worker</div>
                                                    @else
                                                        <div class="text-error">Worker deleted</div>
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
                                            <td>
                                                <div class="font-bold text-lg">{{ number_format($payment->amount, 2) }}</div>
                                            </td>
                                            <td>
                                                <div class="badge badge-ghost">{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</div>
                                            </td>
                                            <td>
                                                @if($payment->status == 'paid')
                                                    <div class="badge badge-success">Paid</div>
                                                @elseif($payment->status == 'partial')
                                                    <div class="badge badge-warning">Partial</div>
                                                @elseif($payment->status == 'pending')
                                                    <div class="badge badge-info">Pending</div>
                                                @else
                                                    <div class="badge badge-error">Cancelled</div>
                                                @endif
                                            </td>
                                            <td>
                                                @if($payment->notes)
                                                    <div class="text-xs">{{ Str::limit($payment->notes, 50) }}</div>
                                                @endif
                                                @if($payment->transaction_reference)
                                                    <div class="text-xs text-gray-500">Ref: {{ $payment->transaction_reference }}</div>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="flex gap-2">
                                                    <a href="{{ route('projects.payments.edit', [$project, $payment]) }}" class="btn btn-xs btn-accent">Edit</a>
                                                    <form action="{{ route('projects.payments.destroy', [$project, $payment]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this payment?')">
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
                        <div class="alert alert-info mt-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <h3 class="font-bold">No payments recorded</h3>
                                <div class="text-xs">Start recording payments to contractors and workers.</div>
                            </div>
                            <a href="{{ route('projects.payments.create', $project) }}" class="btn btn-sm btn-primary">Record Payment</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
