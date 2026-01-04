<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Add Worker</h2>
                <p class="text-gray-500 mt-1">{{ $project->name }}</p>
            </div>
            <a href="{{ route('projects.workers.index', $project) }}" class="btn btn-ghost btn-sm gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Workers
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="card bg-white shadow-xl">
                <div class="card-body">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-cyan-500 to-blue-500 flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">New Worker</h3>
                            <p class="text-sm text-gray-500">Add a new worker to track attendance and wages</p>
                        </div>
                    </div>

                    <form action="{{ route('projects.workers.store', $project) }}" method="POST">
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
                            <!-- Name -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-semibold text-gray-900">Worker Name</span>
                                    <span class="label-text-alt text-error">*</span>
                                </label>
                                <div class="relative">
                                    <input type="text" name="name" value="{{ old('name') }}"
                                        placeholder="e.g., John Doe, Ahmed Khan"
                                        class="input input-bordered w-full" required />
                                    <div class="absolute right-3 top-1/2 -translate-y-1/2">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <label class="label">
                                    <span class="label-text-alt">Enter the worker's full name</span>
                                </label>
                            </div>

                            <!-- Phone & Email -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Phone -->
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text font-semibold text-gray-900">Phone Number</span>
                                        <span class="label-text-alt text-gray-400">(Optional)</span>
                                    </label>
                                    <div class="relative">
                                        <input type="text" name="phone" value="{{ old('phone') }}"
                                            placeholder="+1 234 567 8900"
                                            class="input input-bordered w-full" />
                                        <div class="absolute right-3 top-1/2 -translate-y-1/2">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text font-semibold text-gray-900">Email Address</span>
                                        <span class="label-text-alt text-gray-400">(Optional)</span>
                                    </label>
                                    <div class="relative">
                                        <input type="email" name="email" value="{{ old('email') }}"
                                            placeholder="worker@example.com"
                                            class="input input-bordered w-full" />
                                        <div class="absolute right-3 top-1/2 -translate-y-1/2">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Address -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-semibold text-gray-900">Address</span>
                                    <span class="label-text-alt text-gray-400">(Optional)</span>
                                </label>
                                <textarea name="address" rows="2"
                                    placeholder="Street address, city, state, postal code..."
                                    class="textarea textarea-bordered">{{ old('address') }}</textarea>
                                <label class="label">
                                    <span class="label-text-alt">Worker's residential address</span>
                                </label>
                            </div>

                            <!-- Labor Type & Category -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Labor Type -->
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text font-semibold text-gray-900">Labor Type</span>
                                        <span class="label-text-alt text-error">*</span>
                                    </label>
                                    <div class="relative">
                                        <select name="labor_type" class="select select-bordered w-full appearance-none" required>
                                            <option value="">Select type...</option>
                                            @foreach($laborTypes as $key => $label)
                                                <option value="{{ $key }}" {{ old('labor_type') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                            @endforeach
                                        </select>
                                        <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                <!-- Category -->
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text font-semibold text-gray-900">Category</span>
                                        <span class="label-text-alt text-gray-400">(Optional)</span>
                                    </label>
                                    <div class="relative">
                                        <select name="category" class="select select-bordered w-full appearance-none">
                                            <option value="">Select category...</option>
                                            @foreach($categories as $key => $label)
                                                <option value="{{ $key }}" {{ old('category') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                            @endforeach
                                        </select>
                                        <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Daily Wage -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-semibold text-gray-900">Daily Wage</span>
                                    <span class="label-text-alt text-error">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">
                                        <span class="text-sm">{{ $project->currency ?? '$' }}</span>
                                    </div>
                                    <input type="number" name="daily_wage" value="{{ old('daily_wage') }}" step="0.01"
                                        placeholder="0.00"
                                        class="input input-bordered w-full pl-8" required />
                                </div>
                                <label class="label">
                                    <span class="label-text-alt">Amount paid per day of work</span>
                                </label>
                            </div>

                            <!-- Primary Contractor -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-semibold text-gray-900">Primary Contractor</span>
                                    <span class="label-text-alt text-gray-400">(Optional)</span>
                                </label>
                                <div class="relative">
                                    <select name="primary_contractor_id" class="select select-bordered w-full appearance-none">
                                        <option value="">No contractor assigned</option>
                                        @foreach($contractors as $contractor)
                                            <option value="{{ $contractor->id }}" {{ old('primary_contractor_id') == $contractor->id ? 'selected' : '' }}>
                                                {{ $contractor->name ?? 'Contractor #' . $contractor->id }} - {{ ucfirst($contractor->category) }}
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
                                    <span class="label-text-alt">Assign this worker to a contractor for tracking</span>
                                </label>
                            </div>

                            <!-- Hire Date -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-semibold text-gray-900">Hire Date</span>
                                    <span class="label-text-alt text-gray-400">(Optional)</span>
                                </label>
                                <div class="relative">
                                    <input type="date" name="hire_date" value="{{ old('hire_date') }}"
                                        class="input input-bordered w-full" />
                                    <div class="absolute right-3 top-1/2 -translate-y-1/2">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <label class="label">
                                    <span class="label-text-alt">When was this worker hired?</span>
                                </label>
                            </div>

                            <!-- Notes -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-semibold text-gray-900">Additional Notes</span>
                                    <span class="label-text-alt text-gray-400">(Optional)</span>
                                </label>
                                <textarea name="notes" rows="3"
                                    placeholder="Skills, certifications, or other relevant information..."
                                    class="textarea textarea-bordered">{{ old('notes') }}</textarea>
                                <label class="label">
                                    <span class="label-text-alt">Add any additional information about the worker</span>
                                </label>
                            </div>

                            <!-- Worker Info -->
                            <div class="card bg-gradient-to-r from-cyan-50 to-blue-50 border border-cyan-200">
                                <div class="card-body p-4">
                                    <div class="flex items-center gap-3">
                                        <div class="h-10 w-10 rounded-lg bg-cyan-500 flex items-center justify-center">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-gray-900">Worker Tracking</h4>
                                            <p class="text-sm text-gray-600">Track attendance, calculate wages, and manage payments</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex justify-end gap-3 mt-8 pt-6 border-t">
                            <a href="{{ route('projects.workers.index', $project) }}" class="btn btn-ghost gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Add Worker
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
