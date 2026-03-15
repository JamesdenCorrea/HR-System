<x-app-layout>
    <x-slot name="title"> Leave Balances</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight"> Leave Balances</h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"> Employee</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Vacation Used</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase"> Vacation Left</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Sick Used </th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Sick Left</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase"> Emergency Used</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase"> Emergency Left</th>
</tr>
</thead>
<tbody class="bg-white divide-y divide-gray-200">
    @forelse($employees as $emp)
    <tr>
        <td class="px-6 py-4 text-sm text-gray-900">{{ $emp->full_name }}</td>
        @if($emp->leaveBalance)
        <td class="px-6 py-4 text-center text-sm text-gray-600"> {{ $emp->leaveBalance->vacation_remaining }}</td>
        <td class="px-6 py-4 text-center text-sm font-semibold text-blue-600">{{ $emp->leaveBalance->vacation_remaining }}</td>
        <td class="px-6 py-4 text-center text-sm text-gray">{{ $emp->leaveBalance->sick_remaining }}</td>
        <td class="px-6 py-4 text-center text-sm font-semibold text-green-600">{{ $emp->leaveBalance->sick_remaining }}</td>
        <td class="px-6 py-4 text-center text-sm text-gray-600">{{ $emp->leaveBalance->emergency_remaining }}</td>
        <td class="px-6 py-4 text-center text-sm font-semibold text-red-600">{{ $emp->leaveBalance->emergency_remaining }}</td>
        @else
        <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-400"> No balance record yet.</td>
        @endif
</tr>
@empty
<tr>
    <td colspan="7" class="px-6 py-4 text-center text-gray-500"> No employees found.</td>
</tr>
@endforelse
</tbody>
</table>
</div>
</div>
</div>
</x-app-layout>
