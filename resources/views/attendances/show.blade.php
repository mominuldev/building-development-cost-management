<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Attendance Details - {{ $attendance->worker->name }}
            </h2>
            <a href="{{ route('projects.attendances.index', ['project' => $project, 'date' => $attendance->attendance_date]) }}" class="btn btn-sm btn-ghost">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Attendance
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h3 class="card-title mb-4">Attendance Record</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Worker Info -->
                        <div class="space-y-4">
                            <h4 class="font-bold text-lg">Worker Information</h4>
                            <div class="bg-base-200 rounded-lg p-4 space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Name</span>
                                    <span class="font-medium">{{ $attendance->worker->name }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Category</span>
                                    <span class="font-medium">{{ ucfirst($attendance->worker->category) ?? 'N/A' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Labor Type</span>
                                    <span class="font-medium">{{ ucfirst($attendance->worker->labor_type) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Daily Wage</span>
                                    <span class="font-medium">{{ number_format($attendance->worker->daily_wage, 2) }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Attendance Info -->
                        <div class="space-y-4">
                            <h4 class="font-bold text-lg">Attendance Details</h4>
                            <div class="bg-base-200 rounded-lg p-4 space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Date</span>
                                    <span class="font-medium">{{ $attendance->attendance_date->format('M d, Y') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Status</span>
                                    <div>
                                        @if($attendance->status == 'present')
                                            <div class="badge badge-success">Present</div>
                                        @elseif($attendance->status == 'absent')
                                            <div class="badge badge-error">Absent</div>
                                        @elseif($attendance->status == 'leave')
                                            <div class="badge badge-warning">Leave</div>
                                        @elseif($attendance->status == 'half_day')
                                            <div class="badge badge-info">Half Day</div>
                                        @elseif($attendance->status == 'overtime')
                                            <div class="badge badge-secondary">Overtime</div>
                                        @else
                                            <div class="badge badge-ghost">{{ ucfirst($attendance->status) }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Hours Worked</span>
                                    <span class="font-medium">{{ $attendance->hours_worked }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Wage Amount</span>
                                    <span class="font-bold text-lg">{{ number_format($attendance->wage_amount, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Work Description & Notes -->
                    <div class="mt-6 space-y-4">
                        @if($attendance->work_description)
                            <div>
                                <h4 class="font-bold">Work Description</h4>
                                <div class="bg-base-200 rounded-lg p-4 mt-2">
                                    {{ $attendance->work_description }}
                                </div>
                            </div>
                        @endif

                        @if($attendance->notes)
                            <div>
                                <h4 class="font-bold">Notes</h4>
                                <div class="bg-base-200 rounded-lg p-4 mt-2">
                                    {{ $attendance->notes }}
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Actions -->
                    <div class="card-actions justify-end mt-6">
                        <a href="{{ route('projects.attendances.edit', [$project, $attendance]) }}" class="btn btn-primary">
                            Edit Attendance
                        </a>
                        <form action="{{ route('projects.attendances.destroy', [$project, $attendance]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this attendance record?')" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-error">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
