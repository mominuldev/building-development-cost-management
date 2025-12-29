<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Add Finishing Work - ') . $project->name }}
            </h2>
            <a href="{{ route('projects.finishing-works.index', $project) }}" class="btn btn-sm btn-ghost">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Finishing Works
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h3 class="card-title mb-4">Add New Finishing Work</h3>

                    <form action="{{ route('projects.finishing-works.store', $project) }}" method="POST">
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
                            <!-- Work Type -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">Work Type</span>
                                    <span class="label-text-alt text-error">*</span>
                                </label>
                                <select name="work_type" class="select select-bordered" required>
                                    <option value="">Select Type...</option>
                                    @foreach($workTypes as $key => $label)
                                        <option value="{{ $key }}" {{ old('work_type') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Name -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">Name</span>
                                    <span class="label-text-alt text-error">*</span>
                                </label>
                                <input type="text" name="name" value="{{ old('name') }}"
                                    placeholder="e.g., Marble flooring, Wall painting, Bathroom fixtures"
                                    class="input input-bordered" required />
                            </div>

                            <!-- Description -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">Description</span>
                                </label>
                                <textarea name="description" rows="2"
                                    placeholder="Brief description of the finishing work..."
                                    class="textarea textarea-bordered">{{ old('description') }}</textarea>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <!-- Quantity -->
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text">Quantity</span>
                                        <span class="label-text-alt text-error">*</span>
                                    </label>
                                    <input type="number" name="quantity" value="{{ old('quantity') }}" step="0.01"
                                        class="input input-bordered" required />
                                </div>

                                <!-- Unit -->
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text">Unit</span>
                                        <span class="label-text-alt text-error">*</span>
                                    </label>
                                    <select name="unit" class="select select-bordered" required>
                                        <option value="">Select Unit...</option>
                                        @foreach($units as $key => $label)
                                            <option value="{{ $key }}" {{ old('unit') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Unit Price -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">Unit Price</span>
                                    <span class="label-text-alt text-error">*</span>
                                </label>
                                <input type="number" name="unit_price" value="{{ old('unit_price') }}" step="0.01"
                                    class="input input-bordered" required />
                                <label class="label">
                                    <span class="label-text-alt">Total cost will be automatically calculated (Quantity × Unit Price)</span>
                                </label>
                            </div>

                            <!-- Work Date -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">Work Date</span>
                                    <span class="label-text-alt text-error">*</span>
                                </label>
                                <input type="date" name="work_date" value="{{ old('work_date') }}"
                                    class="input input-bordered" required />
                            </div>

                            <!-- Notes -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">Notes</span>
                                </label>
                                <textarea name="notes" rows="2"
                                    placeholder="Any additional notes..."
                                    class="textarea textarea-bordered">{{ old('notes') }}</textarea>
                            </div>
                        </div>

                        <div class="card-actions justify-end mt-6">
                            <a href="{{ route('projects.finishing-works.index', $project) }}" class="btn btn-ghost">Cancel</a>
                            <button type="submit" class="btn btn-secondary">Add Finishing Work</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
