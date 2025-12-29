<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Edit Structure Cost') }}
            </h2>
            <a href="{{ route('projects.structure-costs.index', $project) }}" class="btn btn-sm btn-ghost">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Structure Costs
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h3 class="card-title mb-4">Edit Structure Cost</h3>

                    <form action="{{ route('projects.structure-costs.update', [$project, $structureCost]) }}" method="POST">
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

                        <div class="grid grid-cols-1 gap-4">
                            <!-- Structure Type -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">Structure Type</span>
                                    <span class="label-text-alt text-error">*</span>
                                </label>
                                <select name="structure_type" class="select select-bordered" required>
                                    <option value="">Select Type...</option>
                                    @foreach($structureTypes as $key => $label)
                                        <option value="{{ $key }}" {{ old('structure_type', $structureCost->structure_type) == $key ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Name -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">Name</span>
                                    <span class="label-text-alt text-error">*</span>
                                </label>
                                <input type="text" name="name" value="{{ old('name', $structureCost->name) }}"
                                    placeholder="e.g., Foundation excavation, Ground floor columns, RCC roof"
                                    class="input input-bordered" required />
                            </div>

                            <!-- Description -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">Description</span>
                                </label>
                                <textarea name="description" rows="2"
                                    placeholder="Brief description of the structural work..."
                                    class="textarea textarea-bordered">{{ old('description', $structureCost->description) }}</textarea>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <!-- Quantity -->
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text">Quantity</span>
                                        <span class="label-text-alt text-error">*</span>
                                    </label>
                                    <input type="number" name="quantity" value="{{ old('quantity', $structureCost->quantity) }}" step="0.01"
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
                                            <option value="{{ $key }}" {{ old('unit', $structureCost->unit) == $key ? 'selected' : '' }}>{{ $label }}</option>
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
                                <input type="number" name="unit_price" value="{{ old('unit_price', $structureCost->unit_price) }}" step="0.01"
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
                                <input type="date" name="work_date" value="{{ old('work_date', $structureCost->work_date->format('Y-m-d')) }}"
                                    class="input input-bordered" required />
                            </div>

                            <!-- Notes -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">Notes</span>
                                </label>
                                <textarea name="notes" rows="2"
                                    placeholder="Any additional notes..."
                                    class="textarea textarea-bordered">{{ old('notes', $structureCost->notes) }}</textarea>
                            </div>
                        </div>

                        <div class="card-actions justify-end mt-6">
                            <a href="{{ route('projects.structure-costs.index', $project) }}" class="btn btn-ghost">Cancel</a>
                            <button type="submit" class="btn btn-warning">Update Structure Cost</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
