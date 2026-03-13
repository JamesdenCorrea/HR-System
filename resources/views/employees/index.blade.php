<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Employees</h2>
            <a href="{{route('hr.employees.create')}}"
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">
            + Add Employee
</a>
</div>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

    @if(session('success'))
    <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
        {{ session('success')}}
</div>
@endif

<div class="bg-white shadow-sm rounded-lg overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium  text-gray-500 uppercase">ID</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Department</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Position</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
</tr>
</thead>
<tbod class="bg-white divide-y divide-gray-200">
    @forelse($employees as $employee)
    <tr>
        <td class="px-6 py-4 text-sm text-gray-900">{{$employee->employee_id}}</td>
        <td class="px-6 py-4 text-sm text-gray-900">{{$employee->full_name}}</td>
        <td class="px-6 py-4 text-sm text-gray-900">{{$employee->department}}</td>
        <td class="px-6 py-4 text-sm text-gray-900">{{$employee->position}}</td>
        <td class="px-6 py-4">
            <span class="px-2 py-1 text-xs rounded-full
            {{$employee->employment_status === 'active'
            ? 'bg_green-100 text-green-800'
            : 'bg-red-100 text-red-800'}}">
            {{ucfirst($employee->employment_status)}}
</span>
</td>
<td class="px-6 py-4 text-sm space-x-2">
    <a href="{{ route('hr.employees.show', $employee) }}"
    class="text-yellow-600 hover:underline">View</a>
    <a href="{{route('hr.employees.edit', $employee) }}"
    class="yext-yellow-600 hover:underline">Edit</a>
    <form action="{{route('hr.employees.destroy', $employee) }}"
    method="POST" class="inline"
    onsubmit="return confirm('Delete this employee?')">
    @csrf
    @method('DELETE')
    <button class="text-red-600 hover:underline">Delete</button>
</form>
</td>
</tr>
@empty
<tr>
    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
        No employees found.
</td>
</tr>
@endforelse
</tbody>
</table>
<div class="px-6 py-4">
    {{$employees->links()}}
</div>
</div>
</div>
</div>
</x-app-layout>
