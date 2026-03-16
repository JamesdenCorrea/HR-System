<x-app-layout>
    <x-slot name="title">Admin Dashboard</x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Admin Dashboard
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="p-4 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
            @endif

            {{-- Stat Cards --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">

                <div class="bg-white shadow-sm rounded-lg p-5">
                    <p class="text-xs text-gray-500 uppercase tracking-wide">Total Employees</p>
                    <p class="text-3xl font-bold text-blue-600 mt-1">{{ $totalEmployees }}</p>
                    <p class="text-xs text-gray-400 mt-1">+{{ $newThisMonth }} this month</p>
                </div>

                <div class="bg-white shadow-sm rounded-lg p-5">
                    <p class="text-xs text-gray-500 uppercase tracking-wide">Present Today</p>
                    <p class="text-3xl font-bold text-green-600 mt-1">{{ $presentToday }}</p>
                    <p class="text-xs text-gray-400 mt-1">{{ $lateToday }} late</p>
                </div>

                <div class="bg-white shadow-sm rounded-lg p-5">
                    <p class="text-xs text-gray-500 uppercase tracking-wide">Pending Leaves</p>
                    <p class="text-3xl font-bold text-yellow-600 mt-1">{{ $pendingLeaves }}</p>
                    <p class="text-xs text-gray-400 mt-1">{{ $approvedLeaves }} approved this month</p>
                </div>

                <div class="bg-white shadow-sm rounded-lg p-5">
                    <p class="text-xs text-gray-500 uppercase tracking-wide">Payroll Released</p>
                    <p class="text-3xl font-bold text-purple-600 mt-1">
                        ₱{{ number_format($totalPayrollThisMonth, 0) }}
                    </p>
                    <p class="text-xs text-gray-400 mt-1">{{ $draftPayrolls }} drafts pending</p>
                </div>

            </div>

            {{-- Charts Row --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- Department Chart --}}
                <div class="bg-white shadow-sm rounded-lg p-5">
                    <h3 class="font-semibold text-gray-700 mb-4">Employees by Department</h3>
                    <canvas id="deptChart" height="220"></canvas>
                </div>

                {{-- Attendance Chart --}}
                <div class="bg-white shadow-sm rounded-lg p-5">
                    <h3 class="font-semibold text-gray-700 mb-4">Monthly Attendance</h3>
                    <canvas id="attendanceChart" height="220"></canvas>
                </div>

                {{-- Leave Chart --}}
                <div class="bg-white shadow-sm rounded-lg p-5">
                    <h3 class="font-semibold text-gray-700 mb-4">Leaves by Type (This Year)</h3>
                    <canvas id="leaveChart" height="220"></canvas>
                </div>

            </div>

            {{-- Recent Activity Row --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- Recent Employees --}}
                <div class="bg-white shadow-sm rounded-lg p-5">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-semibold text-gray-700">Recent Employees</h3>
                        <a href="{{ route('hr.employees.index') }}"
                           class="text-blue-600 text-xs hover:underline">View all</a>
                    </div>
                    <div class="space-y-3">
                        @forelse($recentEmployees as $emp)
                        <div class="flex items-center justify-between text-sm">
                            <div>
                                <p class="font-medium text-gray-800">{{ $emp->full_name }}</p>
                                <p class="text-gray-400 text-xs">{{ $emp->position }} — {{ $emp->department }}</p>
                            </div>
                            <span class="px-2 py-1 text-xs rounded-full
                                {{ $emp->employment_status === 'active'
                                    ? 'bg-green-100 text-green-800'
                                    : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($emp->employment_status) }}
                            </span>
                        </div>
                        @empty
                        <p class="text-gray-400 text-sm">No employees yet.</p>
                        @endforelse
                    </div>
                </div>

                {{-- Recent Leave Requests --}}
                <div class="bg-white shadow-sm rounded-lg p-5">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-semibold text-gray-700">Recent Leave Requests</h3>
                        <a href="{{ route('hr.leaves.index') }}"
                           class="text-blue-600 text-xs hover:underline">View all</a>
                    </div>
                    <div class="space-y-3">
                        @forelse($recentLeaves as $leave)
                        <div class="flex items-center justify-between text-sm">
                            <div>
                                <p class="font-medium text-gray-800">
                                    {{ $leave->employee?->full_name }}
                                </p>
                                <p class="text-gray-400 text-xs">
                                    {{ ucfirst($leave->leave_type) }} —
                                    {{ $leave->days_requested }} day(s)
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
                </div>

            </div>

        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
    <script>
        // Department Chart
        new Chart(document.getElementById('deptChart'), {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($employeesByDept->keys()) !!},
                datasets: [{
                    data: {!! json_encode($employeesByDept->values()) !!},
                    backgroundColor: [
                        '#3b82f6','#10b981','#f59e0b','#ef4444',
                        '#8b5cf6','#06b6d4','#ec4899','#84cc16'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { position: 'bottom', labels: { font: { size: 11 } } } }
            }
        });

        // Attendance Chart
        new Chart(document.getElementById('attendanceChart'), {
            type: 'bar',
            data: {
                labels: ['Present', 'Late', 'Absent', 'Half Day'],
                datasets: [{
                    label: 'This Month',
                    data: [
                        {{ $monthlyAttendance->get('present', 0) }},
                        {{ $monthlyAttendance->get('late', 0) }},
                        {{ $monthlyAttendance->get('absent', 0) }},
                        {{ $monthlyAttendance->get('half-day', 0) }}
                    ],
                    backgroundColor: ['#10b981','#f59e0b','#ef4444','#3b82f6']
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
            }
        });

        // Leave Chart
        new Chart(document.getElementById('leaveChart'), {
            type: 'pie',
            data: {
                labels: ['Vacation', 'Sick', 'Emergency'],
                datasets: [{
                    data: [
                        {{ $leavesByType->get('vacation', 0) }},
                        {{ $leavesByType->get('sick', 0) }},
                        {{ $leavesByType->get('emergency', 0) }}
                    ],
                    backgroundColor: ['#3b82f6','#10b981','#ef4444']
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { position: 'bottom', labels: { font: { size: 11 } } } }
            }
        });
    </script>
</x-app-layout>