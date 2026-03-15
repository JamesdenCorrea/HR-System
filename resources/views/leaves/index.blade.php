<x-app-layout>
    <x-slot name="title"> Leave Request</x-slot>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight"> Leave Request</h2>
            <a href="{{ route('hr.leaves.balances') }}"
            class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 text-sm">
            Leave Balances
</a>
</div>
</x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded"> {{ session('success') }}</div>
            @endif

            {{-- Filters --}}
            <div class="bg-white shadow-sm rounded-lg p-4 mb-4">
                <form method="GET" action="{{ route('hr.leaves.index') }}"
                class="flex gap-3 flex-wrap items-center">

                <select name="status" class="border-gray-300 rounded-md shadow-sm text-sm">
                    <option value="">All Status </option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
</select>
                <select name="leave_type" class="border-gray-300 rounded-md shadow-sm text-sm">
                    <option value="">All Types</option>
                    <option value="vacation" {{ request('leave_type') == 'vacation' ? 'selected' : '' }}>Vacation</option>
                    <option value="sick" {{ request('leave_type') == 'sick' ? 'selected' : '' }}> Sick</option>
                    <option value="emergency" {{ request('leave_type') == 'emergency' ? 'selected' : '' }}>Emergency</option>
</select>
                <select name="employee_id" class="border-gray-300 rounded-md shadow-sm text-sm">
                    <option value="">All Employees</option>
                    @foreach($employees as $emp)
                    <option value="{{ $emp->id }}"
                    {{ request('employee_id') == $emp->id ? 'selected' : ''}}>
                    {{ $emp->full_name }}
</option>
@endforeach
</select>
                <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-700">
                Filter
</button>
<a href="{{ route('hr.leaves.index') }}"
class="bg-gray-200 text-gray-700 px-4 py-2 rounded text-sm hover:bg-gray-300">
Clear
</a>
</form>
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
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Action</th>
</tr>
</thead>
</tbody class="bg-white divide-y divide-gray-200">
@forelse($leaves as $leave)
<tr>
    <td class="px-6 py-4 text-sm text-gray-900">
        {{ $leave->employee?->full_name ?? 'Unknown' }}
</td>
<td class="px-6 py-4 text-sm text-gray-600">{{ ucfirst ($leave->leave_type) }}</td>
<td class="px-6 py-4 text-sm text-gray-600">{{ $leave->start_date->format('M d, Y') }}</td>
<td class="px-6 py-4 text-sm text-gray-600">{{ $leave->end_date->format('M d, Y') }}</td>
<td class="px-6 py-4 text-sm text-gray-600">{{ $leave->days_requested }}</td>
<td class="px-6 py-4">
    <span class="px-2 py-1 text-xs rounded-full {{ $leave->status_badge }}">
        {{ ucfirst ($leave->status) }}
</span>
</td>
<td class="px-6 py-4 text-sm">
    <a href="{{ route('hr.leaves.show', $leave) }} "
    class="text-blue-600 hover:underline">View</a>
</td>
</tr>
@empty
<tr>
    <td colspan="7" class="px-6 py-4 text-center text-gray-500">
        No leave request found.
</td>
</tr>
@endforelse
</tbody>
</table>
<div class="px-6 py-4"> {{ $leaves -> links () }}</div>
</div>
</div>
</div>
</x-app-layout>