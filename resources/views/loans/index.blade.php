<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <div class="flex items-center gap-3">
                    <h2 class="text-2xl font-bold text-gray-900">Loans</h2>
                    <div class="badge badge-primary">{{ $project->name }}</div>
                </div>
                <p class="text-gray-500 mt-1">Manage loans to workers and contractors</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('projects.show', $project) }}" class="btn btn-ghost btn-sm gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Project
                </a>
                <a href="{{ route('projects.loans.create', $project) }}" class="btn btn-primary btn-sm gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Add Loan
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Summary Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <!-- Total Loans Given -->
                <div class="card bg-white shadow-lg hover:shadow-xl transition-shadow">
                    <div class="card-body p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500">Total Loans</p>
                                <p class="text-3xl font-bold text-blue-600">{{ number_format($totalLoans, 2) }}</p>
                                <p class="text-xs text-gray-400">Amount given</p>
                            </div>
                            <div class="h-12 w-12 rounded-xl bg-blue-100 flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Repaid -->
                <div class="card bg-white shadow-lg hover:shadow-xl transition-shadow">
                    <div class="card-body p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500">Repaid</p>
                                <p class="text-3xl font-bold text-green-600">{{ number_format($totalRepaid, 2) }}</p>
                                <p class="text-xs text-gray-400">Amount recovered</p>
                            </div>
                            <div class="h-12 w-12 rounded-xl bg-green-100 flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pending Loans -->
                <div class="card bg-white shadow-lg hover:shadow-xl transition-shadow">
                    <div class="card-body p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500">Pending</p>
                                <p class="text-3xl font-bold text-orange-600">{{ $totalPending }}</p>
                                <p class="text-xs text-gray-400">Not yet repaid</p>
                            </div>
                            <div class="h-12 w-12 rounded-xl bg-orange-100 flex items-center justify-center">
                                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Partial Loans -->
                <div class="card bg-white shadow-lg hover:shadow-xl transition-shadow">
                    <div class="card-body p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500">Partial</p>
                                <p class="text-3xl font-bold text-yellow-600">{{ $totalPartial }}</p>
                                <p class="text-xs text-gray-400">Partially repaid</p>
                            </div>
                            <div class="h-12 w-12 rounded-xl bg-yellow-100 flex items-center justify-center">
                                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Overdue Loans -->
                <div class="card bg-white shadow-lg hover:shadow-xl transition-shadow">
                    <div class="card-body p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500">Overdue</p>
                                <p class="text-3xl font-bold text-red-600">{{ $totalOverdue }}</p>
                                <p class="text-xs text-gray-400">Past due date</p>
                            </div>
                            <div class="h-12 w-12 rounded-xl bg-red-100 flex items-center justify-center">
                                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Loans List -->
            <div class="card bg-white shadow-xl">
                <div class="card-body">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-3">
                            <div class="h-10 w-10 rounded-lg bg-gradient-to-br from-indigo-500 to-purple-500 flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">All Loans</h3>
                                <p class="text-sm text-gray-500">{{ $loans->count() }} loan{{ $loans->count() != 1 ? 's' : '' }} in total</p>
                            </div>
                        </div>
                    </div>

                    <!-- Recipient Summary -->
                    @if($recipients->count() > 0)
                    <div class="mt-8 mb-8">
                        <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            Loans by Recipient
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($recipients as $recipient)
                            <div class="card bg-gradient-to-br {{ $recipient['outstanding'] > 0 ? 'from-orange-50 to-red-50 border-orange-300' : 'from-purple-50 to-indigo-50 border-purple-200' }} border-2 hover:shadow-xl transition-all hover:-translate-y-1">
                                <div class="card-body p-4">
                                    <div class="flex items-start justify-between mb-3">
                                        <div class="flex items-center gap-3 flex-1">
                                            <div class="avatar placeholder">
                                                <div class="bg-{{ $recipient['outstanding'] > 0 ? 'orange' : 'purple' }}-100 text-{{ $recipient['outstanding'] > 0 ? 'orange' : 'purple' }}-600 rounded-full w-12">
                                                    <span class="text-lg font-bold">{{ substr($recipient['name'], 0, 1) }}</span>
                                                </div>
                                            </div>
                                            <div class="flex-1">
                                                <a href="{{ route('projects.loans.recipient', [$project, $recipient['name']]) }}" class="font-bold text-gray-900 hover:text-purple-700 hover:underline text-lg">
                                                    {{ $recipient['name'] }}
                                                </a>
                                                @if($recipient['phone'])
                                                    <p class="text-sm text-gray-500">{{ $recipient['phone'] }}</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="flex flex-col gap-1">
                                            <div class="badge badge-{{ $recipient['outstanding'] > 0 ? 'error' : 'success' }} badge-sm">
                                                {{ $recipient['total_loans'] }} loan{{ $recipient['total_loans'] != 1 ? 's' : '' }}
                                            </div>
                                            @if($recipient['outstanding'] > 0)
                                                <div class="badge badge-warning badge-xs gap-1">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                                    </svg>
                                                    Due
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    @if($recipient['outstanding'] > 0 && $recipient['outstanding'] > ($recipient['total_given'] * 0.5))
                                    <div class="alert alert-error alert-sm py-2 mb-3">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                        </svg>
                                        <span class="text-xs">High outstanding balance!</span>
                                    </div>
                                    @endif

                                    <div class="grid grid-cols-3 gap-2 text-center mb-3">
                                        <div class="bg-blue-50 rounded-lg p-2">
                                            <p class="text-xs text-gray-500">Given</p>
                                            <p class="font-bold text-blue-600">{{ number_format($recipient['total_given'], 0) }}</p>
                                        </div>
                                        <div class="bg-green-50 rounded-lg p-2">
                                            <p class="text-xs text-gray-500">Repaid</p>
                                            <p class="font-bold text-green-600">{{ number_format($recipient['total_repaid'], 0) }}</p>
                                        </div>
                                        <div class="bg-{{ $recipient['outstanding'] > 0 ? 'orange' : 'green' }}-50 rounded-lg p-2">
                                            <p class="text-xs text-gray-500">Due</p>
                                            <p class="font-bold text-{{ $recipient['outstanding'] > 0 ? 'orange' : 'green' }}-600">{{ number_format($recipient['outstanding'], 0) }}</p>
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-between pt-3 border-t border-gray-200">
                                        <div class="flex gap-1">
                                            <a href="{{ route('projects.loans.recipient', [$project, $recipient['name']]) }}" class="btn btn-xs btn-primary gap-1">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                                Details
                                            </a>
                                            <a href="{{ route('projects.loans.create', $project) }}"
                                               onclick="prefillAndCreate({{ json_encode($recipient) }}); return false;"
                                               class="btn btn-xs btn-success gap-1">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                Quick Loan
                                            </a>
                                        </div>
                                        <div class="flex gap-1">
                                            <button onclick="toggleRecipientLoans({{ $loop->index }})" class="btn btn-xs btn-ghost btn-circle" title="Toggle Loans">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                </svg>
                                            </button>
                                            <a href="{{ route('projects.loans.recipient.pdf', [$project, $recipient['name']]) }}" class="btn btn-xs btn-error btn-circle" title="Download PDF">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                    <div id="recipient_loans_{{ $loop->index }}" class="hidden mt-3 space-y-2">
                                        @foreach($recipient['loans'] as $loan)
                                        <div class="p-2 bg-white rounded border border-gray-200 text-xs">
                                            <div class="flex justify-between items-center">
                                                <div>
                                                    <span class="font-medium">{{ $loan->loan_date->format('M d, Y') }}</span>
                                                    <span class="badge badge-{{ $loan->payment_status_color }} badge-xs ml-1">{{ $loan->payment_status_text }}</span>
                                                </div>
                                                <div class="text-right">
                                                    <div>{{ number_format($loan->amount, 2) }}</div>
                                                    @if($loan->amount_repaid > 0)
                                                        <div class="text-green-600">Repaid: {{ number_format($loan->amount_repaid, 2) }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    @if($loans->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Recipient</th>
                                    <th>Payment</th>
                                    <th class="text-right">Amount</th>
                                    <th class="text-right">Repaid</th>
                                    <th class="text-right">Balance</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Due Date</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($loans as $loan)
                                    <tr class="hover">
                                        <td>
                                            <div class="font-bold text-gray-900">{{ $loan->loan_date->format('M d, Y') }}</div>
                                        </td>
                                        <td>
                                            <div class="flex items-center gap-2">
                                                <div class="avatar placeholder">
                                                    <div class="bg-success text-success-content rounded-lg w-8">
                                                        <span class="text-xs flex items-center justify-center h-full">{{ substr($loan->recipient_name, 0, 1) }}</span>
                                                    </div>
                                                </div>
                                                <div>
                                                    <a href="{{ route('projects.loans.recipient', [$project, $loan->recipient_name]) }}" class="font-bold text-gray-900 hover:text-purple-700 hover:underline">
                                                        {{ $loan->recipient_name }}
                                                    </a>
                                                    @if($loan->recipient_phone)
                                                        <div class="text-xs text-gray-500">{{ $loan->recipient_phone }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="badge badge-ghost">{{ ucfirst($loan->payment_method) }}</div>
                                        </td>
                                        <td class="text-right">
                                            <div class="text-lg font-bold text-gray-900">{{ number_format($loan->amount, 2) }}</div>
                                        </td>
                                        <td class="text-right">
                                            <div class="text-lg font-bold text-green-600">{{ number_format($loan->amount_repaid, 2) }}</div>
                                        </td>
                                        <td class="text-right">
                                            <div class="text-lg font-bold {{ $loan->remaining_balance > 0 ? 'text-orange-600' : 'text-green-600' }}">
                                                {{ number_format($loan->remaining_balance, 2) }}
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="badge badge-{{ $loan->payment_status_color }} badge-lg gap-1">
                                                @if($loan->status === 'paid')
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                @endif
                                                {{ $loan->payment_status_text }}
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            @if($loan->due_date)
                                                <div class="text-sm {{ $loan->is_overdue ? 'text-red-600 font-bold' : 'text-gray-700' }}">
                                                    {{ $loan->due_date->format('M d, Y') }}
                                                    @if($loan->is_overdue)
                                                        <div class="text-xs">Overdue</div>
                                                    @endif
                                                </div>
                                            @else
                                                <div class="text-sm text-gray-400">No due date</div>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="flex gap-1 justify-center">
                                                <button type="button" class="btn btn-xs btn-success gap-1 repay-btn" data-loan-id="{{ $loan->id }}" @if($loan->status === 'paid') disabled @endif>
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    Repay
                                                </button>
                                                <button type="button" class="btn btn-xs btn-info gap-1 history-btn" data-loan-id="{{ $loan->id }}" onclick="showHistoryModal({{ $loan->id }})">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    History
                                                </button>
                                                <a href="{{ route('projects.loans.edit', [$project, $loan]) }}" class="btn btn-ghost btn-xs btn-circle text-warning" title="Edit">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828L8.586-8.586z"></path>
                                                    </svg>
                                                </a>
                                                <form action="{{ route('projects.loans.destroy', [$project, $loan]) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this loan?')">
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
                        <div class="inline-flex h-20 w-20 items-center justify-center rounded-full bg-gray-100 mb-4">
                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">No loans yet</h3>
                        <p class="text-gray-500 mb-6">Give loans to workers or contractors and track repayments</p>
                        <a href="{{ route('projects.loans.create', $project) }}" class="btn btn-primary gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Give Your First Loan
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Repay Modal -->
    <div id="repay_modal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <!-- Modal panel -->
                <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left w-full">
                                <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Record Loan Repayment</h3>

                                <form method="POST" action="" id="repayForm" class="mt-4 space-y-4">
                                    @csrf
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Repayment Amount <span class="text-red-500">*</span></label>
                                            <div class="relative mt-1">
                                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                                    <span class="text-gray-500 sm:text-sm">{{ $project->currency ?? '$' }}</span>
                                                </div>
                                                <input type="number" name="amount" step="0.01" min="0.01" placeholder="0.00"
                                                    class="block w-full rounded-md border-0 py-1.5 pl-8 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-green-600 sm:text-sm sm:leading-6" required />
                                            </div>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Payment Date <span class="text-red-500">*</span></label>
                                            <div class="relative mt-1">
                                                <input type="date" name="payment_date" value="{{ today()->format('Y-m-d') }}"
                                                    class="block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-green-600 sm:text-sm sm:leading-6" required />
                                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Payment Method <span class="text-red-500">*</span></label>
                                        <select name="payment_method" class="mt-1 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-green-600 sm:text-sm sm:leading-6" required>
                                            <option value="cash">Cash</option>
                                            <option value="bank_transfer">Bank Transfer</option>
                                            <option value="check">Check</option>
                                            <option value="online">Online Payment</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Transaction Reference</label>
                                        <input type="text" name="transaction_reference" placeholder="Cheque number, reference ID, etc."
                                            class="mt-1 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-green-600 sm:text-sm sm:leading-6" />
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Notes</label>
                                        <textarea name="notes" rows="2" placeholder="Any additional notes..."
                                            class="mt-1 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-green-600 sm:text-sm sm:leading-6"></textarea>
                                    </div>

                                    <div class="mt-5 sm:mt-6 sm:grid sm:grid-flow-row-dense sm:grid-cols-2 sm:gap-3">
                                        <button type="submit" class="inline-flex w-full justify-center rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600 sm:col-start-2">
                                            Record Repayment
                                        </button>
                                        <button type="button" onclick="closeRepayModal()" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0">
                                            Cancel
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- History Modal -->
    <div id="history_modal" class="fixed inset-0 z-50 hidden" aria-labelledby="history-modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl">
                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left w-full">
                                <h3 class="text-base font-semibold leading-6 text-gray-900" id="history-modal-title">Loan Repayment History</h3>
                                <div id="history_content" class="mt-4">
                                    Loading...
                                </div>
                                <div class="mt-5 sm:mt-6">
                                    <button type="button" onclick="closeHistoryModal()" class="inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                                        Close
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const repayButtons = document.querySelectorAll('.repay-btn');
            const modal = document.getElementById('repay_modal');
            const form = document.getElementById('repayForm');
            const historyModal = document.getElementById('history_modal');

            repayButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    const loanId = this.getAttribute('data-loan-id');
                    form.action = "/projects/{{ $project->id }}/loans/" + loanId + "/repay";
                    modal.classList.remove('hidden');
                });
            });

            window.closeRepayModal = function() {
                modal.classList.add('hidden');
            };

            // History modal functions
            window.showHistoryModal = function(loanId) {
                const historyContent = document.getElementById('history_content');
                historyContent.innerHTML = '<div class="text-center py-8"><div class="loading loading-spinner"></div></div>';
                historyModal.classList.remove('hidden');

                // Fetch loan details with repayments
                fetch(`/projects/{{ $project->id }}/loans/${loanId}`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok: ' + response.statusText);
                        }
                        return response.json();
                    })
                    .then(data => {
                        displayHistory(data);
                    })
                    .catch(error => {
                        console.error('Error fetching loan history:', error);
                        historyContent.innerHTML = '<div class="text-red-500 text-center py-4">Error loading history: ' + error.message + '</div>';
                    });
            };

            window.displayHistory = function(loan) {
                const historyContent = document.getElementById('history_content');
                let html = '';

                // Helper function to format numbers
                const formatCurrency = (amount) => {
                    return parseFloat(amount).toFixed(2);
                };

                // Loan details
                html += `
                    <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                        <h4 class="font-semibold text-gray-900 mb-2">Loan Details</h4>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-gray-500">Recipient:</span>
                                <span class="font-medium ml-2">${loan.recipient_name}</span>
                            </div>
                            <div>
                                <span class="text-gray-500">Loan Date:</span>
                                <span class="font-medium ml-2">${loan.loan_date}</span>
                            </div>
                            <div>
                                <span class="text-gray-500">Loan Amount:</span>
                                <span class="font-medium ml-2 text-green-600">${formatCurrency(loan.amount)}</span>
                            </div>
                            <div>
                                <span class="text-gray-500">Repaid:</span>
                                <span class="font-medium ml-2 text-blue-600">${formatCurrency(loan.amount_repaid)}</span>
                            </div>
                            <div>
                                <span class="text-gray-500">Balance:</span>
                                <span class="font-medium ml-2 text-orange-600">${formatCurrency(loan.amount - loan.amount_repaid)}</span>
                            </div>
                            <div>
                                <span class="text-gray-500">Status:</span>
                                <span class="font-medium ml-2">${loan.payment_status_text}</span>
                            </div>
                        </div>
                    </div>
                `;

                // Repayment history
                html += '<h4 class="font-semibold text-gray-900 mb-3">Repayment History</h4>';

                if (loan.repayments && loan.repayments.length > 0) {
                    html += '<div class="space-y-3">';
                    loan.repayments.forEach(function(repayment) {
                        html += `
                            <div class="flex items-center justify-between p-3 border rounded-lg hover:bg-gray-50">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center">
                                        <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-900">Paid ${formatCurrency(repayment.amount)}</div>
                                        <div class="text-sm text-gray-500">${repayment.payment_date}</div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-sm font-medium text-gray-900">${repayment.payment_method}</div>
                                    ${repayment.transaction_reference ? `<div class="text-xs text-gray-500">Ref: ${repayment.transaction_reference}</div>` : ''}
                                    ${repayment.notes ? `<div class="text-xs text-gray-400 mt-1">${repayment.notes}</div>` : ''}
                                </div>
                            </div>
                        `;
                    });
                    html += '</div>';
                } else {
                    html += '<div class="text-center py-8 text-gray-500">No repayments yet</div>';
                }

                historyContent.innerHTML = html;
            };

            window.closeHistoryModal = function() {
                historyModal.classList.add('hidden');
            };

            // Close modals when clicking backdrop
            modal.addEventListener('click', function(event) {
                if (event.target === modal) {
                    closeRepayModal();
                }
            });

            historyModal.addEventListener('click', function(event) {
                if (event.target === historyModal) {
                    closeHistoryModal();
                }
            });
        });

        // Toggle recipient loans list
        window.toggleRecipientLoans = function(index) {
            const loansDiv = document.getElementById('recipient_loans_' + index);
            loansDiv.classList.toggle('hidden');
        };

        // Prefill recipient and redirect to create page
        window.prefillAndCreate = function(recipient) {
            // Store recipient data in sessionStorage
            sessionStorage.setItem('prefillRecipient', JSON.stringify(recipient));

            // Redirect to create page
            window.location.href = "{{ route('projects.loans.create', $project) }}";
        };
    </script>
</x-app-layout>
