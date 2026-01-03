<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Add Contractor - {{ $project->name }}
            </h2>
            <a href="{{ route('projects.labor-costs.index', $project) }}" class="text-sm text-gray-600 hover:text-gray-900">
                &larr; Back to Contractors
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h3 class="card-title mb-4">Add New Contractor</h3>

                    <form action="{{ route('projects.labor-costs.store', $project) }}" method="POST">
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
                            <!-- Labor Type (Hidden - always contractor) -->
                            <input type="hidden" name="labor_type" value="contractor" />

                            <!-- Contractor Name -->
                            <div class="form-control">
                                <label class="label flex items-end">
                                    <span class="label-text">Contractor Name</span>
                                    <span class="label-text-alt text-error">*</span>
                                </label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}"
                                    placeholder="e.g., ABC Construction Company, John Doe & Sons"
                                    class="input input-bordered" required />
                                <label class="label">
                                    <span class="label-text-alt">Name of the contractor or company</span>
                                </label>
                            </div>

                            <!-- Category -->
                            <div class="form-control">
                                <label class="label flex items-end">
                                    <span class="label-text">Category</span>
                                    <span class="label-text-alt text-error">*</span>
                                </label>
                                <select name="category" id="category" class="select select-bordered" required>
                                    <option value="">Select Category...</option>
                                    @foreach($categories as $key => $label)
                                        <option value="{{ $key }}" {{ old('category') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Uniform Wage Option -->
                            <div class="form-control">
                                <label class="label cursor-pointer justify-start gap-4">
                                    <input type="checkbox" name="use_uniform_wage" class="checkbox checkbox-primary" id="use_uniform_wage" {{ old('use_uniform_wage') ? 'checked' : '' }} value="1">
                                    <div>
                                        <span class="label-text font-bold">Use Uniform Daily Wage Calculation</span>
                                        <span class="label-text-alt">When enabled, worker earnings will be calculated using their individual daily wage × days worked. Attendance-specific wages will be ignored.</span>
                                    </div>
                                </label>
                            </div>

                            <!-- Description (Optional) -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">Description (Optional)</span>
                                </label>
                                <textarea name="description" id="description" rows="2"
                                    placeholder="Brief description of the contractor's work..."
                                    class="textarea textarea-bordered">{{ old('description') }}</textarea>
                            </div>

                            <!-- Notes (Optional) -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">Notes (Optional)</span>
                                </label>
                                <textarea name="notes" id="notes" rows="2"
                                    placeholder="Any additional notes..."
                                    class="textarea textarea-bordered">{{ old('notes') }}</textarea>
                            </div>

                            <!-- Info Card -->
                            <div class="alert alert-info">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div>
                                    <h4 class="font-bold">Cost Calculation</h4>
                                    <div class="text-xs mt-1">
                                        Costs will be calculated automatically based on assigned workers' attendance. After adding the contractor, assign workers to track their attendance and calculate total costs.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-actions justify-end mt-6">
                            <a href="{{ route('projects.labor-costs.index', $project) }}" class="btn btn-ghost">Cancel</a>
                            <button type="submit" class="btn btn-primary">Add Contractor</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
