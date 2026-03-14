<x-app-layout>
    <x-slot name="title">Monthly Attendance Report</x-slot>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semi bold text-xl text-gray-800 leading-tight">Monthly Attendance Report </h2>
</div>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

    {{-- Month Selector --}}

    <div class="bg-white shadow-sm rounded-lg p-4 mb-4">
        <form method="GET" class="flex gap-3 items-center">
            <label class="text-sm font-medium text-gray-700">Month:</label>
            <input type="month" name="month" value="{{ $month}}"
            class="border-gray-300 rounded-md shadow-sm text-sm">
            <button type="submit"
            class="bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-700">
            View
</button>
</form>
</div>

<div class="bg-white shadow-sm rounded-lg overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class"bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Empployee</th>
                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Present</th>
                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Late</th>
                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Absent</th>
                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Half Day</th>
</tr>
</thead>
<tbody class="bg-white divide-y divide-gray-200">
    @forelse($employees as $emp)
    <tr>
        <td class="px-6 py-4 text-sm text-gray-900">{{ $emp->full_name }}</td>
        <td class="px-6 py-4 text-center text-sm text-green-600 font-semibold">
            {{ $emp->attendances->where('status', 'present')->count() }}
</td>
<td class="px-6 py-4 text-center text-sm text-yellow-600 font-semibold">
    {{ $emp->attendances->where('status', 'late')->count() }}
</td>
<td class="px-6 py-4 text-center text-sm text-red-600 font-semibold">
    {{ $emp->attendances->where('status', 'absent')->count() }}
</td>
<td class="px-6 py-4 text-center text-sm text-blue-600 font-semibold">
    {{ $emp->attendances->where('status', 'half-day')->count() }}
</td>
</tr>
@empty
<tr>
    <td colspan="5" class="px-6 py-4 text-center text-gray-500">
        No employees found.
</td>
</tr>
@endforelse
</tbody>
</table>
</div>
</div>
</div>
</x-app-layout>
