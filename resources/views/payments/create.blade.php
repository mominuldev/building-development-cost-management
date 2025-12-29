<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Record Payment - {{ $project->name }}
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
                    <h3 class="card-title mb-4">Record New Payment</h3>

                    <form action="{{ route('projects.payments.store', $project) }}" method="POST">
                        @csrf

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

                        <div class="grid grid-cols-1 gap-4">
                            <!-- Recipient Type -->
                            <div class="form-control">
                                <label class="label flex items-end">
                                    <span class="label-text">Payment To</span>
                                    <span class="label-text-alt text-error">*</span>
                                </label>
                                <select name="recipient_type" id="recipient_type" class="select select-bordered" required onchange="updateRecipientOptions()">
                                    <option value="">Select Type...</option>
                                    <option value="contractor">Contractor</option>
                                    <option value="worker">Worker</option>
                                </select>
                            </div>

                            <!-- Recipient (Contractor) -->
                            <div class="form-control" id="contractor_group" style="display: none;">
                                <label class="label flex items-end">
                                    <span class="label-text">Select Contractor</span>
                                    <span class="label-text-alt text-error">*</span>
                                </label>
                                <select name="recipient_id" id="contractor_id" class="select select-bordered">
                                    <option value="">Select Contractor...</option>
                                    @foreach($contractors as $contractor)
                                        <option value="{{ $contractor->id }}" data-name="{{ $contractor->name ?? 'Contractor' }}">
                                            {{ $contractor->name ?? 'Contractor #' . $contractor->id }} - {{ number_format($contractor->daily_wage, 2) }}/day
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Recipient (Worker) -->
                            <div class="form-control" id="worker_group" style="display: none;">
                                <label class="label flex items-end">
                                    <span class="label-text">Select Worker</span>
                                    <span class="label-text-alt text-error">*</span>
                                </label>
                                <select name="recipient_id" id="worker_id" class="select select-bordered">
                                    <option value="">Select Worker...</option>
                                    @foreach($workers as $worker)
                                        <option value="{{ $worker->id }}" data-name="{{ $worker->name }}">
                                            {{ $worker->name }} - {{ ucfirst($worker->category) }} ({{ number_format($worker->daily_wage, 2) }}/day)
                                            @if($worker->amount_due > 0)
                                                - Due: {{ number_format($worker->amount_due, 2) }}
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                <label class="label">
                                    <span class="label-text-alt text-gray-500">Workers with unpaid wages are shown with due amounts</span>
                                </label>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <!-- Amount -->
                                <div class="form-control">
                                    <label class="label flex items-end">
                                        <span class="label-text">Amount</span>
                                        <span class="label-text-alt text-error">*</span>
                                    </label>
                                    <input type="number" name="amount" step="0.01" min="0"
                                        placeholder="Payment amount"
                                        class="input input-bordered" required />
                                </div>

                                <!-- Payment Date -->
                                <div class="form-control">
                                    <label class="label flex items-end">
                                        <span class="label-text">Payment Date</span>
                                        <span class="label-text-alt text-error">*</span>
                                    </label>
                                    <input type="date" name="payment_date" value="{{ today()->toDateString() }}"
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
                                            <option value="{{ $key }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Transaction Reference -->
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text">Transaction Reference</span>
                                    </label>
                                    <input type="text" name="transaction_reference"
                                        placeholder="Check number, transaction ID, etc."
                                        class="input input-bordered" />
                                </div>
                            </div>

                            <!-- Period Covered -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">Period Covered (Optional)</span>
                                    <span class="label-text-alt">Work period this payment covers</span>
                                </label>
                                <div class="flex gap-4">
                                    <div class="flex-1">
                                        <input type="date" name="period_start"
                                            placeholder="Start date"
                                            class="input input-bordered w-full" />
                                    </div>
                                    <div class="flex items-center">to</div>
                                    <div class="flex-1">
                                        <input type="date" name="period_end"
                                            placeholder="End date"
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
                                    class="textarea textarea-bordered"></textarea>
                            </div>
                        </div>

                        <div class="card-actions justify-end mt-6">
                            <a href="{{ route('projects.payments.index', $project) }}" class="btn btn-ghost">Cancel</a>
                            <button type="submit" class="btn btn-primary">Record Payment</button>
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
