<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Recipient Details</h2>
                <div class="flex items-center gap-2 mt-1">
                    <span class="text-gray-500">{{ $project->name }}</span>
                    <span class="text-gray-400">→</span>
                    <span class="text-gray-500">Loans</span>
                    <span class="text-gray-400">→</span>
                    <span class="badge badge-primary">{{ $recipient['name'] }}</span>
                </div>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('projects.loans.recipient.pdf', [$project, $recipient['name']]) }}" class="btn btn-error btn-sm gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Download PDF
                </a>
                <a href="{{ route('projects.loans.index', $project) }}" class="btn btn-ghost btn-sm gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Loans
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Recipient Header Card -->
            <div class="card bg-gradient-to-r from-purple-500 to-indigo-600 text-white shadow-xl">
                <div class="card-body p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-6">
                            <div class="h-20 w-20 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center">
                                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-3xl font-bold">{{ $recipient['name'] }}</h3>
                                @if($recipient['phone'])
                                    <p class="text-white/80 mt-1">{{ $recipient['phone'] }}</p>
                                @endif
                                @if($recipient['address'])
                                    <p class="text-white/70 text-sm">{{ $recipient['address'] }}</p>
                                @endif
                                @if($recipient['nid'])
                                    <p class="text-white/60 text-xs mt-1">NID: {{ $recipient['nid'] }}</p>
                                @endif
                            </div>
                        </div>
                        <a href="{{ route('projects.loans.create', $project) }}"
                           onclick="prefillRecipient({{ json_encode($recipient) }}); return false;"
                           class="btn btn-lg btn-success gap-2 shadow-lg hover:scale-105 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Give Another Loan
                        </a>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Total Loans -->
                <div class="card bg-white shadow-lg">
                    <div class="card-body p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500">Total Loans</p>
                                <p class="text-3xl font-bold text-purple-600">{{ $totalLoans }}</p>
                            </div>
                            <div class="h-12 w-12 rounded-xl bg-purple-100 flex items-center justify-center">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Given -->
                <div class="card bg-white shadow-lg">
                    <div class="card-body p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500">Total Given</p>
                                <p class="text-3xl font-bold text-blue-600">{{ number_format($totalGiven, 2) }}</p>
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
                <div class="card bg-white shadow-lg">
                    <div class="card-body p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500">Total Repaid</p>
                                <p class="text-3xl font-bold text-green-600">{{ number_format($totalRepaid, 2) }}</p>
                            </div>
                            <div class="h-12 w-12 rounded-xl bg-green-100 flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Outstanding -->
                <div class="card bg-white shadow-lg">
                    <div class="card-body p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500">Outstanding</p>
                                <p class="text-3xl font-bold {{ $outstanding > 0 ? 'text-orange-600' : 'text-green-600' }}">
                                    {{ number_format($outstanding, 2) }}
                                </p>
                            </div>
                            <div class="h-12 w-12 rounded-xl {{ $outstanding > 0 ? 'bg-orange-100' : 'bg-green-100' }} flex items-center justify-center">
                                <svg class="w-6 h-6 {{ $outstanding > 0 ? 'text-orange-600' : 'text-green-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6 2"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Loans List -->
            <div class="card bg-white shadow-xl">
                <div class="card-body">
                    <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        Loan History
                    </h3>

                    @if($loans->count() > 0)
                    <div class="space-y-4">
                        @foreach($loans as $loan)
                        <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition-shadow">
                            <!-- Loan Header -->
                            <div class="bg-gradient-to-r {{ $loan->status === 'paid' ? 'from-green-50 to-emerald-50' : ($loan->status === 'partial' ? 'from-yellow-50 to-amber-50' : 'from-gray-50 to-slate-50') }} p-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-4">
                                        <div class="h-12 w-12 rounded-full bg-white shadow flex items-center justify-center">
                                            <svg class="w-6 h-6 {{ $loan->status === 'paid' ? 'text-green-600' : ($loan->status === 'partial' ? 'text-yellow-600' : 'text-gray-600') }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="font-bold text-gray-900">
                                                Loan #{{ $loan->id }} - {{ $loan->loan_date->format('M d, Y') }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                Status: <span class="badge badge-{{ $loan->payment_status_color }} badge-sm">{{ $loan->payment_status_text }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-2xl font-bold text-gray-900">{{ number_format($loan->amount, 2) }}</div>
                                        <div class="text-xs text-gray-500">Loan Amount</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Loan Details -->
                            <div class="p-4 bg-white">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                                    <div>
                                        <p class="text-gray-500">Amount Repaid</p>
                                        <p class="font-bold text-green-600">{{ number_format($loan->amount_repaid, 2) }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-500">Balance</p>
                                        <p class="font-bold {{ $loan->remaining_balance > 0 ? 'text-orange-600' : 'text-green-600' }}">
                                            {{ number_format($loan->remaining_balance, 2) }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-gray-500">Payment Method</p>
                                        <p class="font-medium text-gray-900">{{ ucfirst($loan->payment_method) }}</p>
                                    </div>
                                </div>

                                @if($loan->notes)
                                <div class="mt-3 p-3 bg-gray-50 rounded text-sm">
                                    <p class="font-medium text-gray-700">Notes:</p>
                                    <p class="text-gray-600">{{ $loan->notes }}</p>
                                </div>
                                @endif

                                <!-- Repayments for this loan -->
                                @if($loan->repayments->count() > 0)
                                <div class="mt-4">
                                    <h5 class="text-sm font-semibold text-gray-700 mb-2">Repayment History</h5>
                                    <div class="space-y-2">
                                        @foreach($loan->repayments as $repayment)
                                        <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg border border-green-200">
                                            <div class="flex items-center gap-3">
                                                <div class="h-8 w-8 rounded-full bg-green-500 flex items-center justify-center">
                                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <div class="font-medium text-gray-900">Paid {{ number_format($repayment->amount, 2) }}</div>
                                                    <div class="text-xs text-gray-500">{{ $repayment->payment_date->format('M d, Y') }}</div>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <div class="text-sm font-medium text-gray-900">{{ ucfirst($repayment->payment_method) }}</div>
                                                @if($repayment->transaction_reference)
                                                    <div class="text-xs text-gray-500">Ref: {{ $repayment->transaction_reference }}</div>
                                                @endif
                                                @if($repayment->notes)
                                                    <div class="text-xs text-gray-400 mt-1">{{ $repayment->notes }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif

                                <!-- Actions -->
                                <div class="mt-4 pt-4 border-t border-gray-200 flex gap-2">
                                    @if($loan->status !== 'paid')
                                        <button type="button" onclick="repayModal({{ $loan->id }})" class="btn btn-sm btn-success gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Repay
                                        </button>
                                    @endif
                                    <button type="button" onclick="showHistoryModal({{ $loan->id }})" class="btn btn-sm btn-info gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        View History
                                    </button>
                                    <a href="{{ route('projects.loans.edit', [$project, $loan]) }}" class="btn btn-sm btn-ghost gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Edit
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-12 text-gray-500">
                        No loans found for this recipient.
                    </div>
                    @endif
                </div>
            </div>

            <!-- All Repayments Timeline -->
            @if($allRepayments->count() > 0)
            <div class="card bg-white shadow-xl">
                <div class="card-body">
                    <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Payment Timeline
                    </h3>
                    <div class="relative">
                        <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-gray-200"></div>
                        <div class="space-y-6">
                            @foreach($allRepayments as $repayment)
                            <div class="relative pl-10">
                                <div class="absolute left-0 w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <div class="font-bold text-gray-900">Paid {{ number_format($repayment->amount, 2) }}</div>
                                            <div class="text-sm text-gray-500">{{ $repayment->payment_date->format('F j, Y') }}</div>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-sm font-medium text-gray-900">{{ ucfirst($repayment->payment_method) }}</div>
                                            @if($repayment->transaction_reference)
                                                <div class="text-xs text-gray-500">Ref: {{ $repayment->transaction_reference }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    @if($repayment->notes)
                                        <div class="mt-2 text-sm text-gray-600">{{ $repayment->notes }}</div>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Repay Modal -->
    <div id="repay_modal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
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
            window.repayModal = function(loanId) {
                const form = document.getElementById('repayForm');
                const modal = document.getElementById('repay_modal');
                form.action = "/projects/{{ $project->id }}/loans/" + loanId + "/repay";
                modal.classList.remove('hidden');
            };

            window.closeRepayModal = function() {
                document.getElementById('repay_modal').classList.add('hidden');
            };

            // History modal functions
            window.showHistoryModal = function(loanId) {
                const historyContent = document.getElementById('history_content');
                const historyModal = document.getElementById('history_modal');
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
                document.getElementById('history_modal').classList.add('hidden');
            };

            // Close modals when clicking backdrop
            document.getElementById('repay_modal').addEventListener('click', function(event) {
                if (event.target === document.getElementById('repay_modal')) {
                    closeRepayModal();
                }
            });

            document.getElementById('history_modal').addEventListener('click', function(event) {
                if (event.target === document.getElementById('history_modal')) {
                    closeHistoryModal();
                }
            });
        });

        // Prefill recipient data and redirect to create page
        window.prefillRecipient = function(recipient) {
            // Store recipient data in sessionStorage
            sessionStorage.setItem('prefillRecipient', JSON.stringify(recipient));

            // Redirect to create page
            window.location.href = "{{ route('projects.loans.create', $project) }}";
        };
    </script>
</x-app-layout>
