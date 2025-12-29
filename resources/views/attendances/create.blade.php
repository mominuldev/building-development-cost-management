<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Add Attendance - {{ $project->name }}
            </h2>
            <a href="{{ route('projects.attendances.index', $project) }}" class="btn btn-sm btn-ghost">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Attendance
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h3 class="card-title mb-4">Record Attendance</h3>

                    <form action="{{ route('projects.attendances.store', $project) }}" method="POST">
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
                            <!-- Worker -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">Worker</span>
                                    <span class="label-text-alt text-error">*</span>
                                </label>
                                <select name="worker_id" class="select select-bordered" required>
                                    <option value="">Select Worker...</option>
                                    @foreach($workers as $worker)
                                        <option value="{{ $worker->id }}" {{ old('worker_id', $workerId) == $worker->id ? 'selected' : '' }}>
                                            {{ $worker->name }} ({{ ucfirst($worker->category) ?? 'N/A' }}) - {{ number_format($worker->daily_wage, 2) }}/day
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Date -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">Attendance Date</span>
                                    <span class="label-text-alt text-error">*</span>
                                </label>
                                <input type="date" name="attendance_date" value="{{ old('attendance_date', $date) }}"
                                    class="input input-bordered" required />
                            </div>

                            <!-- Status -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">Status</span>
                                    <span class="label-text-alt text-error">*</span>
                                </label>
                                <select name="status" class="select select-bordered" required>
                                    <option value="present">Present</option>
                                    <option value="absent">Absent</option>
                                    <option value="half_day">Half Day</option>
                                    <option value="leave">Leave</option>
                                    <option value="holiday">Holiday</option>
                                    <option value="overtime">Overtime</option>
                                </select>
                                <label class="label">
                                    <span class="label-text-alt">Wages will be automatically calculated based on status</span>
                                </label>
                            </div>

                            <!-- Hours Worked -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">Hours Worked</span>
                                    <span class="label-text-alt">(Optional, for overtime)</span>
                                </label>
                                <input type="number" name="hours_worked" value="{{ old('hours_worked') }}" step="0.5" min="0" max="24"
                                    placeholder="Leave blank for auto-calculation"
                                    class="input input-bordered" />
                                <label class="label">
                                    <span class="label-text-alt">Present=8hrs, Half Day=4hrs, Overtime=10hrs (default)</span>
                                </label>
                            </div>

                            <!-- Labor Cost Link -->
                            @if($laborCosts->count() > 0)
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text">Link to Labor Cost (Optional)</span>
                                    </label>
                                    <select name="labor_cost_id" class="select select-bordered">
                                        <option value="">No Link</option>
                                        @foreach($laborCosts as $laborCost)
                                            <option value="{{ $laborCost->id }}" {{ old('labor_cost_id') == $laborCost->id ? 'selected' : '' }}>
                                                {{ $laborCost->name ?? $laborCost->labor_type }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif

                            <!-- Work Description -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">Work Description</span>
                                </label>
                                <textarea name="work_description" rows="2"
                                    placeholder="Describe what work was done..."
                                    class="textarea textarea-bordered">{{ old('work_description') }}</textarea>
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
                            <a href="{{ route('projects.attendances.index', $project) }}" class="btn btn-ghost">Cancel</a>
                            <button type="submit" class="btn btn-success">Record Attendance</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
