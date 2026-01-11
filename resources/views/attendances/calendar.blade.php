<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <div class="flex items-center gap-3">
                    <h2 class="text-2xl font-bold text-gray-900">Attendance Calendar</h2>
                    <div class="badge badge-primary">{{ $project->name }}</div>
                </div>
                <p class="text-gray-500 mt-1">Monthly overview of worker attendance</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('projects.attendances.index', $project) }}" class="btn btn-ghost btn-sm gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                    </svg>
                    List View
                </a>
                <a href="{{ route('projects.show', $project) }}" class="btn btn-ghost btn-sm gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Project
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Month Navigation -->
            <div class="card bg-white shadow-xl">
                <div class="card-body">
                    <div class="flex items-center justify-between">
                        <a href="{{ route('projects.attendances.calendar', ['project' => $project, 'date' => $date->copy()->subMonth()->format('Y-m')]) }}"
                           class="btn btn-outline gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                            Previous Month
                        </a>
                        <div class="text-center">
                            <h3 class="text-3xl font-bold text-gray-900">{{ $date->format('F Y') }}</h3>
                            <p class="text-sm text-gray-500 mt-1">{{ $workers->count() }} worker{{ $workers->count() != 1 ? 's' : '' }}</p>
                        </div>
                        <a href="{{ route('projects.attendances.calendar', ['project' => $project, 'date' => $date->copy()->addMonth()->format('Y-m')]) }}"
                           class="btn btn-outline gap-2">
                            Next Month
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Calendar Grid -->
            @if($workers->count() > 0)
                <div class="card bg-white shadow-xl">
                    <div class="card-body p-0">
                        <div class="overflow-x-auto">
                            <table class="table">
                                <thead>
                                    <tr class="bg-gradient-to-r from-gray-50 to-gray-100">
                                        <th class="sticky left-0 bg-gradient-to-r from-gray-50 to-gray-100 z-10 min-w-[220px] shadow-lg">
                                            <div class="flex items-center gap-2">
                                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                                </svg>
                                                <span class="font-semibold text-gray-900">Workers</span>
                                            </div>
                                        </th>
                                        @foreach($dates as $day)
                                            <th class="text-center min-w-[50px] p-2 @if($day->isFriday()) bg-red-50 @elseif($day->isSaturday()) bg-blue-50 @endif">
                                                <div class="text-lg font-bold {{ $day->isToday() ? 'text-primary' : 'text-gray-900' }}">{{ $day->format('j') }}</div>
                                                <div class="text-xs {{ $day->isToday() ? 'text-primary' : 'text-gray-500' }}">{{ $day->format('D') }}</div>
                                                @if($day->isToday())
                                                    <div class="badge badge-xs badge-primary mt-1">Today</div>
                                                @endif
                                            </th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($workers as $worker)
                                        <tr class="hover">
                                            <td class="sticky left-0 bg-white z-10 shadow-lg">
                                                <div class="flex items-center gap-3">
                                                    <div class="avatar placeholder">
                                                        <div class="bg-neutral text-neutral-content rounded-lg w-10">
                                                            <span class="text-sm flex items-center justify-center h-full">{{ substr($worker->name, 0, 1) }}</span>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="font-bold text-gray-900">{{ $worker->name }}</div>
                                                        @if($worker->category)
                                                            <div class="badge badge-info badge-sm">{{ ucfirst($worker->category) }}</div>
                                                        @else
                                                            <div class="text-xs text-gray-400">{{ ucfirst($worker->labor_type) }}</div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            @foreach($dates as $day)
                                                @php
                                                    $key = $worker->id . '_' . $day->toDateString();
                                                    $attendance = $attendances->get($key);
                                                @endphp
                                                <td class="p-2 text-center @if($day->isFriday()) bg-red-50/30 @elseif($day->isSaturday()) bg-blue-50/30 @endif">
                                                    @if($attendance)
                                                        @if($attendance->status == 'present')
                                                            <a href="{{ route('projects.attendances.edit', [$project, $attendance]) }}"
                                                               class="block tooltip tooltip-bottom" data-tip="Present - {{ number_format($attendance->wage_amount, 2) }}">
                                                                <div class="w-9 h-9 mx-auto rounded-lg bg-gradient-to-br from-green-500 to-green-600 text-white text-sm flex items-center justify-center font-bold cursor-pointer hover:scale-110 transition-transform shadow-sm">
                                                                    P
                                                                </div>
                                                            </a>
                                                        @elseif($attendance->status == 'absent')
                                                            <a href="{{ route('projects.attendances.edit', [$project, $attendance]) }}"
                                                               class="block tooltip tooltip-bottom" data-tip="Absent">
                                                                <div class="w-9 h-9 mx-auto rounded-lg bg-gradient-to-br from-red-500 to-red-600 text-white text-sm flex items-center justify-center font-bold cursor-pointer hover:scale-110 transition-transform shadow-sm">
                                                                    A
                                                                </div>
                                                            </a>
                                                        @elseif($attendance->status == 'leave')
                                                            <a href="{{ route('projects.attendances.edit', [$project, $attendance]) }}"
                                                               class="block tooltip tooltip-bottom" data-tip="Leave">
                                                                <div class="w-9 h-9 mx-auto rounded-lg bg-gradient-to-br from-blue-500 to-blue-600 text-white text-sm flex items-center justify-center font-bold cursor-pointer hover:scale-110 transition-transform shadow-sm">
                                                                    L
                                                                </div>
                                                            </a>
                                                        @elseif($attendance->status == 'half_day')
                                                            <a href="{{ route('projects.attendances.edit', [$project, $attendance]) }}"
                                                               class="block tooltip tooltip-bottom" data-tip="Half Day - {{ number_format($attendance->wage_amount, 2) }}">
                                                                <div class="w-9 h-9 mx-auto rounded-lg bg-gradient-to-br from-yellow-500 to-yellow-600 text-white text-sm flex items-center justify-center font-bold cursor-pointer hover:scale-110 transition-transform shadow-sm">
                                                                    H
                                                                </div>
                                                            </a>
                                                        @elseif($attendance->status == 'overtime')
                                                            <a href="{{ route('projects.attendances.edit', [$project, $attendance]) }}"
                                                               class="block tooltip tooltip-bottom" data-tip="Overtime - {{ number_format($attendance->wage_amount, 2) }}">
                                                                <div class="w-9 h-9 mx-auto rounded-lg bg-gradient-to-br from-orange-500 to-orange-600 text-white text-sm flex items-center justify-center font-bold cursor-pointer hover:scale-110 transition-transform shadow-sm">
                                                                    O
                                                                </div>
                                                            </a>
                                                        @else
                                                            <a href="{{ route('projects.attendances.edit', [$project, $attendance]) }}"
                                                               class="block tooltip tooltip-bottom" data-tip="{{ ucfirst($attendance->status) }}">
                                                                <div class="w-9 h-9 mx-auto rounded-lg bg-gradient-to-br from-gray-500 to-gray-600 text-white text-sm flex items-center justify-center font-bold cursor-pointer hover:scale-110 transition-transform shadow-sm">
                                                                    {{ substr($attendance->status, 0, 1) }}
                                                                </div>
                                                            </a>
                                                        @endif
                                                    @elseif($day->isFriday())
                                                        <div class="w-9 h-9 mx-auto rounded-lg bg-red-100"></div>
                                                    @else
                                                        <a href="{{ route('projects.attendances.create', ['project' => $project, 'worker_id' => $worker->id, 'date' => $day->toDateString()]) }}"
                                                           class="block tooltip tooltip-bottom"
                                                           data-tip="Add attendance for {{ $day->format('M j') }}">
                                                            <div class="w-9 h-9 mx-auto rounded-lg border-2 border-dashed border-gray-300 hover:border-green-500 hover:bg-green-50 text-gray-400 hover:text-green-600 text-sm flex items-center justify-center transition-all cursor-pointer">
                                                                +
                                                            </div>
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
                <div class="card bg-white shadow-xl mt-6">
                    <div class="card-body">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="h-8 w-8 rounded-lg bg-gradient-to-br from-indigo-500 to-purple-500 flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h4 class="text-lg font-bold text-gray-900">Attendance Status Legend</h4>
                        </div>
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                            <div class="flex items-center gap-3 p-3 rounded-lg bg-green-50 border border-green-200">
                                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-green-500 to-green-600 text-white flex items-center justify-center font-bold text-sm shadow-sm">P</div>
                                <div>
                                    <div class="font-semibold text-gray-900">Present</div>
                                    <div class="text-xs text-gray-500">Full day</div>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 p-3 rounded-lg bg-red-50 border border-red-200">
                                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-red-500 to-red-600 text-white flex items-center justify-center font-bold text-sm shadow-sm">A</div>
                                <div>
                                    <div class="font-semibold text-gray-900">Absent</div>
                                    <div class="text-xs text-gray-500">No pay</div>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 p-3 rounded-lg bg-blue-50 border border-blue-200">
                                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-blue-500 to-blue-600 text-white flex items-center justify-center font-bold text-sm shadow-sm">L</div>
                                <div>
                                    <div class="font-semibold text-gray-900">Leave</div>
                                    <div class="text-xs text-gray-500">With pay</div>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 p-3 rounded-lg bg-yellow-50 border border-yellow-200">
                                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-yellow-500 to-yellow-600 text-white flex items-center justify-center font-bold text-sm shadow-sm">H</div>
                                <div>
                                    <div class="font-semibold text-gray-900">Half Day</div>
                                    <div class="text-xs text-gray-500">50% wages</div>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 p-3 rounded-lg bg-orange-50 border border-orange-200">
                                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-orange-500 to-orange-600 text-white flex items-center justify-center font-bold text-sm shadow-sm">O</div>
                                <div>
                                    <div class="font-semibold text-gray-900">Overtime</div>
                                    <div class="text-xs text-gray-500">Extra pay</div>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 p-3 rounded-lg bg-gray-50 border border-gray-200">
                                <div class="w-8 h-8 rounded-lg border-2 border-dashed border-gray-400 flex items-center justify-center text-gray-500 text-sm">+</div>
                                <div>
                                    <div class="font-semibold text-gray-900">Not Marked</div>
                                    <div class="text-xs text-gray-500">Click to add</div>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 mt-4 p-3 rounded-lg bg-red-50 border border-red-200">
                            <div class="w-8 h-8 rounded-lg bg-red-100 flex items-center justify-center">
                                <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="font-semibold text-gray-900">Friday</div>
                                <div class="text-xs text-gray-500">Weekly holiday (red highlight)</div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="card bg-white shadow-xl">
                    <div class="card-body">
                        <div class="text-center py-12">
                            <div class="inline-flex h-20 w-20 items-center justify-center rounded-full bg-yellow-100 mb-4">
                                <svg class="w-10 h-10 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">No workers yet!</h3>
                            <p class="text-gray-500 mb-6">Add workers to view attendance calendar</p>
                            <a href="{{ route('projects.workers.create', $project) }}" class="btn btn-primary gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Add Your First Worker
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
