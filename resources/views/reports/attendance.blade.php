<x-app-layout>
    <x-slot name="title">Attendance Report</x-slot>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Attendance Report</h2>
            <div class="flex gap-2">
                <a href="{{ route('hr.reports.export.excel', 'attendance') }}?mon={{ substr($month,5,2) }}&yr={{ substr($month,0,4) }}"
                   class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 text-sm">
                    Export Excel
                </a>
                <a href="{{ route('hr.reports.export.pdf', 'attendance') }}?month={{ $month }}"
                   class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 text-sm">
                    Export PDF
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

            {{-- Filters --}}
            <div class="bg-white shadow-sm rounded-lg p-4">
                <form method="GET" action="{{ route('hr.reports.attendance') }}"
                      class="flex gap-3 flex-wrap items-center">
                    <input type="month" name="month" value="{{ $month }}"
                        class="border-gray-300 rounded-md shadow-sm text-sm">
                    <select name="employee_id" class="border-gray-300 rounded-md shadow-sm text-sm">
                        <option value="">All Employees</option>
                        @foreach($employees as $emp)
                            <option value="{{ $emp->id }}"
                                {{ request('employee_id') == $emp->id ? 'selected' : '' }}>
                                {{ $emp->full_name }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-700">
                        Filter
                    </button>
                </form>
            </div>

            {{-- Summary Cards --}}
            <div class="grid grid-cols-4 gap-4">
                <div class="bg-white shadow-sm rounded-lg p-4 text-center">
                    <p class="text-xs text-gray-500 uppercase">Present</p>
                    <p class="text-2xl font-bold text-green-600">{{ $summary['present'] }}</p>
                </div>
                <div class="bg-white shadow-sm rounded-lg p-4 text-center">
                    <p class="text-xs text-gray-500 uppercase">Late</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ $summary['late'] }}</p>
                </div>
                <div class="bg-white shadow-sm rounded-lg p-4 text-center">
                    <p class="text-xs text-gray-500 uppercase">Absent</p>
                    <p class="text-2xl font-bold text-red-600">{{ $summary['absent'] }}</p>
                </div>
                <div class="bg-white shadow-sm rounded-lg p-4 text-center">
                    <p class="text-xs text-gray-500 uppercase">Half Day</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $summary['half_day'] }}</p>
                </div>
            </div>

            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Employee</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Clock In</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Clock Out</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Hours</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($records as $record)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                {{ $record->employee?->full_name ?? '—' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ \Carbon\Carbon::parse($record->date)->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $record->clock_in
                                    ? \Carbon\Carbon::parse($record->clock_in)->format('h:i A')
                                    : '—' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $record->clock_out
                                    ? \Carbon\Carbon::parse($record->clock_out)->format('h:i A')
                                    : '—' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $record->work_hours }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs rounded-full
                                    {{ $record->status === 'present' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $record->status === 'late' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $record->status === 'absent' ? 'bg-red-100 text-red-800' : '' }}
                                    {{ $record->status === 'half-day' ? 'bg-blue-100 text-blue-800' : '' }}">
                                    {{ ucfirst($record->status) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                No attendance records found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>