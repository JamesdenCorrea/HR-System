<x-app-layout>
    <x-slot name="title">Edit Salary</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Salary — {{ $employee->full_name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-lg mx-auto sm:px-6 lg:px-8">
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

                <form method="POST" action="{{ route('hr.payroll.salary-update', $employee) }}">
                    @csrf
                    <div class="space-y-4">

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Monthly Salary (₱)</label>
                            <input type="number" name="monthly_salary" step="0.01" min="0"
                                value="{{ old('monthly_salary', $salary->monthly_salary) }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Allowance (₱)</label>
                            <input type="number" name="allowance" step="0.01" min="0"
                                value="{{ old('allowance', $salary->allowance) }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">SSS Deduction (₱)</label>
                            <input type="number" name="sss_deduction" step="0.01" min="0"
                                value="{{ old('sss_deduction', $salary->sss_deduction) }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">PhilHealth Deduction (₱)</label>
                            <input type="number" name="philhealth_deduction" step="0.01" min="0"
                                value="{{ old('philhealth_deduction', $salary->philhealth_deduction) }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Pag-IBIG Deduction (₱)</label>
                            <input type="number" name="pagibig_deduction" step="0.01" min="0"
                                value="{{ old('pagibig_deduction', $salary->pagibig_deduction) }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                    </div>

                    <div class="mt-6 flex gap-3">
                        <button type="submit"
                            class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                            Save
                        </button>
                        <a href="{{ route('hr.payroll.salary-index') }}"
                            class="bg-gray-200 text-gray-700 px-6 py-2 rounded hover:bg-gray-300">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>