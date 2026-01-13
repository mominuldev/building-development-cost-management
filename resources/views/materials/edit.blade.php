<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Edit Material</h2>
                <p class="text-gray-500 mt-1">{{ $project->name }}</p>
            </div>
            <a href="{{ route('projects.materials.index', $project) }}" class="btn btn-ghost btn-sm gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Materials
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Material Info Card -->
            <div class="card bg-gradient-to-r from-violet-500 to-purple-600 text-white shadow-xl">
                <div class="card-body p-6">
                    <div class="flex items-center gap-4">
                        <div class="h-16 w-16 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-2xl font-bold">{{ $material->name }}</h3>
                            <p class="text-white/80 mt-1">{{ ucfirst($material->material_type) }} - Purchased on {{ $material->purchase_date->format('M d, Y') }}</p>
                        </div>
                        <div class="text-right">
                            <div class="text-3xl font-bold">{{ $project->currency ?? '$' }}{{ number_format($material->total_cost, 2) }}</div>
                            <div class="text-sm text-white/80">Total Cost</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Form -->
            <div class="card bg-white shadow-xl">
                <div class="card-body">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-amber-500 to-orange-500 flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">Edit Material Details</h3>
                            <p class="text-sm text-gray-500">Update material information</p>
                        </div>
                    </div>

                    <form action="{{ route('projects.materials.update', [$project, $material]) }}" method="POST">
                        @csrf
                        @method('PUT')

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
                            <!-- Material Type & Name -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Material Type -->
                                <div class="form-control">
                                    <label class="label flex items-center">
                                        <span class="label-text font-semibold text-gray-900">Material Type</span>
                                        <span class="label-text-alt text-error">*</span>
                                    </label>
                                    <div class="relative">
                                        <select name="material_type" class="select select-bordered w-full appearance-none" required>
                                            <option value="">Select Type...</option>
                                            @foreach($materialTypes as $key => $label)
                                                <option value="{{ $key }}" {{ old('material_type', $material->material_type) == $key ? 'selected' : '' }}>{{ $label }}</option>
                                            @endforeach
                                        </select>
                                        <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                <!-- Material Name -->
                                <div class="form-control">
                                    <label class="label flex items-center">
                                        <span class="label-text font-semibold text-gray-900">Material Name</span>
                                        <span class="label-text-alt text-error">*</span>
                                    </label>
                                    <div class="relative">
                                        <input type="text" name="name" value="{{ old('name', $material->name) }}"
                                            placeholder="e.g., Red Bricks, Portland Cement, 12mm Steel Rod"
                                            class="input input-bordered w-full" required />
                                    </div>
                                    <label class="label">
                                        <span class="label-text-alt">Specific material description</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Quantity & Unit -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Quantity -->
                                <div class="form-control">
                                    <label class="label flex items-center">
                                        <span class="label-text font-semibold text-gray-900">Quantity</span>
                                        <span class="label-text-alt text-error">*</span>
                                    </label>
                                    <div class="relative">
                                        <input type="number" name="quantity" value="{{ old('quantity', $material->quantity) }}" step="0.01"
                                            placeholder="0.00"
                                            class="input input-bordered w-full" required />
                                        <div class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9l14 0M4 15h14a2 2 0 002-2V5a2 2 0 00-2-2H6a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                <!-- Unit -->
                                <div class="form-control">
                                    <label class="label flex items-center">
                                        <span class="label-text font-semibold text-gray-900">Unit</span>
                                        <span class="label-text-alt text-error">*</span>
                                    </label>
                                    <div class="relative">
                                        <select name="unit" class="select select-bordered w-full appearance-none" required>
                                            <option value="">Select Unit...</option>
                                            @foreach($units as $key => $label)
                                                <option value="{{ $key }}" {{ old('unit', $material->unit) == $key ? 'selected' : '' }}>{{ $label }}</option>
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

                            <!-- Unit Price with auto-calc hint -->
                            <div class="form-control">
                                <label class="label flex items-center">
                                    <span class="label-text font-semibold text-gray-900">Unit Price</span>
                                    <span class="label-text-alt text-error">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">
                                        <span class="text-sm">{{ $project->currency ?? '$' }}</span>
                                    </div>
                                    <input type="number" name="unit_price" value="{{ old('unit_price', $material->unit_price) }}" step="0.01"
                                        placeholder="0.00"
                                        class="input input-bordered w-full pl-8" required />
                                </div>
                                <label class="label">
                                    <span class="label-text-alt">Total cost will be automatically calculated (Quantity × Unit Price)</span>
                                </label>
                            </div>

                            <!-- Purchase Date & Supplier -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Purchase Date -->
                                <div class="form-control">
                                    <label class="label flex items-center">
                                        <span class="label-text font-semibold text-gray-900">Purchase Date</span>
                                        <span class="label-text-alt text-error">*</span>
                                    </label>
                                    <div class="relative">
                                        <input type="date" name="purchase_date" value="{{ old('purchase_date', $material->purchase_date->format('Y-m-d')) }}"
                                            class="input input-bordered w-full" required />
                                        <div class="absolute right-3 top-1/2 -translate-y-1/2">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                <!-- Supplier -->
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text font-semibold text-gray-900">Supplier <span class="text-gray-400 font-normal">(Optional)</span></span>
                                    </label>
                                    <div class="relative">
                                        <input type="text" name="supplier" value="{{ old('supplier', $material->supplier) }}"
                                            placeholder="Supplier name or company"
                                            class="input input-bordered w-full" />
                                        <div class="absolute right-3 top-1/2 -translate-y-1/2">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Notes -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-semibold text-gray-900">Notes <span class="text-gray-400 font-normal">(Optional)</span></span>
                                </label>
                                <textarea name="notes" rows="3"
                                    placeholder="Any additional details about this material..."
                                    class="textarea textarea-bordered">{{ old('notes', $material->notes) }}</textarea>
                                <label class="label">
                                    <span class="label-text-alt">Add specifications, quality notes, or other details</span>
                                </label>
                            </div>

                            <!-- Current Cost Preview -->
                            <div class="card bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200">
                                <div class="card-body p-4">
                                    <div class="flex items-center gap-3">
                                        <div class="h-10 w-10 rounded-lg bg-blue-500 flex items-center justify-center">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <h4 class="font-bold text-gray-900">Current Cost Calculation</h4>
                                            <p class="text-sm text-gray-600">
                                                {{ number_format($material->quantity, 2) }} {{ $material->unit }} × {{ $project->currency ?? '$' }}{{ number_format($material->unit_price, 2) }} = <strong>{{ $project->currency ?? '$' }}{{ number_format($material->total_cost, 2) }}</strong>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex justify-end gap-3 mt-8 pt-6 border-t">
                            <a href="{{ route('projects.materials.index', $project) }}" class="btn btn-ghost gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-warning gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                Update Material
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
