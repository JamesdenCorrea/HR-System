<x-app-layout>
    <x-slot name="title">Employee Profile</x-slot>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $employee->full_name }}
</h2>
<a href=" {{ route ('hr.employees.edit', $employee) }}"
class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 text-sm">
Edit
</a>
</div>
</x-slot>

<div class="py-12">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm rounded-lg p-6">

        @if($employee->profile_photo)
        <img src=" {{ Storage::url($employee->profile_photo) }}"
        class="w-24 h-24 rounded-full object-cover mb-6">
        @endif

        <div class="grid grid-cols-2 gap-4 text-sm">
            <div><span class="font-medium text-gray-600">Employee ID: </span>
            <p> {{ $employee->employee_id}}</p></div>
            <div><span class="font-medium text-gray-600">Date Hired:</span>
            <p>{{ \Carbon\Carbon::parse($employee->date_hired)->format('F d, Y') }}</p>
            <div><span class="font-medium text-gray-600">Email:</span>
            <p>{{ $employee->email}}</p></div>
            <div><span class="font-medium text-gray-600">Phone:</span>
            <p>{{ $employee->phone ?? '-' }}</p></div>
            <div><span class="font-medium text-gray-600">Department:</span>
            <p>{{ $employee->department }}</p></div>
            <div><span class="font-medium text-gray-600">Position:</span>
            <p>{{ $employee->position }}</p></div>
            <div><span class="font-medium text-gray-600">Status:</span>
            <p>{{ ucfirst ($employee->employment_status) }} </p></div>
</div>

<div class="mt-6">
    <a href="{{ route('hr.employees.index') }}"
    class="text-blue-600 hover:underline text-sm">← Back to list </a>
</div>
</div>
</div>
</div>
</x-app-layout>