<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Record Payment</h2>
                <p class="text-gray-500 mt-1">{{ $project->name }}</p>
            </div>
            <a href="{{ route('projects.payments.index', $project) }}" class="btn btn-ghost btn-sm gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Payments
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="card bg-white shadow-xl">
                <div class="card-body">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-500 flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">New Payment Record</h3>
                            <p class="text-sm text-gray-500">Record payment to contractors or workers</p>
                        </div>
                    </div>

                    <form action="{{ route('projects.payments.store', $project) }}" method="POST">
                        @csrf

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
                            <!-- Payment To Selection -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-semibold text-gray-900">Payment To</span>
                                    <span class="label-text-alt text-error">*</span>
                                </label>
                                <div class="relative">
                                    <select name="recipient_type" id="recipient_type" class="select select-bordered w-full appearance-none" required onchange="updateRecipientOptions()">
                                        <option value="">Select recipient type...</option>
                                        <option value="contractor">Contractor</option>
                                        <option value="worker">Worker</option>
                                    </select>
                                    <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                                <label class="label">
                                    <span class="label-text-alt">Choose whether you're paying a contractor or individual worker</span>
                                </label>
                            </div>

                            <!-- Recipient (Contractor) -->
                            <div class="form-control" id="contractor_group" style="display: none;">
                                <label class="label">
                                    <span class="label-text font-semibold text-gray-900">Select Contractor</span>
                                    <span class="label-text-alt text-error">*</span>
                                </label>
                                <div class="relative">
                                    <select name="recipient_id" id="contractor_id" class="select select-bordered w-full appearance-none">
                                        <option value="">Choose contractor...</option>
                                        @foreach($contractors as $contractor)
                                            <option value="{{ $contractor->id }}" data-name="{{ $contractor->name ?? 'Contractor' }}">
                                                {{ $contractor->name ?? 'Contractor #' . $contractor->id }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Recipient (Worker) -->
                            <div class="form-control" id="worker_group" style="display: none;">
                                <label class="label">
                                    <span class="label-text font-semibold text-gray-900">Select Worker</span>
                                    <span class="label-text-alt text-error">*</span>
                                </label>
                                <div class="relative">
                                    <select name="recipient_id" id="worker_id" class="select select-bordered w-full appearance-none">
                                        <option value="">Choose worker...</option>
                                        @foreach($workers as $worker)
                                            <option value="{{ $worker->id }}" data-name="{{ $worker->name }}">
                                                {{ $worker->name }} - {{ ucfirst($worker->category) }} ({{ number_format($worker->daily_wage, 2) }}/day)
                                                @if($worker->amount_due > 0)
                                                    - Due: {{ number_format($worker->amount_due, 2) }}
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                                <label class="label">
                                    <span class="label-text-alt text-warning">Workers with unpaid wages are shown with due amounts</span>
                                </label>
                            </div>

                            <!-- Amount & Payment Date -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Amount -->
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text font-semibold text-gray-900">Amount</span>
                                        <span class="label-text-alt text-error">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">
                                            <span class="text-sm">{{ $project->currency ?? '$' }}</span>
                                        </div>
                                        <input type="number" name="amount" step="0.01" min="0"
                                            placeholder="0.00"
                                            class="input input-bordered w-full pl-8" required />
                                    </div>
                                </div>

                                <!-- Payment Date -->
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text font-semibold text-gray-900">Payment Date</span>
                                        <span class="label-text-alt text-error">*</span>
                                    </label>
                                    <div class="relative">
                                        <input type="date" name="payment_date" value="{{ today()->toDateString() }}"
                                            class="input input-bordered w-full" required />
                                        <div class="absolute right-3 top-1/2 -translate-y-1/2">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Payment Method & Reference -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Payment Method -->
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text font-semibold text-gray-900">Payment Method</span>
                                        <span class="label-text-alt text-error">*</span>
                                    </label>
                                    <div class="relative">
                                        <select name="payment_method" class="select select-bordered w-full appearance-none" required>
                                            <option value="">Select method...</option>
                                            @foreach($paymentMethods as $key => $label)
                                                <option value="{{ $key }}">{{ $label }}</option>
                                            @endforeach
                                        </select>
                                        <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                <!-- Transaction Reference -->
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text font-semibold text-gray-900">Transaction Reference</span>
                                        <span class="label-text-alt text-gray-400">(Optional)</span>
                                    </label>
                                    <div class="relative">
                                        <input type="text" name="transaction_reference"
                                            placeholder="Check number, transaction ID, etc."
                                            class="input input-bordered w-full" />
                                        <div class="absolute right-3 top-1/2 -translate-y-1/2">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Period Covered -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-semibold text-gray-900">Period Covered</span>
                                    <span class="label-text-alt text-gray-400">(Optional)</span>
                                </label>
                                <div class="flex gap-3 items-center">
                                    <div class="flex-1">
                                        <div class="relative">
                                            <input type="date" name="period_start"
                                                placeholder="Start date"
                                                class="input input-bordered w-full" />
                                            <div class="absolute right-3 top-1/2 -translate-y-1/2">
                                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center text-gray-500 font-semibold">to</div>
                                    <div class="flex-1">
                                        <div class="relative">
                                            <input type="date" name="period_end"
                                                placeholder="End date"
                                                class="input input-bordered w-full" />
                                            <div class="absolute right-3 top-1/2 -translate-y-1/2">
                                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <label class="label">
                                    <span class="label-text-alt">Specify the work period this payment covers</span>
                                </label>
                            </div>

                            <!-- Notes -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-semibold text-gray-900">Notes</span>
                                    <span class="label-text-alt text-gray-400">(Optional)</span>
                                </label>
                                <textarea name="notes" rows="3"
                                    placeholder="Any additional notes about this payment..."
                                    class="textarea textarea-bordered"></textarea>
                                <label class="label">
                                    <span class="label-text-alt">Add payment details, terms, or other information</span>
                                </label>
                            </div>

                            <!-- Payment Info -->
                            <div class="card bg-gradient-to-r from-emerald-50 to-teal-50 border border-emerald-200">
                                <div class="card-body p-4">
                                    <div class="flex items-center gap-3">
                                        <div class="h-10 w-10 rounded-lg bg-emerald-500 flex items-center justify-center">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-gray-900">Payment Tracking</h4>
                                            <p class="text-sm text-gray-600">All payments are recorded and tracked for accounting purposes</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex justify-end gap-3 mt-8 pt-6 border-t">
                            <a href="{{ route('projects.payments.index', $project) }}" class="btn btn-ghost gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Record Payment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateRecipientOptions() {
            const recipientType = document.getElementById('recipient_type').value;
            const contractorGroup = document.getElementById('contractor_group');
            const workerGroup = document.getElementById('worker_group');
            const contractorId = document.getElementById('contractor_id');
            const workerId = document.getElementById('worker_id');

            // Hide both groups first
            contractorGroup.style.display = 'none';
            workerGroup.style.display = 'none';

            // Disable and remove required from both
            contractorId.disabled = true;
            workerId.disabled = true;
            contractorId.removeAttribute('required');
            workerId.removeAttribute('required');

            // Show relevant group
            if (recipientType === 'contractor') {
                contractorGroup.style.display = 'block';
                contractorId.disabled = false;
                contractorId.setAttribute('required', 'required');
            } else if (recipientType === 'worker') {
                workerGroup.style.display = 'block';
                workerId.disabled = false;
                workerId.setAttribute('required', 'required');
            }
        }
    </script>
</x-app-layout>
