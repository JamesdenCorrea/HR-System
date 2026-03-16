<x-app-layout>
    <x-slot name="title">Leave Report</x-slot>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Leave Report</h2>
            <div class="flex gap-2">
                <a href="{{ route('hr.reports.export.excel', 'leaves') }}?yr={{ $year }}"
                   class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 text-sm">
                    Export Excel
                </a>
                <a href="{{ route('hr.reports.export.pdf', 'leaves') }}?year={{ $year }}"
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
                <form method="GET" action="{{ route('hr.reports.leaves') }}"
                      class="flex gap-3 flex-wrap items-center">
                    <input type="number" name="year" value="{{ $year }}"
                        min="2020" max="2099" placeholder="Year"
                        class="border-gray-300 rounded-md shadow-sm text-sm w-24">
                    <select name="status" class="border-gray-300 rounded-md shadow-sm text-sm">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                    <select name="leave_type" class="border-gray-300 rounded-md shadow-sm text-sm">
                        <option value="">All Types</option>
                        <option value="vacation" {{ request('leave_type') == 'vacation' ? 'selected' : '' }}>Vacation</option>
                        <option value="sick" {{ request('leave_type') == 'sick' ? 'selected' : '' }}>Sick</option>
                        <option value="emergency" {{ request('leave_type') == 'emergency' ? 'selected' : '' }}>Emergency</option>
                    </select>
                    <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-700">
                        Filter
                    </button>
                </form>
            </div>

            {{-- Summary --}}
            <div class="grid grid-cols-4 gap-4">
                <div class="bg-white shadow-sm rounded-lg p-4 text-center">
                    <p class="text-xs text-gray-500 uppercase">Total</p>
                    <p class="text-2xl font-bold text-gray-700">{{ $summary['total'] }}</p>
                </div>
                <div class="bg-white shadow-sm rounded-lg p-4 text-center">
                    <p class="text-xs text-gray-500 uppercase">Approved</p>
                    <p class="text-2xl font-bold text-green-600">{{ $summary['approved'] }}</p>
                </div>
                <div class="bg-white shadow-sm rounded-lg p-4 text-center">
                    <p class="text-xs text-gray-500 uppercase">Pending</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ $summary['pending'] }}</p>
                </div>
                <div class="bg-white shadow-sm rounded-lg p-4 text-center">
                    <p class="text-xs text-gray-500 uppercase">Rejected</p>
                    <p class="text-2xl font-bold text-red-600">{{ $summary['rejected'] }}</p>
                </div>
            </div>

            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Employee</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">From</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">To</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Days</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($leaves as $leave)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                {{ $leave->employee?->full_name ?? '—' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ ucfirst($leave->leave_type) }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $leave->start_date->format('M d, Y') }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $leave->end_date->format('M d, Y') }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $leave->days_requested }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs rounded-full {{ $leave->status_badge }}">
                                    {{ ucfirst($leave->status) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                No leave records found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>