<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\Leave;
use App\Models\LeaveBalance;
use App\Models\Payroll;
use App\Models\SalaryInformation;
use App\Models\AccountRequest;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        // ── EMPLOYEES ──────────────────────────────────────────────
        $employeesData = [
            [
                'user'     => ['name' => 'Maria Santos',     'email' => 'maria.santos@hr.com'],
                'employee' => [
                    'employee_id' => 'EMP-003',
                    'first_name'  => 'Maria',
                    'last_name'   => 'Santos',
                    'email'       => 'maria.santos@hr.com',
                    'phone'       => '+63 912 111 0001',
                    'department'  => 'Finance',
                    'position'    => 'Accountant',
                    'date_hired'  => '2022-03-15',
                ],
            ],
            [
                'user'     => ['name' => 'Jose Reyes',       'email' => 'jose.reyes@hr.com'],
                'employee' => [
                    'employee_id' => 'EMP-004',
                    'first_name'  => 'Jose',
                    'last_name'   => 'Reyes',
                    'email'       => 'jose.reyes@hr.com',
                    'phone'       => '+63 912 111 0002',
                    'department'  => 'IT Department',
                    'position'    => 'System Analyst',
                    'date_hired'  => '2021-07-01',
                ],
            ],
            [
                'user'     => ['name' => 'Ana Cruz',         'email' => 'ana.cruz@hr.com'],
                'employee' => [
                    'employee_id' => 'EMP-005',
                    'first_name'  => 'Ana',
                    'last_name'   => 'Cruz',
                    'email'       => 'ana.cruz@hr.com',
                    'phone'       => '+63 912 111 0003',
                    'department'  => 'Marketing',
                    'position'    => 'Marketing Specialist',
                    'date_hired'  => '2023-01-10',
                ],
            ],
            [
                'user'     => ['name' => 'Roberto Dela Cruz', 'email' => 'roberto.delacruz@hr.com'],
                'employee' => [
                    'employee_id' => 'EMP-006',
                    'first_name'  => 'Roberto',
                    'last_name'   => 'Dela Cruz',
                    'email'       => 'roberto.delacruz@hr.com',
                    'phone'       => '+63 912 111 0004',
                    'department'  => 'Operations',
                    'position'    => 'Operations Manager',
                    'date_hired'  => '2020-05-20',
                ],
            ],
            [
                'user'     => ['name' => 'Liza Gonzales',    'email' => 'liza.gonzales@hr.com'],
                'employee' => [
                    'employee_id' => 'EMP-007',
                    'first_name'  => 'Liza',
                    'last_name'   => 'Gonzales',
                    'email'       => 'liza.gonzales@hr.com',
                    'phone'       => '+63 912 111 0005',
                    'department'  => 'Finance',
                    'position'    => 'Finance Manager',
                    'date_hired'  => '2019-11-01',
                ],
            ],
            [
                'user'     => ['name' => 'Carlos Mendoza',   'email' => 'carlos.mendoza@hr.com'],
                'employee' => [
                    'employee_id' => 'EMP-008',
                    'first_name'  => 'Carlos',
                    'last_name'   => 'Mendoza',
                    'email'       => 'carlos.mendoza@hr.com',
                    'phone'       => '+63 912 111 0006',
                    'department'  => 'IT Department',
                    'position'    => 'Network Engineer',
                    'date_hired'  => '2022-08-15',
                ],
            ],
            [
                'user'     => ['name' => 'Patricia Villanueva', 'email' => 'patricia.villanueva@hr.com'],
                'employee' => [
                    'employee_id' => 'EMP-009',
                    'first_name'  => 'Patricia',
                    'last_name'   => 'Villanueva',
                    'email'       => 'patricia.villanueva@hr.com',
                    'phone'       => '+63 912 111 0007',
                    'department'  => 'Marketing',
                    'position'    => 'Graphic Designer',
                    'date_hired'  => '2023-04-01',
                ],
            ],
            [
                'user'     => ['name' => 'Michael Torres',   'email' => 'michael.torres@hr.com'],
                'employee' => [
                    'employee_id' => 'EMP-010',
                    'first_name'  => 'Michael',
                    'last_name'   => 'Torres',
                    'email'       => 'michael.torres@hr.com',
                    'phone'       => '+63 912 111 0008',
                    'department'  => 'Operations',
                    'position'    => 'Logistics Coordinator',
                    'date_hired'  => '2021-02-14',
                ],
            ],
            [
                'user'     => ['name' => 'Sandra Flores',    'email' => 'sandra.flores@hr.com'],
                'employee' => [
                    'employee_id' => 'EMP-011',
                    'first_name'  => 'Sandra',
                    'last_name'   => 'Flores',
                    'email'       => 'sandra.flores@hr.com',
                    'phone'       => '+63 912 111 0009',
                    'department'  => 'Human Resources',
                    'position'    => 'HR Assistant',
                    'date_hired'  => '2023-06-01',
                ],
            ],
            [
                'user'     => ['name' => 'Benjamin Ramos',   'email' => 'benjamin.ramos@hr.com'],
                'employee' => [
                    'employee_id' => 'EMP-012',
                    'first_name'  => 'Benjamin',
                    'last_name'   => 'Ramos',
                    'email'       => 'benjamin.ramos@hr.com',
                    'phone'       => '+63 912 111 0010',
                    'department'  => 'IT Department',
                    'position'    => 'Junior Developer',
                    'date_hired'  => '2024-01-15',
                ],
            ],
        ];

        $salaries = [
            25000, 35000, 28000, 45000,
            50000, 38000, 26000, 32000,
            24000, 22000,
        ];

        $createdEmployees = [];

        foreach ($employeesData as $index => $data) {
            $user = User::create([
                'name'     => $data['user']['name'],
                'email'    => $data['user']['email'],
                'password' => Hash::make('password'),
            ]);
            $user->assignRole('employee');

            $employee = Employee::create(array_merge($data['employee'], [
                'user_id'           => $user->id,
                'employment_status' => 'active',
            ]));

            $monthlySalary = $salaries[$index];
            $sss           = round($monthlySalary * 0.045, 2);
            $philhealth    = round($monthlySalary * 0.02, 2);
            $pagibig       = 100;

            SalaryInformation::create([
                'employee_id'          => $employee->id,
                'monthly_salary'       => $monthlySalary,
                'allowance'            => 2000,
                'sss_deduction'        => $sss,
                'philhealth_deduction' => $philhealth,
                'pagibig_deduction'    => $pagibig,
            ]);

            LeaveBalance::create([
                'employee_id'     => $employee->id,
                'year'            => now()->year,
                'vacation_total'  => 15,
                'vacation_used'   => rand(0, 5),
                'sick_total'      => 15,
                'sick_used'       => rand(0, 3),
                'emergency_total' => 5,
                'emergency_used'  => rand(0, 2),
            ]);

            $createdEmployees[] = $employee;
        }

        // ── ATTENDANCE (last 15 days for each employee) ────────────
        $attendanceStatuses = ['present', 'present', 'present', 'late', 'present', 'present', 'late', 'present', 'absent', 'present', 'present', 'present', 'late', 'present', 'present'];

        foreach ($createdEmployees as $employee) {
            for ($i = 14; $i >= 0; $i--) {
                $date = Carbon::today()->subDays($i);

                // Skip weekends
                if ($date->isWeekend()) continue;

                $status  = $attendanceStatuses[$i];
                $clockIn = $status === 'absent'
                    ? null
                    : ($status === 'late'
                        ? Carbon::parse($date->format('Y-m-d') . ' 09:' . rand(10, 59) . ':00')
                        : Carbon::parse($date->format('Y-m-d') . ' 08:' . rand(0, 59) . ':00'));

                $clockOut = $status === 'absent'
                    ? null
                    : Carbon::parse($date->format('Y-m-d') . ' 17:' . rand(0, 59) . ':00');

                Attendance::create([
                    'employee_id' => $employee->id,
                    'date'        => $date->format('Y-m-d'),
                    'clock_in'    => $clockIn?->format('H:i:s'),
                    'clock_out'   => $clockOut?->format('H:i:s'),
                    'status'      => $status,
                    'ip_address'  => '127.0.0.1',
                ]);
            }
        }

        // ── LEAVE REQUESTS ─────────────────────────────────────────
        $leaveTypes    = ['vacation', 'sick', 'emergency', 'vacation', 'sick', 'vacation', 'sick', 'emergency', 'vacation', 'sick'];
        $leaveStatuses = ['approved', 'approved', 'pending', 'approved', 'rejected', 'pending', 'approved', 'approved', 'pending', 'approved'];
        $leaveReasons  = [
            'Family vacation trip',
            'Not feeling well, fever and colds',
            'Family emergency',
            'Pre-planned vacation leave',
            'Medical appointment',
            'Out of town trip',
            'Flu and rest needed',
            'Immediate family concern',
            'Annual leave',
            'Sick and under medication',
        ];

        foreach ($createdEmployees as $index => $employee) {
            $startDate = Carbon::today()->subDays(rand(5, 30));
            $endDate   = (clone $startDate)->addDays(rand(1, 3));

            Leave::create([
                'employee_id'    => $employee->id,
                'leave_type'     => $leaveTypes[$index],
                'start_date'     => $startDate->format('Y-m-d'),
                'end_date'       => $endDate->format('Y-m-d'),
                'days_requested' => $startDate->diffInWeekdays($endDate) + 1,
                'reason'         => $leaveReasons[$index],
                'status'         => $leaveStatuses[$index],
                'approved_by'    => in_array($leaveStatuses[$index], ['approved', 'rejected']) ? 2 : null,
            ]);
        }

        // ── PAYROLL (current month) ─────────────────────────────────
        $adminUser = User::where('email', 'admin@hr.com')->first();

        foreach ($createdEmployees as $employee) {
            $salary      = $employee->salaryInformation;
            $basic       = $salary->monthly_salary;
            $allowance   = $salary->allowance;
            $sss         = $salary->sss_deduction;
            $philhealth  = $salary->philhealth_deduction;
            $pagibig     = $salary->pagibig_deduction;
            $tax         = round($basic * 0.02, 2);
            $gross       = $basic + $allowance;
            $deductions  = $sss + $philhealth + $pagibig + $tax;
            $net         = $gross - $deductions;

            Payroll::create([
                'employee_id'          => $employee->id,
                'period_label'         => Carbon::now()->format('F Y'),
                'period_start'         => Carbon::now()->startOfMonth()->format('Y-m-d'),
                'period_end'           => Carbon::now()->endOfMonth()->format('Y-m-d'),
                'basic_salary'         => $basic,
                'allowance'            => $allowance,
                'overtime_pay'         => 0,
                'sss_deduction'        => $sss,
                'philhealth_deduction' => $philhealth,
                'pagibig_deduction'    => $pagibig,
                'tax_deduction'        => $tax,
                'other_deductions'     => 0,
                'gross_pay'            => $gross,
                'total_deductions'     => $deductions,
                'net_pay'              => $net,
                'status'               => 'released',
                'created_by'           => $adminUser?->id ?? 1,
            ]);
        }

        // ── ACCOUNT REQUESTS ───────────────────────────────────────
        $accountRequests = [
            ['name' => 'Diana Prince',    'email' => 'diana.prince@company.com',    'role' => 'employee', 'department' => 'Finance',        'position' => 'Finance Analyst',    'status' => 'pending'],
            ['name' => 'Bruce Wayne',     'email' => 'bruce.wayne@company.com',     'role' => 'hr',       'department' => 'Human Resources', 'position' => 'HR Specialist',      'status' => 'pending'],
            ['name' => 'Clark Kent',      'email' => 'clark.kent@company.com',      'role' => 'employee', 'department' => 'IT Department',   'position' => 'QA Engineer',        'status' => 'approved'],
            ['name' => 'Barry Allen',     'email' => 'barry.allen@company.com',     'role' => 'employee', 'department' => 'Operations',      'position' => 'Operations Staff',   'status' => 'pending'],
            ['name' => 'Arthur Curry',    'email' => 'arthur.curry@company.com',    'role' => 'employee', 'department' => 'Marketing',       'position' => 'Content Writer',     'status' => 'rejected'],
            ['name' => 'Hal Jordan',      'email' => 'hal.jordan@company.com',      'role' => 'hr',       'department' => 'Human Resources', 'position' => 'HR Coordinator',     'status' => 'pending'],
            ['name' => 'Victor Stone',    'email' => 'victor.stone@company.com',    'role' => 'employee', 'department' => 'IT Department',   'position' => 'Data Analyst',       'status' => 'approved'],
            ['name' => 'Dinah Lance',     'email' => 'dinah.lance@company.com',     'role' => 'employee', 'department' => 'Finance',        'position' => 'Budget Analyst',     'status' => 'pending'],
            ['name' => 'Oliver Queen',    'email' => 'oliver.queen@company.com',    'role' => 'employee', 'department' => 'Operations',      'position' => 'Project Coordinator','status' => 'pending'],
            ['name' => 'Kara Danvers',    'email' => 'kara.danvers@company.com',    'role' => 'employee', 'department' => 'Marketing',       'position' => 'Social Media Manager','status' => 'approved'],
        ];

        $hrUser = User::where('email', 'hr@hr.com')->first();

        foreach ($accountRequests as $req) {
            AccountRequest::create([
                'name'             => $req['name'],
                'email'            => $req['email'],
                'role'             => $req['role'],
                'department'       => $req['department'],
                'position'         => $req['position'],
                'status'           => $req['status'],
                'requested_by'     => $hrUser?->id ?? 2,
                'processed_by'     => in_array($req['status'], ['approved', 'rejected'])
                                        ? ($adminUser?->id ?? 1)
                                        : null,
                'rejection_reason' => $req['status'] === 'rejected'
                                        ? 'Position not yet available'
                                        : null,
            ]);
        }
    }
}