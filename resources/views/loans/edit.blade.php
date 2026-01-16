<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Edit Loan</h2>
                <div class="flex items-center gap-2 mt-1">
                    <span class="text-gray-500">{{ $project->name }}</span>
                    <span class="text-gray-400">→</span>
                    <span class="badge badge-primary">Edit</span>
                </div>
            </div>
            <a href="{{ route('projects.loans.index', $project) }}" class="btn btn-ghost btn-sm gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Loans
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Loan Info Card -->
            <div class="card bg-gradient-to-r from-green-500 to-emerald-500 text-white shadow-xl">
                <div class="card-body p-6">
                    <div class="flex items-center gap-4">
                        <div class="h-16 w-16 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-2xl font-bold">{{ $loan->recipient_name }}</h3>
                                    @if($loan->recipient_phone)
                                        <div class="text-white/80 mt-1">{{ $loan->recipient_phone }}</div>
                                    @endif
                                    @if($loan->recipient_nid)
                                        <div class="text-white/70 text-sm">NID: {{ $loan->recipient_nid }}</div>
                                    @endif
                                </div>
                                <div class="text-right">
                                    <div class="text-3xl font-bold">{{ number_format($loan->amount, 2) }}</div>
                                    <div class="text-sm text-white/80">Loan Amount</div>
                                </div>
                            </div>
                            <div class="mt-4 grid grid-cols-3 gap-4">
                                <div>
                                    <div class="text-sm text-white/80">Repaid</div>
                                    <div class="text-lg font-bold">{{ number_format($loan->amount_repaid, 2) }}</div>
                                </div>
                                <div>
                                    <div class="text-sm text-white/80">Balance</div>
                                    <div class="text-lg font-bold">{{ number_format($loan->remaining_balance, 2) }}</div>
                                </div>
                                <div>
                                    <div class="text-sm text-white/80">Status</div>
                                    <div class="text-lg font-bold">{{ $loan->payment_status_text }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Form -->
            <div class="card bg-white shadow-xl">
                <div class="card-body">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-amber-500 to-orange-500 flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">Edit Loan Details</h3>
                            <p class="text-sm text-gray-500">Update loan information</p>
                        </div>
                    </div>

                    <form action="{{ route('projects.loans.update', [$project, $loan]) }}" method="POST">
                        @csrf
                        @method('PUT')

                        @if ($errors->any())
                            <div class="alert alert-error mb-6">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div>
                                    <h4 class="font-bold">Please fix the following errors:</h4>
                                    <ul class="list-disc list-inside text-sm mt-2 space-y-1">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif

                        <div class="space-y-6">
                            <!-- Recipient Information -->
                            <div class="card bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200">
                                <div class="card-body p-4">
                                    <h4 class="font-bold text-gray-900 mb-3">Recipient Information</h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div class="form-control">
                                            <label class="labe flex items-centerl">
                                                <span class="label-text font-semibold text-gray-900">Name</span>
                                                <span class="label-text-alt text-error">*</span>
                                            </label>
                                            <input type="text" name="recipient_name" value="{{ old('recipient_name', $loan->recipient_name) }}"
                                                class="input input-bordered" required />
                                        </div>
                                        <div class="form-control">
                                            <label class="label flex items-center">
                                                <span class="label-text font-semibold text-gray-900">Phone</span>
                                                <span class="label-text-alt">(Optional)</span>
                                            </label>
                                            <input type="text" name="recipient_phone" value="{{ old('recipient_phone', $loan->recipient_phone) }}"
                                                class="input input-bordered" />
                                        </div>
                                        <div class="form-control">
                                            <label class="label flex items-center">
                                                <span class="label-text font-semibold text-gray-900">National ID</span>
                                                <span class="label-text-alt">(Optional)</span>
                                            </label>
                                            <input type="text" name="recipient_nid" value="{{ old('recipient_nid', $loan->recipient_nid) }}"
                                                class="input input-bordered" />
                                        </div>
                                        <div class="form-control">
                                            <label class="label flex items-center">
                                                <span class="label-text font-semibold text-gray-900">Address</span>
                                                <span class="label-text-alt">(Optional)</span>
                                            </label>
                                            <input type="text" name="recipient_address" value="{{ old('recipient_address', $loan->recipient_address) }}"
                                                class="input input-bordered" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Loan Amount & Date -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="form-control">
                                    <label class="label flex items-center">
                                        <span class="label-text font-semibold text-gray-900">Loan Amount</span>
                                        <span class="label-text-alt text-error">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">
                                            <span class="text-sm">{{ $project->currency ?? '$' }}</span>
                                        </div>
                                        <input type="number" name="amount" step="0.01" min="0.01" value="{{ old('amount', $loan->amount) }}" placeholder="0.00"
                                            class="input input-bordered w-full pl-8" required />
                                    </div>
                                </div>
                                <div class="form-control">
                                    <label class="label flex items-center">
                                        <span class="label-text font-semibold text-gray-900">Loan Date</span>
                                        <span class="label-text-alt text-error">*</span>
                                    </label>
                                    <input type="date" name="loan_date" value="{{ old('loan_date', $loan->loan_date->format('Y-m-d')) }}"
                                        class="input input-bordered w-full" required />
                                </div>
                            </div>

                            <!-- Payment Details -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="form-control">
                                    <label class="label flex items-center">
                                        <span class="label-text font-semibold text-gray-900">Payment Method</span>
                                        <span class="label-text-alt text-error">*</span>
                                    </label>
                                    <select name="payment_method" class="select select-bordered" required>
                                        <option value="cash" {{ old('payment_method', $loan->payment_method) == 'cash' ? 'selected' : '' }}>Cash</option>
                                        <option value="bank_transfer" {{ old('payment_method', $loan->payment_method) == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                        <option value="check" {{ old('payment_method', $loan->payment_method) == 'check' ? 'selected' : '' }}>Check</option>
                                        <option value="online" {{ old('payment_method', $loan->payment_method) == 'online' ? 'selected' : '' }}>Online Payment</option>
                                    </select>
                                </div>
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text font-semibold text-gray-900">Due Date</span>
                                        <span class="label-text-alt">(Optional)</span>
                                    </label>
                                    <input type="date" name="due_date" value="{{ old('due_date', $loan->due_date?->format('Y-m-d')) }}"
                                        class="input input-bordered w-full" />
                                </div>
                            </div>

                            <!-- Additional Fields -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="form-control">
                                    <label class="label flex items-center">
                                        <span class="label-text font-semibold text-gray-900">Transaction Reference</span>
                                        <span class="label-text-alt">(Optional)</span>
                                    </label>
                                    <input type="text" name="transaction_reference" value="{{ old('transaction_reference', $loan->transaction_reference) }}"
                                        placeholder="Cheque number, reference ID, etc."
                                        class="input input-bordered" />
                                </div>
                                <div class="form-control">
                                    <label class="label flex items-center">
                                        <span class="label-text font-semibold text-gray-900">Interest Rate (%)</span>
                                        <span class="label-text-alt">(Optional)</span>
                                    </label>
                                    <div class="relative">
                                        <input type="number" name="interest_rate" step="0.01" min="0" max="100" placeholder="0.00"
                                            value="{{ old('interest_rate', $loan->interest_rate) }}"
                                            class="input input-bordered w-full pr-8" />
                                        <div class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">%</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Notes -->
                            <div class="form-control">
                                <label class="label flex items-center">
                                    <span class="label-text font-semibold text-gray-900">Notes</span>
                                    <span class="label-text-alt">(Optional)</span>
                                </label>
                                <textarea name="notes" rows="3" class="textarea textarea-bordered"
                                    placeholder="Any additional notes about this loan...">{{ old('notes', $loan->notes) }}</textarea>
                            </div>

                            <!-- Warning Message -->
                            <div class="alert alert-warning">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                                <div>
                                    <h4 class="font-bold">Important Note</h4>
                                    <p class="text-sm">You can only edit the loan details. To record repayments, use the "Repay" button in the loans list.</p>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex justify-end gap-3 mt-8 pt-6 border-t">
                                <a href="{{ route('projects.loans.index', $project) }}" class="btn btn-ghost gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    Cancel
                                </a>
                                <button type="submit" class="btn btn-warning gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                    Update Loan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
