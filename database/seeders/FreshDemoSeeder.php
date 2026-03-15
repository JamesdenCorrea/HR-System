<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Employee;
use App\Models\LeaveBalance;
use Illuminate\Support\Facades\Hash;

class FreshDemoSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        $admin = User::create([
            'name'     => 'Admin User',
            'email'    => 'admin@hr.com',
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole('admin');

        // HR user
        $hr = User::create([
            'name'     => 'HR Manager',
            'email'    => 'hr@hr.com',
            'password' => Hash::make('password'),
        ]);
        $hr->assignRole('hr');

        // Employee user
        $empUser = User::create([
            'name'     => 'Jamesden Correa',
            'email'    => 'employee@hr.com',
            'password' => Hash::make('password'),
        ]);
        $empUser->assignRole('employee');

        // Admin employee record
        $adminEmployee = Employee::create([
            'employee_id'       => 'EMP-000',
            'user_id'           => $admin->id,
            'first_name'        => 'Admin',
            'last_name'         => 'User',
            'email'             => 'admin@hr.com',
            'phone'             => '+63 912 000 0000',
            'department'        => 'Management',
            'position'          => 'System Administrator',
            'date_hired'        => '2023-01-01',
            'employment_status' => 'active',
        ]);

        LeaveBalance::create([
            'employee_id'     => $adminEmployee->id,
            'year'            => now()->year,
            'vacation_total'  => 15, 'vacation_used'  => 0,
            'sick_total'      => 15, 'sick_used'      => 0,
            'emergency_total' => 5,  'emergency_used' => 0,
        ]);

        // HR employee record
        $hrEmployee = Employee::create([
            'employee_id'       => 'EMP-001',
            'user_id'           => $hr->id,
            'first_name'        => 'HR',
            'last_name'         => 'Manager',
            'email'             => 'hr@hr.com',
            'phone'             => '+63 912 000 0001',
            'department'        => 'Human Resources',
            'position'          => 'HR Manager',
            'date_hired'        => '2023-01-01',
            'employment_status' => 'active',
        ]);

        LeaveBalance::create([
            'employee_id'     => $hrEmployee->id,
            'year'            => now()->year,
            'vacation_total'  => 15, 'vacation_used'  => 0,
            'sick_total'      => 15, 'sick_used'      => 0,
            'emergency_total' => 5,  'emergency_used' => 0,
        ]);

        // Employee record
        $employee = Employee::create([
            'employee_id'       => 'EMP-002',
            'user_id'           => $empUser->id,
            'first_name'        => 'Jamesden',
            'last_name'         => 'Correa',
            'email'             => 'employee@hr.com',
            'phone'             => '+63 912 000 0002',
            'department'        => 'IT Department',
            'position'          => 'IT Programmer',
            'date_hired'        => '2024-06-01',
            'employment_status' => 'active',
        ]);

        LeaveBalance::create([
            'employee_id'     => $employee->id,
            'year'            => now()->year,
            'vacation_total'  => 15, 'vacation_used'  => 0,
            'sick_total'      => 15, 'sick_used'      => 0,
            'emergency_total' => 5,  'emergency_used' => 0,
        ]);
    }
}