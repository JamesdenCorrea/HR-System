<x-app-layout>
    <x-slot name="title">Employee Report</x-slot>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Employee Report</h2>
            <div class="flex gap-2">
                <a href="{{ route('hr.reports.export.excel', 'employees') }}"
                   class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 text-sm">
                    Export Excel
                </a>
                <a href="{{ route('hr.reports.export.pdf', 'employees') }}"
                   class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 text-sm">
                    Export PDF
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Filters --}}
            <div class="bg-white shadow-sm rounded-lg p-4 mb-4">
                <form method="GET" action="{{ route('hr.reports.employees') }}"
                      class="flex gap-3 flex-wrap items-center">
                    <select name="department" class="border-gray-300 rounded-md shadow-sm text-sm">
                        <option value="">All Departments</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept }}"
                                {{ request('department') == $dept ? 'selected' : '' }}>
                                {{ $dept }}
                            </option>
                        @endforeach
                    </select>
                    <select name="status" class="border-gray-300 rounded-md shadow-sm text-sm">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="resigned" {{ request('status') == 'resigned' ? 'selected' : '' }}>Resigned</option>
                        <option value="terminated" {{ request('status') == 'terminated' ? 'selected' : '' }}>Terminated</option>
                    </select>
                    <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-700">
                        Filter
                    </button>
                    <a href="{{ route('hr.reports.employees') }}"
                        class="bg-gray-200 text-gray-700 px-4 py-2 rounded text-sm hover:bg-gray-300">
                        Clear
                    </a>
                    <span class="text-gray-500 text-sm ml-auto">
                        {{ $employees->count() }} employee(s) found
                    </span>
                </form>
            </div>

            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Department</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Position</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date Hired</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($employees as $emp)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $emp->employee_id }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $emp->full_name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $emp->department }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $emp->position }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ \Carbon\Carbon::parse($emp->date_hired)->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs rounded-full
                                    {{ $emp->employment_status === 'active'
                                        ? 'bg-green-100 text-green-800'
                                        : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($emp->employment_status) }}
                                </span>
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
            </div>
        </div>
    </div>
</x-app-layout>