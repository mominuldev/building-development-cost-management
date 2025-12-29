<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Edit Payment - {{ $project->name }}
            </h2>
            <a href="{{ route('projects.payments.index', $project) }}" class="btn btn-sm btn-ghost">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Payments
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h3 class="card-title mb-4">Edit Payment</h3>

                    <form action="{{ route('projects.payments.update', [$project, $payment]) }}" method="POST">
                        @csrf
                        @method('PUT')

                        @if ($errors->any())
                            <div class="alert alert-error mb-4">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div>
                                    <h4 class="font-bold">Error!</h4>
                                    <ul class="list-disc list-inside text-xs mt-1">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif

                        <div class="alert alert-info mb-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <h4 class="font-bold">Payment Information</h4>
                                <div class="text-xs mt-1">
                                    @if($payment->recipient_type == 'contractor')
                                        Recipient: <strong>Contractor</strong> (ID: {{ $payment->recipient_id }})
                                    @else
                                        Recipient: <strong>Worker</strong> (ID: {{ $payment->recipient_id }})
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-4">
                            <div class="grid grid-cols-2 gap-4">
                                <!-- Amount -->
                                <div class="form-control">
                                    <label class="label flex items-end">
                                        <span class="label-text">Amount</span>
                                        <span class="label-text-alt text-error">*</span>
                                    </label>
                                    <input type="number" name="amount" step="0.01" min="0" value="{{ $payment->amount }}"
                                        placeholder="Payment amount"
                                        class="input input-bordered" required />
                                </div>

                                <!-- Payment Date -->
                                <div class="form-control">
                                    <label class="label flex items-end">
                                        <span class="label-text">Payment Date</span>
                                        <span class="label-text-alt text-error">*</span>
                                    </label>
                                    <input type="date" name="payment_date" value="{{ $payment->payment_date->format('Y-m-d') }}"
                                        class="input input-bordered" required />
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <!-- Payment Method -->
                                <div class="form-control">
                                    <label class="label flex items-end">
                                        <span class="label-text">Payment Method</span>
                                        <span class="label-text-alt text-error">*</span>
                                    </label>
                                    <select name="payment_method" class="select select-bordered" required>
                                        @foreach($paymentMethods as $key => $label)
                                            <option value="{{ $key }}" {{ $payment->payment_method == $key ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Status -->
                                <div class="form-control">
                                    <label class="label flex items-end">
                                        <span class="label-text">Status</span>
                                        <span class="label-text-alt text-error">*</span>
                                    </label>
                                    <select name="status" class="select select-bordered" required>
                                        <option value="paid" {{ $payment->status == 'paid' ? 'selected' : '' }}>Paid</option>
                                        <option value="partial" {{ $payment->status == 'partial' ? 'selected' : '' }}>Partial</option>
                                        <option value="pending" {{ $payment->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="cancelled" {{ $payment->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Transaction Reference -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">Transaction Reference</span>
                                </label>
                                <input type="text" name="transaction_reference" value="{{ old('transaction_reference', $payment->transaction_reference) }}"
                                    placeholder="Check number, transaction ID, etc."
                                    class="input input-bordered" />
                            </div>

                            <!-- Period Covered -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">Period Covered (Optional)</span>
                                    <span class="label-text-alt">Work period this payment covers</span>
                                </label>
                                <div class="flex gap-4">
                                    <div class="flex-1">
                                        <label class="label">
                                            <span class="label-text-alt">Start Date</span>
                                        </label>
                                        <input type="date" name="period_start" value="{{ $payment->period_start?->format('Y-m-d') }}"
                                            class="input input-bordered w-full" />
                                    </div>
                                    <div class="flex items-center">to</div>
                                    <div class="flex-1">
                                        <label class="label">
                                            <span class="label-text-alt">End Date</span>
                                        </label>
                                        <input type="date" name="period_end" value="{{ $payment->period_end?->format('Y-m-d') }}"
                                            class="input input-bordered w-full" />
                                    </div>
                                </div>
                            </div>

                            <!-- Notes -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">Notes</span>
                                </label>
                                <textarea name="notes" rows="2"
                                    placeholder="Any additional notes..."
                                    class="textarea textarea-bordered">{{ old('notes', $payment->notes) }}</textarea>
                            </div>
                        </div>

                        <div class="card-actions justify-end mt-6">
                            <a href="{{ route('projects.payments.index', $project) }}" class="btn btn-ghost">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Payment</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
