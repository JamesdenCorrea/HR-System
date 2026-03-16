<x-app-layout>
    <x-slot name="title">Payslip Details</x-slot>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Payslip Details</h2>
            <div class="flex gap-2">
                @if($payroll->status === 'draft')
                    <form method="POST" action="{{ route('hr.payroll.release', $payroll) }}">
                        @csrf
                        <button type="submit"
                            class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 text-sm"
                            onclick="return confirm('Release this payroll?')">
                            Release Payroll
                        </button>
                    </form>
                @endif
                <a href="{{ route('hr.payroll.pdf', $payroll) }}"
                   class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 text-sm">
                    Download PDF
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
            @endif

            <div class="bg-white shadow-sm rounded-lg p-6">

                {{-- Header --}}
                <div class="text-center mb-6">
                    <h3 class="text-lg font-bold text-gray-800">PAYSLIP</h3>
                    <p class="text-gray-500 text-sm">{{ $payroll->period_label }}</p>
                    <p class="text-gray-500 text-sm">
                        {{ $payroll->period_start->format('F d') }} —
                        {{ $payroll->period_end->format('F d, Y') }}
                    </p>
                </div>

                {{-- Employee Info --}}
                <div class="grid grid-cols-2 gap-4 text-sm mb-6 p-4 bg-gray-50 rounded-lg">
                    <div>
                        <p class="text-gray-500">Employee Name</p>
                        <p class="font-semibold">{{ $payroll->employee?->full_name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Employee ID</p>
                        <p class="font-semibold">{{ $payroll->employee?->employee_id }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Department</p>
                        <p class="font-semibold">{{ $payroll->employee?->department }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Position</p>
                        <p class="font-semibold">{{ $payroll->employee?->position }}</p>
                    </div>
                </div>

                {{-- Earnings & Deductions --}}
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <h4 class="font-semibold text-gray-700 border-b pb-2 mb-3">Earnings</h4>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Basic Salary</span>
                                <span>₱{{ number_format($payroll->basic_salary, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Allowance</span>
                                <span>₱{{ number_format($payroll->allowance, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Overtime Pay</span>
                                <span>₱{{ number_format($payroll->overtime_pay, 2) }}</span>
                            </div>
                            <div class="flex justify-between font-semibold border-t pt-2">
                                <span>Gross Pay</span>
                                <span>₱{{ number_format($payroll->gross_pay, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h4 class="font-semibold text-gray-700 border-b pb-2 mb-3">Deductions</h4>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">SSS</span>
                                <span>₱{{ number_format($payroll->sss_deduction, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">PhilHealth</span>
                                <span>₱{{ number_format($payroll->philhealth_deduction, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Pag-IBIG</span>
                                <span>₱{{ number_format($payroll->pagibig_deduction, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tax</span>
                                <span>₱{{ number_format($payroll->tax_deduction, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Other</span>
                                <span>₱{{ number_format($payroll->other_deductions, 2) }}</span>
                            </div>
                            <div class="flex justify-between font-semibold border-t pt-2 text-red-600">
                                <span>Total Deductions</span>
                                <span>₱{{ number_format($payroll->total_deductions, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Net Pay --}}
                <div class="mt-6 p-4 bg-green-50 border border-green-200 rounded-lg text-center">
                    <p class="text-gray-600 text-sm">NET PAY</p>
                    <p class="text-3xl font-bold text-green-700">
                        ₱{{ number_format($payroll->net_pay, 2) }}
                    </p>
                </div>

                <div class="mt-4 flex justify-between items-center text-sm">
                    <span class="px-2 py-1 text-xs rounded-full
                        {{ $payroll->status === 'released'
                            ? 'bg-green-100 text-green-800'
                            : 'bg-yellow-100 text-yellow-800' }}">
                        {{ ucfirst($payroll->status) }}
                    </span>
                    <a href="{{ route('hr.payroll.index') }}"
                       class="text-blue-600 hover:underline">
                        ← Back to Payroll
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>