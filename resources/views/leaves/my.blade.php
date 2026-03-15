<x-app-layout>
    <x-slot name="title">My Leaves</x-slot>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight"> My Leave Requests</h2>
            <a href="{{ route('leaves.create') }}"
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">
            + File Leave
</a>
</div>
</x-slot>

<div class="py-12">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if(session('success'))
        <div class="p-4 bg-green-100 text-green-800 rounded"> {{ session ('success') }}</div>
        @endif
        @if(session('error'))
        <div class="p-4 bg-red-100 text-red-800 rounded"> {{ session('error') }}</div>
        @endif

{{-- Leave Balance Cards --}}
<div class="grid grid-cols-3 gap-4">
    <div class="bg-white shadow-sm rounded-lg p-4 text-center">
        <p class="text-xs text-gray-500 uppercase tracking-wide">Vacation Leave</p>
        <p class="text-3xl font-bold text-blue-600 mt-1">{{ $balance->vacation_remaining }}</p>
        <p class="text-xs text-gray-400 mt-1">{{ $balance->vacation_used }} used of {{ $balance->vacation_total }} days</p>
        @if(isset($pendingDays['vacation']))
            <p class="text-xs text-yellow-600 mt-1">{{ $pendingDays['vacation'] }} day(s) pending approval</p>
        @endif
    </div>
    <div class="bg-white shadow-sm rounded-lg p-4 text-center">
        <p class="text-xs text-gray-500 uppercase tracking-wide">Sick Leave</p>
        <p class="text-3xl font-bold text-green-600 mt-1">{{ $balance->sick_remaining }}</p>
        <p class="text-xs text-gray-400 mt-1">{{ $balance->sick_used }} used of {{ $balance->sick_total }} days</p>
        @if(isset($pendingDays['sick']))
            <p class="text-xs text-yellow-600 mt-1">{{ $pendingDays['sick'] }} day(s) pending approval</p>
        @endif
    </div>
    <div class="bg-white shadow-sm rounded-lg p-4 text-center">
        <p class="text-xs text-gray-500 uppercase tracking-wide">Emergency Leave</p>
        <p class="text-3xl font-bold text-red-600 mt-1">{{ $balance->emergency_remaining }}</p>
        <p class="text-xs text-gray-400 mt-1">{{ $balance->emergency_used }} used of {{ $balance->emergency_total }} days</p>
        @if(isset($pendingDays['emergency']))
            <p class="text-xs text-yellow-600 mt-1">{{ $pendingDays['emergency'] }} day(s) pending approval</p>
        @endif
    </div>
</div>
        {{-- Leave History --}}
        <div class="bg-white shadow-sm rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">From</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">To</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Days</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Reason</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
</tr>
</thead>
<tbody class="bg-white divide-y divide-gray-200">
    @forelse($leaves as $leave)
    <tr>
        <td class="px-6 py-4 text-sm text-gray-900">{{ ucfirst($leave->leave_type) }}</td>
        <td class="px-6 py-4 text-sm text-gray-600">{{ $leave->start_date->format('M d, Y') }}</td>
        <td class="px-6 py-4 text-sm text-gray-600">{{ $leave->end_date->format('M d, Y') }}</td>
        <td class="px-6 py-4 text-sm text-gray-600">{{ $leave->days_requested }}</td>
        <td class="px-6 py-4 text-sm text-gray-600 max-w-xs truncate">{{ $leave->reason }}</td>
        <td class="px-6 py-4">
            <span class="px-2 py-1 text-xs rounded-full {{ $leave->status_badge }} ">
                {{ ucfirst($leave->status) }}
</span>
</td>
</tr>
@empty
    <tr>
        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
            No leave request yet.
</td>
</tr>
@endforelse
</tbody>
</table>
<div class="px-6 py-4"> {{ $leaves->links() }}</div>
</div>
</div>
</div>
</x-app-layout>

