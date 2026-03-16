<x-app-layout>
    <x-slot name="title">Payroll Report</x-slot>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Payroll Report</h2>
            <div class="flex gap-2">
                <a href="{{ route('hr.reports.export.excel', 'payroll') }}?mon={{ substr($month,5,2) }}&yr={{ substr($month,0,4) }}"
                   class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 text-sm">
                    Export Excel
                </a>
                <a href="{{ route('hr.reports.export.pdf', 'payroll') }}?month={{ $month }}"
                   class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 text-sm">
                    Export PDF
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

            {{-- Filter --}}
            <div class="bg-white shadow-sm rounded-lg p-4">
                <form method="GET" action="{{ route('hr.reports.payroll') }}"
                      class="flex gap-3 items-center">
                    <input type="month" name="month" value="{{ $month }}"
                        class="border-gray-300 rounded-md shadow-sm text-sm">
                    <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-700">
                        Filter
                    </button>
                </form>
            </div>

            {{-- Summary --}}
            <div class="grid grid-cols-3 gap-4">
                <div class="bg-white shadow-sm rounded-lg p-4 text-center">
                    <p class="text-xs text-gray-500 uppercase">Total Gross Pay</p>
                    <p class="text-2xl font-bold text-gray-700">
                        ₱{{ number_format($summary['total_gross'], 2) }}
                    </p>
                </div>
                <div class="bg-white shadow-sm rounded-lg p-4 text-center">
                    <p class="text-xs text-gray-500 uppercase">Total Deductions</p>
                    <p class="text-2xl font-bold text-red-600">
                        ₱{{ number_format($summary['total_deductions'], 2) }}
                    </p>
                </div>
                <div class="bg-white shadow-sm rounded-lg p-4 text-center">
                    <p class="text-xs text-gray-500 uppercase">Total Net Pay</p>
                    <p class="text-2xl font-bold text-green-600">
                        ₱{{ number_format($summary['total_net'], 2) }}
                    </p>
                </div>
            </div>

            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Employee</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Gross Pay</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Deductions</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Net Pay</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($payrolls as $payroll)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                {{ $payroll->employee?->full_name ?? '—' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 text-right">
                                ₱{{ number_format($payroll->gross_pay, 2) }}
                            </td>
                            <td class="px-6 py-4 text-sm text-red-600 text-right">
                                ₱{{ number_format($payroll->total_deductions, 2) }}
                            </td>
                            <td class="px-6 py-4 text-sm font-semibold text-green-700 text-right">
                                ₱{{ number_format($payroll->net_pay, 2) }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                No payroll records found for this period.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>