<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Attendance Calendar - {{ $project->name }}
            </h2>
            <div class="flex gap-4">
                <a href="{{ route('projects.attendances.index', $project) }}" class="btn btn-sm btn-ghost">
                    List View
                </a>
                <a href="{{ route('projects.show', $project) }}" class="btn btn-sm btn-ghost">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Project
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Month Navigation -->
            <div class="card bg-base-100 shadow-xl mb-6">
                <div class="card-body">
                    <div class="flex justify-between items-center">
                        <a href="{{ route('projects.attendances.calendar', ['project' => $project, 'date' => $date->copy()->subMonth()->format('Y-m')]) }}"
                           class="btn btn-outline">
                            &larr; Previous Month
                        </a>
                        <h3 class="text-2xl font-bold">{{ $date->format('F Y') }}</h3>
                        <a href="{{ route('projects.attendances.calendar', ['project' => $project, 'date' => $date->copy()->addMonth()->format('Y-m')]) }}"
                           class="btn btn-outline">
                            Next Month &rarr;
                        </a>
                    </div>
                </div>
            </div>

            <!-- Calendar Grid -->
            @if($workers->count() > 0)
                <div class="card bg-base-100 shadow-xl mb-6">
                    <div class="card-body p-0">
                        <div class="overflow-x-auto">
                            <table class="table">
                                <thead>
                                    <tr class="bg-base-200">
                                        <th class="sticky left-0 bg-base-200 z-10 min-w-[200px]">Worker</th>
                                        @foreach($dates as $day)
                                            <th class="text-center min-w-[45px] p-2">
                                                <div class="text-sm font-bold">{{ $day->format('j') }}</div>
                                                <div class="text-xs text-gray-500">{{ $day->format('D') }}</div>
                                            </th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($workers as $worker)
                                        <tr>
                                            <td class="sticky left-0 bg-white z-10">
                                                <div class="font-bold">{{ $worker->name }}</div>
                                                @if($worker->category)
                                                    <div class="badge badge-ghost badge-sm">{{ ucfirst($worker->category) }}</div>
                                                @endif
                                            </td>
                                            @foreach($dates as $day)
                                                @php
                                                    $key = $worker->id . '_' . $day->toDateString();
                                                    $attendance = $attendances->get($key);
                                                @endphp
                                                <td class="p-1 text-center">
                                                    @if($attendance)
                                                        @if($attendance->status == 'present')
                                                            <div class="tooltip tooltip-bottom" data-tip="Present - {{ number_format($attendance->wage_amount, 2) }}">
                                                                <div class="w-8 h-8 mx-auto rounded bg-success text-success-content text-xs flex items-center justify-center font-bold cursor-pointer hover:opacity-80"
                                                                     onclick="window.location.href='{{ route('projects.attendances.edit', [$project, $attendance]) }}'">
                                                                    P
                                                                </div>
                                                            </div>
                                                        @elseif($attendance->status == 'absent')
                                                            <div class="tooltip tooltip-bottom" data-tip="Absent">
                                                                <div class="w-8 h-8 mx-auto rounded bg-error text-error-content text-xs flex items-center justify-center font-bold cursor-pointer hover:opacity-80"
                                                                     onclick="window.location.href='{{ route('projects.attendances.edit', [$project, $attendance]) }}'">
                                                                    A
                                                                </div>
                                                            </div>
                                                        @elseif($attendance->status == 'leave')
                                                            <div class="tooltip tooltip-bottom" data-tip="Leave">
                                                                <div class="w-8 h-8 mx-auto rounded bg-warning text-warning-content text-xs flex items-center justify-center font-bold cursor-pointer hover:opacity-80"
                                                                     onclick="window.location.href='{{ route('projects.attendances.edit', [$project, $attendance]) }}'">
                                                                    L
                                                                </div>
                                                            </div>
                                                        @elseif($attendance->status == 'half_day')
                                                            <div class="tooltip tooltip-bottom" data-tip="Half Day - {{ number_format($attendance->wage_amount, 2) }}">
                                                                <div class="w-8 h-8 mx-auto rounded bg-info text-info-content text-xs flex items-center justify-center font-bold cursor-pointer hover:opacity-80"
                                                                     onclick="window.location.href='{{ route('projects.attendances.edit', [$project, $attendance]) }}'">
                                                                    H
                                                                </div>
                                                            </div>
                                                        @elseif($attendance->status == 'overtime')
                                                            <div class="tooltip tooltip-bottom" data-tip="Overtime - {{ number_format($attendance->wage_amount, 2) }}">
                                                                <div class="w-8 h-8 mx-auto rounded bg-secondary text-secondary-content text-xs flex items-center justify-center font-bold cursor-pointer hover:opacity-80"
                                                                     onclick="window.location.href='{{ route('projects.attendances.edit', [$project, $attendance]) }}'">
                                                                    O
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="tooltip tooltip-bottom" data-tip="{{ ucfirst($attendance->status) }}">
                                                                <div class="w-8 h-8 mx-auto rounded bg-neutral text-neutral-content text-xs flex items-center justify-center font-bold cursor-pointer hover:opacity-80"
                                                                     onclick="window.location.href='{{ route('projects.attendances.edit', [$project, $attendance]) }}'">
                                                                    {{ substr($attendance->status, 0, 1) }}
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @elseif($day->isSunday())
                                                        <div class="w-8 h-8 mx-auto rounded bg-base-200"></div>
                                                    @else
                                                        <a href="{{ route('projects.attendances.create', ['project' => $project, 'worker_id' => $worker->id, 'date' => $day->toDateString()]) }}"
                                                           class="block w-8 h-8 mx-auto rounded border border-dashed border-gray-300 hover:border-primary text-gray-400 hover:text-primary text-xs flex items-center justify-center transition-colors"
                                                           title="Add attendance">
                                                            +
                                                        </a>
                                                    @endif
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Legend -->
                <div class="card bg-base-100 shadow-xl">
                    <div class="card-body">
                        <h4 class="text-sm font-bold mb-3">Legend:</h4>
                        <div class="flex flex-wrap gap-6 text-sm">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded bg-success text-success-content flex items-center justify-center font-bold text-xs">P</div>
                                <span>Present</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded bg-error text-error-content flex items-center justify-center font-bold text-xs">A</div>
                                <span>Absent</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded bg-warning text-warning-content flex items-center justify-center font-bold text-xs">L</div>
                                <span>Leave</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded bg-info text-info-content flex items-center justify-center font-bold text-xs">H</div>
                                <span>Half Day</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded bg-secondary text-secondary-content flex items-center justify-center font-bold text-xs">O</div>
                                <span>Overtime</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded bg-base-200 border border-dashed"></div>
                                <span>No Attendance</span>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="card bg-base-100 shadow-xl">
                    <div class="card-body">
                        <div class="alert alert-warning">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            <div>
                                <h3 class="font-bold">No workers yet!</h3>
                                <div class="text-xs">Add workers to view attendance calendar.</div>
                            </div>
                            <a href="{{ route('projects.workers.create', $project) }}" class="btn btn-sm btn-primary">Add Worker</a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
