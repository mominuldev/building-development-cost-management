<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Add Worker - {{ $project->name }}
            </h2>
            <a href="{{ route('projects.workers.index', $project) }}" class="btn btn-sm btn-ghost">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Workers
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h3 class="card-title mb-4">Add New Worker</h3>

                    <form action="{{ route('projects.workers.store', $project) }}" method="POST">
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
                            <!-- Name -->
                            <div class="form-control">
                                <label class="label flex items-end">
                                    <span class="label-text">Name</span>
                                    <span class="label-text-alt text-error">*</span>
                                </label>
                                <input type="text" name="name" value="{{ old('name') }}"
                                    placeholder="Worker full name"
                                    class="input input-bordered" required />
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <!-- Phone -->
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text">Phone</span>
                                    </label>
                                    <input type="text" name="phone" value="{{ old('phone') }}"
                                        placeholder="Contact number"
                                        class="input input-bordered" />
                                </div>

                                <!-- Email -->
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text">Email</span>
                                    </label>
                                    <input type="email" name="email" value="{{ old('email') }}"
                                        placeholder="Email address"
                                        class="input input-bordered" />
                                </div>
                            </div>

                            <!-- Address -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">Address</span>
                                </label>
                                <textarea name="address" rows="2"
                                    placeholder="Worker address"
                                    class="textarea textarea-bordered">{{ old('address') }}</textarea>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <!-- Labor Type -->
                                <div class="form-control">
                                    <label class="label flex items-end">
                                        <span class="label-text">Labor Type</span>
                                        <span class="label-text-alt text-error">*</span>
                                    </label>
                                    <select name="labor_type" class="select select-bordered" required>
                                        <option value="">Select Type...</option>
                                        @foreach($laborTypes as $key => $label)
                                            <option value="{{ $key }}" {{ old('labor_type') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Category -->
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text">Category</span>
                                    </label>
                                    <select name="category" class="select select-bordered">
                                        <option value="">Select Category...</option>
                                        @foreach($categories as $key => $label)
                                            <option value="{{ $key }}" {{ old('category') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Daily Wage -->
                            <div class="form-control">
                                <label class="label flex items-end">
                                    <span class="label-text">Daily Wage</span>
                                    <span class="label-text-alt text-error">*</span>
                                </label>
                                <input type="number" name="daily_wage" value="{{ old('daily_wage') }}" step="0.01"
                                    placeholder="Daily wage amount"
                                    class="input input-bordered" required />
                            </div>

                            <!-- Primary Contractor -->
                            <div class="form-control">
                                <label class="label flex items-end">
                                    <span class="label-text">Primary Contractor (Optional)</span>
                                    <span class="label-text-alt">Assign this worker to a contractor</span>
                                </label>
                                <select name="primary_contractor_id" class="select select-bordered">
                                    <option value="">No Contractor</option>
                                    @foreach($contractors as $contractor)
                                        <option value="{{ $contractor->id }}" {{ old('primary_contractor_id') == $contractor->id ? 'selected' : '' }}>
                                            {{ $contractor->name ?? 'Contractor #' . $contractor->id }} - {{ ucfirst($contractor->category) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Hire Date -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">Hire Date</span>
                                </label>
                                <input type="date" name="hire_date" value="{{ old('hire_date') }}"
                                    class="input input-bordered" />
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
                            <a href="{{ route('projects.workers.index', $project) }}" class="btn btn-ghost">Cancel</a>
                            <button type="submit" class="btn btn-primary">Add Worker</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
