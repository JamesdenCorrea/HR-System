<x-app-layout>
    <x-slot name="title">My Dashboard</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            My Dashboard
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="p-4 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
            @endif

            {{-- Welcome Card --}}
            <div class="bg-white shadow-sm rounded-lg p-6">
                <div class="flex items-center gap-4">
                    @if($employee?->profile_photo)
                        <img src="{{ Storage::url($employee->profile_photo) }}"
                             class="w-16 h-16 rounded-full object-cover">
                    @else
                        <div class="w-16 h-16 rounded-full bg-blue-100 flex items-center justify-center">
                            <span class="text-blue-600 font-bold text-xl">
                                {{ substr($employee?->first_name ?? 'U', 0, 1) }}
                            </span>
                        </div>
                    @endif
                    <div>
                        <h3 class="font-semibold text-gray-800 text-lg">
                            Welcome, {{ $employee?->full_name ?? auth()->user()->name }}!
                        </h3>
                        <p class="text-gray-500 text-sm">
                            {{ $employee?->position }} — {{ $employee?->department }}
                        </p>
                        <p class="text-gray-400 text-xs mt-1">
                            {{ now()->format('l, F d, Y') }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Today's Attendance --}}
            <div class="bg-white shadow-sm rounded-lg p-6">
                <h3 class="font-semibold text-gray-700 mb-4">Today's Attendance</h3>
                <div class="grid grid-cols-3 gap-4 text-center text-sm">
                    <div class="bg-gray-50 rounded p-3">
                        <p class="text-gray-500 text-xs">Clock In</p>
                        <p class="font-semibold text-gray-800 text-lg">
                            {{ $todayAttendance?->clock_in
                                ? \Carbon\Carbon::parse($todayAttendance->clock_in)->format('h:i A')
                                : '—' }}
                        </p>
                    </div>
                    <div class="bg-gray-50 rounded p-3">
                        <p class="text-gray-500 text-xs">Clock Out</p>
                        <p class="font-semibold text-gray-800 text-lg">
                            {{ $todayAttendance?->clock_out
                                ? \Carbon\Carbon::parse($todayAttendance->clock_out)->format('h:i A')
                                : '—' }}
                        </p>
                    </div>
                    <div class="bg-gray-50 rounded p-3">
                        <p class="text-gray-500 text-xs">Status</p>
                        <p class="font-semibold text-gray-800">
                            {{ $todayAttendance ? ucfirst($todayAttendance->status) : 'Not yet clocked in' }}
                        </p>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('attendance.clock') }}"
                       class="block text-center bg-blue-600 text-white py-2 rounded hover:bg-blue-700 text-sm">
                        Go to Attendance
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- Recent Leave Requests --}}
                <div class="bg-white shadow-sm rounded-lg p-5">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-semibold text-gray-700">My Leave Requests</h3>
                        <a href="{{ route('leaves.my') }}"
                           class="text-blue-600 text-xs hover:underline">View all</a>
                    </div>
                    <div class="space-y-3">
                        @forelse($myLeaves as $leave)
                        <div class="flex items-center justify-between text-sm">
                            <div>
                                <p class="font-medium text-gray-800">
                                    {{ ucfirst($leave->leave_type) }} Leave
                                </p>
                                <p class="text-gray-400 text-xs">
                                    {{ $leave->start_date->format('M d') }} —
                                    {{ $leave->end_date->format('M d, Y') }}
                                    ({{ $leave->days_requested }} day(s))
                                </p>
                            </div>
                            <span class="px-2 py-1 text-xs rounded-full {{ $leave->status_badge }}">
                                {{ ucfirst($leave->status) }}
                            </span>
                        </div>
                        @empty
                        <p class="text-gray-400 text-sm">No leave requests yet.</p>
                        @endforelse
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('leaves.create') }}"
                           class="block text-center bg-green-600 text-white py-2 rounded hover:bg-green-700 text-sm">
                            + File Leave Request
                        </a>
                    </div>
                </div>

                {{-- Recent Payslips --}}
                <div class="bg-white shadow-sm rounded-lg p-5">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-semibold text-gray-700">My Recent Payslips</h3>
                        <a href="{{ route('payroll.my-payslips') }}"
                           class="text-blue-600 text-xs hover:underline">View all</a>
                    </div>
                    <div class="space-y-3">
                        @forelse($myPayslips as $payslip)
                        <div class="flex items-center justify-between text-sm">
                            <div>
                                <p class="font-medium text-gray-800">{{ $payslip->period_label }}</p>
                                <p class="text-gray-400 text-xs">
                                    Net Pay:
                                    <span class="text-green-600 font-semibold">
                                        ₱{{ number_format($payslip->net_pay, 2) }}
                                    </span>
                                </p>
                            </div>
                            <a href="{{ route('hr.payroll.pdf', $payslip) }}"
                               class="text-blue-600 text-xs hover:underline">
                                Download
                            </a>
                        </div>
                        @empty
                        <p class="text-gray-400 text-sm">No payslips available yet.</p>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>