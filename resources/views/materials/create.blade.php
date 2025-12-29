<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Add Material - ') . $project->name }}
            </h2>
            <a href="{{ route('projects.materials.index', $project) }}" class="btn btn-sm btn-ghost">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Materials
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h3 class="card-title mb-4">Add New Material</h3>

                    <form action="{{ route('projects.materials.store', $project) }}" method="POST">
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
                            <!-- Material Type -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">Material Type</span>
                                    <span class="label-text-alt text-error">*</span>
                                </label>
                                <select name="material_type" class="select select-bordered" required>
                                    <option value="">Select Type...</option>
                                    @foreach($materialTypes as $key => $label)
                                        <option value="{{ $key }}" {{ old('material_type') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Material Name -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">Material Name</span>
                                    <span class="label-text-alt text-error">*</span>
                                </label>
                                <input type="text" name="name" value="{{ old('name') }}"
                                    placeholder="e.g., Red Bricks, Portland Cement, 12mm Steel Rod"
                                    class="input input-bordered" required />
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

                            <div class="grid grid-cols-2 gap-4">
                                <!-- Purchase Date -->
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text">Purchase Date</span>
                                        <span class="label-text-alt text-error">*</span>
                                    </label>
                                    <input type="date" name="purchase_date" value="{{ old('purchase_date') }}"
                                        class="input input-bordered" required />
                                </div>

                                <!-- Supplier -->
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text">Supplier</span>
                                    </label>
                                    <input type="text" name="supplier" value="{{ old('supplier') }}"
                                        placeholder="Supplier name or company"
                                        class="input input-bordered" />
                                </div>
                            </div>

                            <!-- Notes -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">Notes</span>
                                </label>
                                <textarea name="notes" rows="3"
                                    placeholder="Any additional details about this material..."
                                    class="textarea textarea-bordered">{{ old('notes') }}</textarea>
                            </div>
                        </div>

                        <div class="card-actions justify-end mt-6">
                            <a href="{{ route('projects.materials.index', $project) }}" class="btn btn-ghost">Cancel</a>
                            <button type="submit" class="btn btn-primary">Add Material</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
