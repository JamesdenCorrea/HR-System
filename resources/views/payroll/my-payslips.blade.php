<x-app-layout>
    <x-slot name="title">My Payslips</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">My Payslips</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Period</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Gross Pay</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Deductions</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Net Pay</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($payrolls as $payroll)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                {{ $payroll->period_label }}<br>
                                <span class="text-xs text-gray-400">
                                    {{ $payroll->period_start->format('M d') }} —
                                    {{ $payroll->period_end->format('M d, Y') }}
                                </span>
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
                            <td class="px-6 py-4 text-sm">
                                <a href="{{ route('hr.payroll.pdf', $payroll) }}"
                                   class="text-blue-600 hover:underline">
                                    Download Payslip
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                No payslips available yet.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="px-6 py-4">{{ $payrolls->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>