<x-app-layout>
    <x-slot name="title">Salary Information</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Salary Information</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
            @endif

            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Employee</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Monthly Salary</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Allowance</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">SSS</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">PhilHealth</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Pag-IBIG</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($employees as $emp)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                {{ $emp->full_name }}<br>
                                <span class="text-xs text-gray-400">{{ $emp->position }}</span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 text-right">
                                ₱{{ number_format($emp->salaryInformation?->monthly_salary ?? 0, 2) }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 text-right">
                                ₱{{ number_format($emp->salaryInformation?->allowance ?? 0, 2) }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 text-right">
                                ₱{{ number_format($emp->salaryInformation?->sss_deduction ?? 0, 2) }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 text-right">
                                ₱{{ number_format($emp->salaryInformation?->philhealth_deduction ?? 0, 2) }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 text-right">
                                ₱{{ number_format($emp->salaryInformation?->pagibig_deduction ?? 0, 2) }}
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <a href="{{ route('hr.payroll.salary-edit', $emp) }}"
                                   class="text-blue-600 hover:underline">Edit</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">
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