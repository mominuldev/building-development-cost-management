<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Add New Contractor</h2>
                <p class="text-gray-500 mt-1">{{ $project->name }}</p>
            </div>
            <a href="{{ route('projects.labor-costs.index', $project) }}" class="btn btn-ghost btn-sm gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Contractors
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="card bg-white shadow-xl">
                <div class="card-body">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-500 flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">New Contractor</h3>
                            <p class="text-sm text-gray-500">Fill in the contractor details below</p>
                        </div>
                    </div>

                    <form action="{{ route('projects.labor-costs.store', $project) }}" method="POST">
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
                            <!-- Labor Type (Hidden - always contractor) -->
                            <input type="hidden" name="labor_type" value="contractor" />

                            <!-- Contractor Name -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-semibold text-gray-900">Contractor Name</span>
                                    <span class="label-text-alt text-error">*</span>
                                </label>
                                <div class="relative">
                                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                                        placeholder="e.g., ABC Construction Company, John Doe & Sons"
                                        class="input input-bordered w-full pl-10" required />
                                    <div class="absolute left-3 top-1/2 -translate-y-1/2">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                    </div>
                                </div>
                                <label class="label">
                                    <span class="label-text-alt">Enter the full name or company name</span>
                                </label>
                            </div>

                            <!-- Category -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-semibold text-gray-900">Category</span>
                                    <span class="label-text-alt text-error">*</span>
                                </label>
                                <div class="relative">
                                    <select name="category" id="category" class="select select-bordered w-full appearance-none" required>
                                        <option value="">Select a category...</option>
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
                                <label class="label">
                                    <span class="label-text-alt">Choose the type of work they specialize in</span>
                                </label>
                            </div>

                            <!-- Uniform Wage Option -->
                            <div class="card bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200">
                                <div class="card-body p-4">
                                    <label class="label cursor-pointer flex gap-4 p-0">
                                        <input type="checkbox" name="use_uniform_wage" class="checkbox checkbox-primary" id="use_uniform_wage" {{ old('use_uniform_wage') ? 'checked' : '' }} value="1">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2 mb-1">
                                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                                </svg>
                                                <span class="label-text font-bold text-gray-900 p-0">Use Uniform Daily Wage</span>
                                            </div>
                                            <p class="text-sm text-gray-600">
                                                Enable this to calculate worker earnings using their individual daily wage × days worked.
                                                Attendance-specific wages will be ignored.
                                            </p>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-semibold text-gray-900">Description <span class="text-gray-400 font-normal">(Optional)</span></span>
                                </label>
                                <textarea name="description" id="description" rows="3"
                                    placeholder="Brief description of the contractor's work..."
                                    class="textarea textarea-bordered">{{ old('description') }}</textarea>
                                <label class="label">
                                    <span class="label-text-alt">Describe the scope of work or contract details</span>
                                </label>
                            </div>

                            <!-- Notes -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-semibold text-gray-900">Notes <span class="text-gray-400 font-normal">(Optional)</span></span>
                                </label>
                                <textarea name="notes" id="notes" rows="3"
                                    placeholder="Any additional notes, terms, or special instructions..."
                                    class="textarea textarea-bordered">{{ old('notes') }}</textarea>
                                <label class="label">
                                    <span class="label-text-alt">Add any internal notes or reminders</span>
                                </label>
                            </div>

                            <!-- Info Alert -->
                            <div class="alert">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div>
                                    <h4 class="font-bold">Cost Calculation</h4>
                                    <div class="text-sm mt-1">
                                        <p>Costs will be calculated automatically based on assigned workers' attendance. After adding the contractor, you can assign workers to track their attendance and calculate total costs.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex justify-end gap-3 mt-8 pt-6 border-t">
                            <a href="{{ route('projects.labor-costs.index', $project) }}" class="btn btn-ghost gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Add Contractor
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
