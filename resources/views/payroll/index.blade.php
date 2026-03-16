<x-app-layout>
    <x-slot name="title">Payroll</x-slot>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Payroll Records</h2>
            <div class="flex gap-2">
                <a href="{{ route('hr.payroll.salary-index') }}"
                class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 text-sm">
                Salary Information
</a>
<a href="{{ route('hr.payroll.create') }} "
class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">
+ Generate Payroll
</a>
</div>
</div>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
        @endif

        {{-- Filters --}}
        <div class="bg-white shadowm-sm rounded-lg p-4 mb-4">
            <form method="GET" action="{{ route('hr.payroll.index') }}"
            class="flex gap-3 flex-wrap items-center">

            <select name="period_label" class="border-gray-300 rounded-md shadow-sm text-sm">
                <option value="">All Periods</option>
                @foreach($periods as $period)
                <option value="{{ $period }}"
                {{ request('period') == $period ? 'selected' : '' }}>
                {{ $period }}
</option>
@endforeach
</select>

            <select name="employee_id" class="border-gray-300 rounded-md shadow-sm text-sm">
                <option value="">All Employees </option>
                @foreach($employees as $emp)
                <option value="{{ $emp->id }}"
                {{ request('employee_id') == $emp->id ? 'selected' : '' }}>
                {{ $emp->full_name }}
</option>
@endforeach
</select>

            <select name="status" class="border-gray-300 rounded-md shadow-sm text-sm">
                <option value="">All Status</option>
                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}> Draft</option>
                <option value="released" {{ request('status') == 'released' ? 'selected' : '' }}>Released </option>
</select>

<button type="submit"
class="bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-700">
Filter
</button>
<a href="{{ route('hr.payroll.index') }}"
class="bg-gray-200 text-gray-700 px-4 py-2 rounded text-sm hover:bg-gray-300">
Clear
</a>
</form>
</div>

            <div class="bg-white shadow-smr rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Employee</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Period</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Gross Pay</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Deductions</th>
                            <th clas="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Net Pay</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Action</th>
</tr>
</thead>
<tbody class="bg-white divide-y divide-gray-200">
    @forelse($payrolls as $payroll)
    <tr>
        <td class="px-6 py-4 text-sm text-gray-900">
            {{ $payroll->employee?->full_name }}
</td>
        <td class="px-6 py-4 text-sm text-gray-600"> {{ $payroll->period_label }}</td>
        <td class="px-6 py-4 text-sm text-gray-600 text-right">
             ₱{{ number_format($payroll->gross_pay, 2) }}
</td>
        <td class="px-6 py-4 text-sm text-red-600 text-right">
            ₱{{ number_format($payroll->total_deductions, 2) }}
</td>
        <td class="px-6 py-4 text-sm font-semibold text-green-700 text-right">
            ₱{{ number_format($payroll->net_pay, 2) }}
</td>
        <td class="px-6 py-4">
            <span class="px-2 py-1 text-xs rounded-full
            {{ $payroll->status === 'released'
             ? 'bg-green-100 text-green-800'
             : 'bg-yellow-100 text-yellow-800' }} ">
             {{ ucfirst($payroll->status) }}
</span>
</td>
        <td class="px-6 py-4 text-sm space-x-2">
            <a href="{{ route('hr.payroll.show', $payroll) }}"
            class="text-blue-600 hover:underline">View</a>

            @if($payroll->status === 'draft')
            <form method="POST"
            action="{{ route('hr.payroll.release', $payroll) }}"
            class="inline">
            @csrf
            <button type="submit"
            class="text-green-600 hover:underline"
            onclick="return confirm('Release this payroll?')">
            Release
</button>
</form>
@endif

        <a href="{{ route('hr.payroll.pdf', $payroll) }}"
        class="text-gray-600 hover:underline">
        Download PDF
</a>
</td>
</tr>
@empty
<tr>
    <td colspan="7" class="px-6 py-4 text-center text-gray-500">
        No payroll records found.
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
