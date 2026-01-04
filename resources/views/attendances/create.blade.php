<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Record Attendance</h2>
                <p class="text-gray-500 mt-1">{{ $project->name }}</p>
            </div>
            <a href="{{ route('projects.attendances.index', $project) }}" class="btn btn-ghost btn-sm gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Attendance
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">New Attendance Record</h3>
                            <p class="text-sm text-gray-500">Track worker attendance and calculate wages</p>
                        </div>
                    </div>

                    <form action="{{ route('projects.attendances.store', $project) }}" method="POST">
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
                            <!-- Worker & Date -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Worker Selection -->
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text font-semibold text-gray-900">Select Worker</span>
                                        <span class="label-text-alt text-error">*</span>
                                    </label>
                                    <div class="relative">
                                        <select name="worker_id" class="select select-bordered w-full appearance-none" required>
                                            <option value="">Choose worker...</option>
                                            @foreach($workers as $worker)
                                                <option value="{{ $worker->id }}" {{ old('worker_id', $workerId) == $worker->id ? 'selected' : '' }}>
                                                    {{ $worker->name }} ({{ ucfirst($worker->category) ?? 'N/A' }}) - {{ number_format($worker->daily_wage, 2) }}/day
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
                                        <span class="label-text-alt">Daily wage will be used for calculation</span>
                                    </label>
                                </div>

                                <!-- Attendance Date -->
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text font-semibold text-gray-900">Attendance Date</span>
                                        <span class="label-text-alt text-error">*</span>
                                    </label>
                                    <div class="relative">
                                        <input type="date" name="attendance_date" value="{{ old('attendance_date', $date) }}"
                                            class="input input-bordered w-full" required />
                                        <div class="absolute right-3 top-1/2 -translate-y-1/2">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Attendance Status -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-semibold text-gray-900">Attendance Status</span>
                                    <span class="label-text-alt text-error">*</span>
                                </label>
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                    <label class="cursor-pointer">
                                        <input type="radio" name="status" value="present" class="peer radio radio-primary hidden" checked />
                                        <div class="card bg-white border-2 border-gray-200 peer-checked:border-green-500 peer-checked:bg-green-50 hover:border-gray-300 transition-all">
                                            <div class="card-body p-4 items-center text-center">
                                                <svg class="w-8 h-8 text-green-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                <span class="font-semibold text-gray-900">Present</span>
                                                <span class="text-xs text-gray-500">Full day wages</span>
                                            </div>
                                        </div>
                                    </label>

                                    <label class="cursor-pointer">
                                        <input type="radio" name="status" value="absent" class="peer radio radio-primary hidden" />
                                        <div class="card bg-white border-2 border-gray-200 peer-checked:border-red-500 peer-checked:bg-red-50 hover:border-gray-300 transition-all">
                                            <div class="card-body p-4 items-center text-center">
                                                <svg class="w-8 h-8 text-red-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                <span class="font-semibold text-gray-900">Absent</span>
                                                <span class="text-xs text-gray-500">No wages</span>
                                            </div>
                                        </div>
                                    </label>

                                    <label class="cursor-pointer">
                                        <input type="radio" name="status" value="half_day" class="peer radio radio-primary hidden" />
                                        <div class="card bg-white border-2 border-gray-200 peer-checked:border-yellow-500 peer-checked:bg-yellow-50 hover:border-gray-300 transition-all">
                                            <div class="card-body p-4 items-center text-center">
                                                <svg class="w-8 h-8 text-yellow-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                <span class="font-semibold text-gray-900">Half Day</span>
                                                <span class="text-xs text-gray-500">50% wages</span>
                                            </div>
                                        </div>
                                    </label>

                                    <label class="cursor-pointer">
                                        <input type="radio" name="status" value="leave" class="peer radio radio-primary hidden" />
                                        <div class="card bg-white border-2 border-gray-200 peer-checked:border-blue-500 peer-checked:bg-blue-50 hover:border-gray-300 transition-all">
                                            <div class="card-body p-4 items-center text-center">
                                                <svg class="w-8 h-8 text-blue-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                                                </svg>
                                                <span class="font-semibold text-gray-900">Leave</span>
                                                <span class="text-xs text-gray-500">With pay</span>
                                            </div>
                                        </div>
                                    </label>

                                    <label class="cursor-pointer">
                                        <input type="radio" name="status" value="holiday" class="peer radio radio-primary hidden" />
                                        <div class="card bg-white border-2 border-gray-200 peer-checked:border-purple-500 peer-checked:bg-purple-50 hover:border-gray-300 transition-all">
                                            <div class="card-body p-4 items-center text-center">
                                                <svg class="w-8 h-8 text-purple-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                                                </svg>
                                                <span class="font-semibold text-gray-900">Holiday</span>
                                                <span class="text-xs text-gray-500">With pay</span>
                                            </div>
                                        </div>
                                    </label>

                                    <label class="cursor-pointer">
                                        <input type="radio" name="status" value="overtime" class="peer radio radio-primary hidden" />
                                        <div class="card bg-white border-2 border-gray-200 peer-checked:border-orange-500 peer-checked:bg-orange-50 hover:border-gray-300 transition-all">
                                            <div class="card-body p-4 items-center text-center">
                                                <svg class="w-8 h-8 text-orange-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                <span class="font-semibold text-gray-900">Overtime</span>
                                                <span class="text-xs text-gray-500">Extra wages</span>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- Hours Worked & Labor Cost Link -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Hours Worked -->
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text font-semibold text-gray-900">Hours Worked</span>
                                        <span class="label-text-alt text-gray-400">(Optional)</span>
                                    </label>
                                    <div class="relative">
                                        <input type="number" name="hours_worked" value="{{ old('hours_worked') }}" step="0.5" min="0" max="24"
                                            placeholder="Auto-calculate"
                                            class="input input-bordered w-full" />
                                        <div class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">
                                            <span class="text-sm">hrs</span>
                                        </div>
                                    </div>
                                    <label class="label">
                                        <span class="label-text-alt">Default: Present=8hrs, Half Day=4hrs, Overtime=10hrs</span>
                                    </label>
                                </div>

                                <!-- Labor Cost Link -->
                                @if($laborCosts->count() > 0)
                                    <div class="form-control">
                                        <label class="label">
                                            <span class="label-text font-semibold text-gray-900">Link to Contractor</span>
                                            <span class="label-text-alt text-gray-400">(Optional)</span>
                                        </label>
                                        <div class="relative">
                                            <select name="labor_cost_id" class="select select-bordered w-full appearance-none">
                                                <option value="">No Link</option>
                                                @foreach($laborCosts as $laborCost)
                                                    <option value="{{ $laborCost->id }}" {{ old('labor_cost_id') == $laborCost->id ? 'selected' : '' }}>
                                                        {{ $laborCost->name ?? $laborCost->labor_type }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none">
                                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Work Description -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-semibold text-gray-900">Work Description</span>
                                    <span class="label-text-alt text-gray-400">(Optional)</span>
                                </label>
                                <textarea name="work_description" rows="3"
                                    placeholder="Describe what work was done today..."
                                    class="textarea textarea-bordered">{{ old('work_description') }}</textarea>
                                <label class="label">
                                    <span class="label-text-alt">Task details, work area, or project notes</span>
                                </label>
                            </div>

                            <!-- Notes -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text font-semibold text-gray-900">Additional Notes</span>
                                    <span class="label-text-alt text-gray-400">(Optional)</span>
                                </label>
                                <textarea name="notes" rows="3"
                                    placeholder="Any additional notes, observations, or reminders..."
                                    class="textarea textarea-bordered">{{ old('notes') }}</textarea>
                            </div>

                            <!-- Wage Calculation Info -->
                            <div class="card bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200">
                                <div class="card-body p-4">
                                    <div class="flex items-center gap-3">
                                        <div class="h-10 w-10 rounded-lg bg-green-500 flex items-center justify-center">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-gray-900">Automatic Wage Calculation</h4>
                                            <p class="text-sm text-gray-600">Wages will be calculated based on daily wage × attendance status</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex justify-end gap-3 mt-8 pt-6 border-t">
                            <a href="{{ route('projects.attendances.index', $project) }}" class="btn btn-ghost gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-success gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Record Attendance
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
