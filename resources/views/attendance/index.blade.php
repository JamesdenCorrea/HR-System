<x-app-layout>
    <x-slot name="title">Attendance </x-slot>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight"> Attendance Records</h2>
            <div class="flex gap-2">
                <a href="{{ route('hr.attendance.create') }}"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">
                + Manual Entry
</a>
<a href="{{ route('hr.attendance.monthly') }}"
class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 text-sm">
Monthly Report
</a>
</div>
</div>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

    @if(session('success'))
    <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
        {{ session('success') }}
</div>
@endif

{{-- Filters --}}
<div class="bg-white shadow-sm rounded-lg p-4 mb-4">
    <form method="GET" action="{{ route('hr.attendance.index') }}" class="flex gap-3 flex-wrap">
        <input type="date" name="date" value="{{ request('date') }}"
        class="border-gray-300 rounded-md shadow-sm text-sm">

        <select name="employee_id" class="border-gray-300 rounded-md shadow-sm text-sm">
            <option value="">All Employees</option>
            @foreach($employees as $emp)
            <option value="{{ $emp->id }}"
            {{ request('employee_id') == $emp->id ? 'selected': ''}}>
            {{ $emp->full_name }}
</option>
@endforeach
</select>

<select name="status" class="border-gray-300 rounded-md shadow-sm text-sm">
    <option value="present" {{request('status') == 'present' ? 'selected' : ''}}>Present </option>
    <option value="late" {{request('status') == 'late' ? 'selected' : '' }}>Late </option>
    <option value="absent" {{request('status') == 'absent' ? 'selected' : ''}}>Absent </option>
    <option value="half-day"{{request('status') == 'half-day' ? 'selected' : ''}}>Half-day </option>
</select>
    <button type="submit"
    class="bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-700">
    Filter
</button>
<a href="{{ route('hr.attendance.index') }}"
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
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Clock In</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Clock Out</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Hours</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
</tr>
</thead>
<tbody class="bg-white divide-y divide-gray-200">
    @forelse($attendances as $record)
    <tr>
        <td class="px-6 py-4 text-sm text-gray-900">
        {{ $record->employee->full_name }}
</td>
<td class="px-6 py-4 text-sm text-gray-600">
    {{ \Carbon\Carbon::parse($record->date)->format('M d, Y')}}
</td>
<td class="px-6 py-4 text-sm text-gray-600">
    {{ $record->clock_in
    ? \Carbon\Carbon::parse($record->clock_in)->format('h:i A')
    : '-' }}
</td>
<td class="px-6 py-4 text-sm text-gray-600">
    {{ $record->clock_out
    ? \Carbon\Carbon::parse($record->clock_out)->format('h:i A')
    : '-' }}
</td>
<td class="px-6 py-4 text-sm text-gray-600">
    {{ $record->work_hours }}
</td>
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
<div class="px-6 py-4">
    {{ $attendances->links() }}
</div>
</div>
</div>
</div>
</x-app-layout>