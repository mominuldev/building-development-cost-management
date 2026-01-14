<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Give Loan</h2>
                <div class="flex items-center gap-2 mt-1">
                    <span class="text-gray-500">{{ $project->name }}</span>
                    <span class="text-gray-400">→</span>
                    <span class="badge badge-primary">New Loan</span>
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
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="card bg-white shadow-xl">
                <div class="card-body">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-green-500 to-emerald-500 flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">Give Loan</h3>
                            <p class="text-sm text-gray-500">Provide a loan to an external person</p>
                        </div>
                    </div>

                    <form action="{{ route('projects.loans.store', $project) }}" method="POST">
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
                            <!-- Existing Recipient Section -->
                            @if($recipients->count() > 0)
                            <div class="card bg-gradient-to-br from-amber-50 via-orange-50 to-yellow-50 border-2 border-amber-300 shadow-lg">
                                <div class="card-body p-5">
                                    <div class="flex items-center justify-between mb-4">
                                        <h4 class="font-bold text-gray-900 flex items-center gap-2">
                                            <div class="h-8 w-8 rounded-lg bg-amber-500 flex items-center justify-center">
                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                                </svg>
                                            </div>
                                            Existing Recipients
                                        </h4>
                                        <div class="badge badge-amber badge-lg">{{ $recipients->count() }} recipients</div>
                                    </div>

                                    <p class="text-sm text-gray-600 mb-4">Quickly select a previous recipient to give another loan</p>

                                    <!-- Search -->
                                    <div class="form-control mb-4">
                                        <div class="input-group">
                                            <input type="text" id="recipient_search" placeholder="Search recipients by name or phone..." class="input input-bordered flex-1" onkeyup="filterRecipients()">
                                            <span class="btn btn-square btn-ghost">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                                </svg>
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Recipient Cards Grid -->
                                    <div id="recipients_grid" class="grid grid-cols-1 md:grid-cols-2 gap-3 max-h-96 overflow-y-auto pr-2">
                                        @foreach($recipients as $recipient)
                                        <div class="recipient-card card bg-white border-2 border-amber-200 hover:border-amber-400 hover:shadow-md transition-all cursor-pointer recipient-card-{{ $loop->index }}"
                                            onclick="selectRecipient({{ $loop->index }})"
                                            data-name="{{ strtolower($recipient['name']) }}"
                                            data-phone="{{ strtolower($recipient['phone'] ?? '') }}">
                                            <div class="card-body p-4">
                                                <div class="flex items-start justify-between mb-2">
                                                    <div class="flex items-center gap-2 flex-1">
                                                        <div class="avatar placeholder">
                                                            <div class="bg-amber-100 text-amber-600 rounded-full w-10">
                                                                <span class="text-sm font-bold">{{ substr($recipient['name'], 0, 1) }}</span>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <h5 class="font-bold text-gray-900 text-sm">{{ $recipient['name'] }}</h5>
                                                            @if($recipient['phone'])
                                                                <p class="text-xs text-gray-500">{{ $recipient['phone'] }}</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="badge badge-{{ $recipient['outstanding'] > 0 ? 'error' : 'success' }} badge-sm">
                                                        {{ $recipient['total_loans'] }} loan{{ $recipient['total_loans'] != 1 ? 's' : '' }}
                                                    </div>
                                                </div>
                                                <div class="grid grid-cols-3 gap-2 text-center mt-2">
                                                    <div class="bg-blue-50 rounded p-2">
                                                        <p class="text-xs text-gray-500">Given</p>
                                                        <p class="font-bold text-blue-600 text-sm">{{ number_format($recipient['total_given'], 0) }}</p>
                                                    </div>
                                                    <div class="bg-green-50 rounded p-2">
                                                        <p class="text-xs text-gray-500">Repaid</p>
                                                        <p class="font-bold text-green-600 text-sm">{{ number_format($recipient['total_repaid'], 0) }}</p>
                                                    </div>
                                                    <div class="bg-{{ $recipient['outstanding'] > 0 ? 'orange' : 'green' }}-50 rounded p-2">
                                                        <p class="text-xs text-gray-500">Balance</p>
                                                        <p class="font-bold text-{{ $recipient['outstanding'] > 0 ? 'orange' : 'green' }}-600 text-sm">{{ number_format($recipient['outstanding'], 0) }}</p>
                                                    </div>
                                                </div>
                                                @if($recipient['outstanding'] > 0)
                                                <div class="alert alert-warning alert-xs mt-2 py-2">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                                    </svg>
                                                    <span class="text-xs">Outstanding: {{ number_format($recipient['outstanding'], 2) }}</span>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>

                                    <input type="hidden" id="existing_recipient" value="">
                                    <input type="hidden" id="selected_recipient_name" value="">
                                    <input type="hidden" id="selected_recipient_phone" value="">
                                    <input type="hidden" id="selected_recipient_address" value="">
                                    <input type="hidden" id="selected_recipient_nid" value="">
                                </div>
                            </div>
                            @endif

                            <!-- Recipient Section -->
                            <div class="card bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200">
                                <div class="card-body p-4">
                                    <h4 class="font-bold text-gray-900 mb-3 flex items-center gap-2">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        Loan Recipient Information
                                    </h4>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <!-- Recipient Name -->
                                        <div class="form-control">
                                            <label class="label">
                                                <span class="label-text font-semibold text-gray-900">Recipient Name</span>
                                                <span class="label-text-alt text-error">*</span>
                                            </label>
                                            <input type="text" name="recipient_name" placeholder="Full name"
                                                class="input input-bordered" required />
                                        </div>

                                        <!-- Recipient Phone -->
                                        <div class="form-control">
                                            <label class="label">
                                                <span class="label-text font-semibold text-gray-900">Phone Number</span>
                                                <span class="label-text-alt">(Optional)</span>
                                            </label>
                                            <input type="text" name="recipient_phone" placeholder="Contact number"
                                                class="input input-bordered" />
                                        </div>

                                        <!-- Recipient NID -->
                                        <div class="form-control">
                                            <label class="label">
                                                <span class="label-text font-semibold text-gray-900">National ID / ID Document</span>
                                                <span class="label-text-alt">(Optional)</span>
                                            </label>
                                            <input type="text" name="recipient_nid" placeholder="NID, Passport, etc."
                                                class="input input-bordered" />
                                        </div>

                                        <!-- Recipient Address -->
                                        <div class="form-control">
                                            <label class="label">
                                                <span class="label-text font-semibold text-gray-900">Address</span>
                                                <span class="label-text-alt">(Optional)</span>
                                            </label>
                                            <input type="text" name="recipient_address" placeholder="Full address"
                                                class="input input-bordered" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Loan Details -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Amount -->
                                <div class="form-control">
                                    <label class="label flex items-center">
                                        <span class="label-text font-semibold text-gray-900">Loan Amount</span>
                                        <span class="label-text-alt text-error">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">
                                            <span class="text-sm">{{ $project->currency ?? '$' }}</span>
                                        </div>
                                        <input type="number" name="amount" step="0.01" min="0.01" placeholder="0.00"
                                            class="input input-bordered w-full pl-8" required />
                                    </div>
                                    <label class="label">
                                        <span class="label-text-alt">Enter the loan amount</span>
                                    </label>
                                </div>

                                <!-- Loan Date -->
                                <div class="form-control">
                                    <label class="label flex items-center">
                                        <span class="label-text font-semibold text-gray-900">Loan Date</span>
                                        <span class="label-text-alt text-error">*</span>
                                    </label>
                                    <div class="relative">
                                        <input type="date" name="loan_date" value="{{ today()->format('Y-m-d') }}"
                                            class="input input-bordered w-full" required />
                                        <div class="absolute right-3 top-1/2 -translate-y-1/2">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Payment Details -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Payment Method -->
                                <div class="form-control">
                                    <label class="label flex items-center">
                                        <span class="label-text font-semibold text-gray-900">Payment Method</span>
                                        <span class="label-text-alt text-error">*</span>
                                    </label>
                                    <div class="relative">
                                        <select name="payment_method" class="select select-bordered appearance-none" required>
                                            <option value="cash">Cash</option>
                                            <option value="bank_transfer">Bank Transfer</option>
                                            <option value="check">Check</option>
                                            <option value="online">Online Payment</option>
                                        </select>
                                        <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                <!-- Due Date -->
                                <div class="form-control">
                                    <label class="label flex items-center">
                                        <span class="label-text font-semibold text-gray-900">Due Date</span>
                                        <span class="label-text-alt">(Optional)</span>
                                    </label>
                                    <div class="relative">
                                        <input type="date" name="due_date"
                                            class="input input-bordered w-full" />
                                        <div class="absolute right-3 top-1/2 -translate-y-1/2">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <label class="label">
                                        <span class="label-text-alt">When should the loan be repaid?</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Additional Fields -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Transaction Reference -->
                                <div class="form-control">
                                    <label class="label flex items-center">
                                        <span class="label-text font-semibold text-gray-900">Transaction Reference</span>
                                        <span class="label-text-alt">(Optional)</span>
                                    </label>
                                    <input type="text" name="transaction_reference"
                                        placeholder="Cheque number, reference ID, etc."
                                        class="input input-bordered" />
                                </div>

                                <!-- Interest Rate -->
                                <div class="form-control">
                                    <label class="label flex items-center">
                                        <span class="label-text font-semibold text-gray-900">Interest Rate (%)</span>
                                        <span class="label-text-alt">(Optional)</span>
                                    </label>
                                    <div class="relative">
                                        <input type="number" name="interest_rate" step="0.01" min="0" max="100" placeholder="0.00"
                                            class="input input-bordered w-full pr-8" />
                                        <div class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">%</div>
                                    </div>
                                    <label class="label">
                                        <span class="label-text-alt">If interest is applicable</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Notes -->
                            <div class="form-control">
                                <label class="label flex items-center">
                                    <span class="label-text font-semibold text-gray-900">Notes</span>
                                    <span class="label-text-alt">(Optional)</span>
                                </label>
                                <textarea name="notes" rows="3"
                                    placeholder="Any additional notes about this loan..."
                                    class="textarea textarea-bordered"></textarea>
                            </div>

                            <!-- Actions -->
                            <div class="flex justify-end gap-3 mt-8 pt-6 border-t">
                                <a href="{{ route('projects.loans.index', $project) }}" class="btn btn-ghost gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    Cancel
                                </a>
                                <button type="submit" class="btn btn-success gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Give Loan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Store recipient data
        const recipientsData = @json($recipients);

        // Filter recipients based on search
        function filterRecipients() {
            const searchTerm = document.getElementById('recipient_search').value.toLowerCase();
            const cards = document.querySelectorAll('.recipient-card');

            cards.forEach(card => {
                const name = card.getAttribute('data-name');
                const phone = card.getAttribute('data-phone');

                if (name.includes(searchTerm) || phone.includes(searchTerm)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        // Select a recipient
        function selectRecipient(index) {
            const recipient = recipientsData[index];

            // Remove previous selection
            document.querySelectorAll('.recipient-card').forEach(card => {
                card.classList.remove('ring-2', 'ring-amber-500', 'bg-amber-50');
                card.classList.add('bg-white');
            });

            // Highlight selected card
            const selectedCard = document.querySelector(`.recipient-card-${index}`);
            selectedCard.classList.remove('bg-white');
            selectedCard.classList.add('ring-2', 'ring-amber-500', 'bg-amber-50');

            // Store selected recipient
            document.getElementById('existing_recipient').value = index;
            document.getElementById('selected_recipient_name').value = recipient.name;
            document.getElementById('selected_recipient_phone').value = recipient.phone || '';
            document.getElementById('selected_recipient_address').value = recipient.address || '';
            document.getElementById('selected_recipient_nid').value = recipient.nid || '';

            // Fill in the form fields
            document.querySelector('input[name="recipient_name"]').value = recipient.name;
            document.querySelector('input[name="recipient_phone"]').value = recipient.phone || '';
            document.querySelector('input[name="recipient_address"]').value = recipient.address || '';
            document.querySelector('input[name="recipient_nid"]').value = recipient.nid || '';

            // Scroll to form
            document.querySelector('input[name="recipient_name"]').scrollIntoView({ behavior: 'smooth', block: 'center' });

            // Flash the form fields to indicate they've been filled
            const formFields = document.querySelectorAll('input[name="recipient_name"], input[name="recipient_phone"], input[name="recipient_address"], input[name="recipient_nid"]');
            formFields.forEach(field => {
                field.classList.add('input-success');
                setTimeout(() => {
                    field.classList.remove('input-success');
                }, 1000);
            });

            // Show notification
            showNotification(`Selected: ${recipient.name}. You can now review and edit their information before giving the loan.`);
        }

        // Show notification
        function showNotification(message) {
            // Remove existing notification
            const existing = document.querySelector('.recipient-notification');
            if (existing) {
                existing.remove();
            }

            // Create notification
            const notification = document.createElement('div');
            notification.className = 'recipient-notification alert alert-success fixed top-4 right-4 shadow-lg z-50 animate-bounce';
            notification.innerHTML = `
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>${message}</span>
            `;

            document.body.appendChild(notification);

            // Auto-remove after 3 seconds
            setTimeout(() => {
                notification.remove();
            }, 3000);
        }

        // Clear selection when form fields are manually edited
        document.addEventListener('DOMContentLoaded', function() {
            const formFields = ['recipient_name', 'recipient_phone', 'recipient_address', 'recipient_nid'];

            formFields.forEach(fieldName => {
                const field = document.querySelector(`input[name="${fieldName}"]`);
                if (field) {
                    field.addEventListener('input', function() {
                        // Remove card selection highlighting
                        document.querySelectorAll('.recipient-card').forEach(card => {
                            card.classList.remove('ring-2', 'ring-amber-500', 'bg-amber-50');
                            card.classList.add('bg-white');
                        });
                        document.getElementById('existing_recipient').value = '';
                    });
                }
            });

            // Check for pre-filled recipient data from "Give Another Loan" button
            const prefillData = sessionStorage.getItem('prefillRecipient');
            if (prefillData) {
                try {
                    const recipient = JSON.parse(prefillData);

                    // Fill in the form fields
                    document.querySelector('input[name="recipient_name"]').value = recipient.name || '';
                    document.querySelector('input[name="recipient_phone"]').value = recipient.phone || '';
                    document.querySelector('input[name="recipient_address"]').value = recipient.address || '';
                    document.querySelector('input[name="recipient_nid"]').value = recipient.nid || '';

                    // Flash the form fields to indicate they've been filled
                    const formFieldElements = document.querySelectorAll('input[name="recipient_name"], input[name="recipient_phone"], input[name="recipient_address"], input[name="recipient_nid"]');
                    formFieldElements.forEach(field => {
                        field.classList.add('input-success');
                        setTimeout(() => {
                            field.classList.remove('input-success');
                        }, 1500);
                    });

                    // Scroll to form
                    document.querySelector('input[name="recipient_name"]').scrollIntoView({ behavior: 'smooth', block: 'center' });

                    // Show notification
                    showNotification(`Quick loan for ${recipient.name}. Review the information and enter the loan amount.`);

                    // Clear the stored data
                    sessionStorage.removeItem('prefillRecipient');
                } catch (e) {
                    console.error('Error parsing prefill data:', e);
                }
            }
        });
    </script>
</x-app-layout>
