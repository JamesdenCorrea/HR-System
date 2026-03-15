<x-app-layout>
    <x-slot name="title"> Leave Request Details</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight"> Leave Request Details</h2>
</x-slot>

<div class="py-12">
    <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 space-y-4">

    @if(session('success'))
    <div class="p-4 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="p-4 bg-red-100 text-red-800 rounded"> {{session ('error') }}</div>
    @endif

    <div class="bg-white shadow-sm rounded-lg p-6">
        <div class="grid grid-cols-2 gap-4 text-sm">
            <div>
                <p class="text-gray-500">Employee</p>
                <p class="font-semibold">{{ $leave->employee->full_name }}</p>
</div>
            <div>
                <p class="text-gray-500">Leave Type</p>
                <p class="font-semibold">{{ ucfirst($leave->leave_type) }} Leave</p>
</div>
            <div>
                <p class="text-gray-500">Start Date</p>
                <p class="font-semibold">{{ $leave->start_date->format('F d, Y') }}</p>
</div>
            <div>
                <p class="text-gray-500">End Date</p>
                <p class="font-semibold"> {{ $leave->end_date->format('F d, Y') }}</p>
</div>
            <div>
                <p class="text-gray-500"> Days Requested</p>
                <p class="font-semibold">{{ $leave->days_requested }} day(s)</p>
</div>
            <div>
                <p class="text-gray-500"> Status</p>
                <span class="px-2 py-1 text-xs rounded-full {{ $leave->status_badge }}">
                    {{ ucfirst($leave->status) }}
</span>
</div>
            <div class="col-span-2">
                <p class="text-gray-500">Reason</p>
                <p class="font-semibold">{{ $leave->reason }}</p>
</div>
@if($leave->rejection_reason)
<div class="col-span-2">
    <p class="text-gray-500">Rejection Reason</p>
    <p class="font-semibold text-red-600"> {{ $leave->rejection_reason }}</p>
</div>
@endif
</div>
</div>
@if($leave->status === 'pending')
<div class="bg-white shadow-sm rounded-lg p-6 space-y-4">
    <h3 class="font-semibold text-gray-700"> Process Request</h3>

    {{-- Approve --}}
    <form method="POST" action="{{ route('hr.leaves.approve', $leave) }}">
        @csrf
        <button type="submit"
        class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700 font-semibold">
        Approve Leave
</button>
</form>

{{-- Reject --}}
<form method="POST" action="{{ route('hr.leaves.reject', $leave) }}">
    @csrf
    @if($errors->has('rejection_reason'))
    <p class="text-red-600 text-sm mb-2">{{ $errors->first('rejection_reason') }}</p>
    @endif
    <textarea name="rejection_reason" rows="2"
    placeholder="Reason for rejection (required)..."
    class="w-full border-gray-300 rounded-md shadow-sm text-sm mb-2"> {{ old('rejection_reason') }}</textarea>
    <button type="submit"
    class="w-full bg-red-600 text-white py-2 rounded hover:bg-red-700 font-semibold">
    Reject Leave
</button>
</form>
</div>
@endif

<a href="{{ route('hr.leaves.index') }}"
class="inline-block text-blue-600 hover:underline text-sm">
← Back to Leave Requests
</a>
</div>
</div>
</x-app-layout>
