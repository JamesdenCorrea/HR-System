<x-app-layout>
    <x-slot name="title">Generate Payroll</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Generate Payroll</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">

                @if($errors->any())
                    <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
                        <ul class="list-disc list-inside text-sm">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('hr.payroll.store') }}" id="payroll-form">
                    @csrf
                    <div class="grid grid-cols-2 gap-4">

                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Employee</label>
                            <select name="employee_id" id="employee-select"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                onchange="loadSalaryInfo(this)">
                                <option value="">Select Employee</option>
                                @foreach($employees as $emp)
                                    <option value="{{ $emp->id }}"
                                        data-salary="{{ $emp->salaryInformation?->monthly_salary ?? 0 }}"
                                        data-allowance="{{ $emp->salaryInformation?->allowance ?? 0 }}"
                                        data-sss="{{ $emp->salaryInformation?->sss_deduction ?? 0 }}"
                                        data-philhealth="{{ $emp->salaryInformation?->philhealth_deduction ?? 0 }}"
                                        data-pagibig="{{ $emp->salaryInformation?->pagibig_deduction ?? 0 }}"
                                        {{ old('employee_id') == $emp->id ? 'selected' : '' }}>
                                        {{ $emp->full_name }} ({{ $emp->employee_id }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Period Start</label>
                            <input type="date" name="period_start" value="{{ old('period_start') }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Period End</label>
                            <input type="date" name="period_end" value="{{ old('period_end') }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        {{-- Earnings --}}
                        <div class="col-span-2 mt-2">
                            <h3 class="font-semibold text-gray-700 border-b pb-2">Earnings</h3>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Basic Salary (₱)</label>
                            <input type="number" name="basic_salary" id="basic_salary"
                                value="{{ old('basic_salary', 0) }}" step="0.01" min="0"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                oninput="calculateNet()">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Allowance (₱)</label>
                            <input type="number" name="allowance" id="allowance"
                                value="{{ old('allowance', 0) }}" step="0.01" min="0"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                oninput="calculateNet()">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Overtime Pay (₱)</label>
                            <input type="number" name="overtime_pay" id="overtime_pay"
                                value="{{ old('overtime_pay', 0) }}" step="0.01" min="0"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                oninput="calculateNet()">
                        </div>

                        {{-- Deductions --}}
                        <div class="col-span-2 mt-2">
                            <h3 class="font-semibold text-gray-700 border-b pb-2">Deductions</h3>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">SSS (₱)</label>
                            <input type="number" name="sss_deduction" id="sss_deduction"
                                value="{{ old('sss_deduction', 0) }}" step="0.01" min="0"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                oninput="calculateNet()">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">PhilHealth (₱)</label>
                            <input type="number" name="philhealth_deduction" id="philhealth_deduction"
                                value="{{ old('philhealth_deduction', 0) }}" step="0.01" min="0"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                oninput="calculateNet()">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Pag-IBIG (₱)</label>
                            <input type="number" name="pagibig_deduction" id="pagibig_deduction"
                                value="{{ old('pagibig_deduction', 0) }}" step="0.01" min="0"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                oninput="calculateNet()">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tax (₱)</label>
                            <input type="number" name="tax_deduction" id="tax_deduction"
                                value="{{ old('tax_deduction', 0) }}" step="0.01" min="0"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                oninput="calculateNet()">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Other Deductions (₱)</label>
                            <input type="number" name="other_deductions" id="other_deductions"
                                value="{{ old('other_deductions', 0) }}" step="0.01" min="0"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                oninput="calculateNet()">
                        </div>

                        {{-- Summary --}}
                        <div class="col-span-2 mt-4 bg-gray-50 rounded-lg p-4">
                            <div class="grid grid-cols-3 gap-4 text-center">
                                <div>
                                    <p class="text-xs text-gray-500 uppercase">Gross Pay</p>
                                    <p class="text-xl font-bold text-gray-800" id="gross-display">₱0.00</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 uppercase">Total Deductions</p>
                                    <p class="text-xl font-bold text-red-600" id="deductions-display">₱0.00</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 uppercase">Net Pay</p>
                                    <p class="text-xl font-bold text-green-700" id="net-display">₱0.00</p>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="mt-6 flex gap-3">
                        <button type="submit"
                            class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                            Save Payroll
                        </button>
                        <a href="{{ route('hr.payroll.index') }}"
                            class="bg-gray-200 text-gray-700 px-6 py-2 rounded hover:bg-gray-300">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function loadSalaryInfo(select) {
            const opt = select.options[select.selectedIndex];
            document.getElementById('basic_salary').value        = opt.dataset.salary || 0;
            document.getElementById('allowance').value           = opt.dataset.allowance || 0;
            document.getElementById('sss_deduction').value       = opt.dataset.sss || 0;
            document.getElementById('philhealth_deduction').value = opt.dataset.philhealth || 0;
            document.getElementById('pagibig_deduction').value   = opt.dataset.pagibig || 0;
            calculateNet();
        }

        function calculateNet() {
            const basic = parseFloat(document.getElementById('basic_salary').value) || 0;
            const allow = parseFloat(document.getElementById('allowance').value) || 0;
            const ot    = parseFloat(document.getElementById('overtime_pay').value) || 0;
            const sss   = parseFloat(document.getElementById('sss_deduction').value) || 0;
            const ph    = parseFloat(document.getElementById('philhealth_deduction').value) || 0;
            const pag   = parseFloat(document.getElementById('pagibig_deduction').value) || 0;
            const tax   = parseFloat(document.getElementById('tax_deduction').value) || 0;
            const other = parseFloat(document.getElementById('other_deductions').value) || 0;

            const gross      = basic + allow + ot;
            const deductions = sss + ph + pag + tax + other;
            const net        = gross - deductions;

            document.getElementById('gross-display').textContent =
                '₱' + gross.toLocaleString('en-PH', {minimumFractionDigits: 2});
            document.getElementById('deductions-display').textContent =
                '₱' + deductions.toLocaleString('en-PH', {minimumFractionDigits: 2});
            document.getElementById('net-display').textContent =
                '₱' + net.toLocaleString('en-PH', {minimumFractionDigits: 2});
        }

        calculateNet();
    </script>
</x-app-layout>