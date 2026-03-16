<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Attendance;
use App\Models\Leave;
use App\Models\Payroll;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            return $this->adminDashboard();
        } elseif ($user->hasRole('hr')) {
            return $this->hrDashboard();
        } else {
            return $this->employeeDashboard();
        }
    }

    private function adminDashboard()
    {
        $data = $this->getSharedStats();
        return view('dashboard.admin', $data);
    }

    private function hrDashboard()
    {
        $data = $this->getSharedStats();
        return view('dashboard.hr', $data);
    }

    private function employeeDashboard()
    {
        $employee = Employee::where('user_id', auth()->id())->first();

        $todayAttendance = null;
        $myLeaves        = collect();
        $myPayslips      = collect();

        if ($employee) {
            $todayAttendance = Attendance::where('employee_id', $employee->id)
                ->whereDate('date', Carbon::today())
                ->first();

            $myLeaves = Leave::where('employee_id', $employee->id)
                ->latest()->take(5)->get();

            $myPayslips = Payroll::where('employee_id', $employee->id)
                ->where('status', 'released')
                ->latest()->take(3)->get();
        }

        return view('dashboard.employee', compact(
            'employee',
            'todayAttendance',
            'myLeaves',
            'myPayslips'
        ));
    }

    private function getSharedStats(): array
    {
        $today = Carbon::today();
        $currentMonth = Carbon::now()->month;
        $currentYear  = Carbon::now()->year;

        // Employee stats
        $totalEmployees      = Employee::where('employment_status', 'active')->count();
        $newThisMonth        = Employee::whereMonth('created_at', $currentMonth)
                                ->whereYear('created_at', $currentYear)->count();

        // Department breakdown
        $employeesByDept = Employee::where('employment_status', 'active')
            ->selectRaw('department, COUNT(*) as count')
            ->groupBy('department')
            ->pluck('count', 'department');

        // Attendance stats for today
        $presentToday = Attendance::whereDate('date', $today)
            ->whereIn('status', ['present', 'late'])->count();
        $lateToday    = Attendance::whereDate('date', $today)
            ->where('status', 'late')->count();
        $absentToday  = $totalEmployees - $presentToday;

        // Monthly attendance breakdown for chart
        $monthlyAttendance = Attendance::whereMonth('date', $currentMonth)
            ->whereYear('date', $currentYear)
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        // Leave stats
        $pendingLeaves  = Leave::where('status', 'pending')->count();
        $approvedLeaves = Leave::where('status', 'approved')
            ->whereMonth('start_date', $currentMonth)->count();

        // Leave type breakdown for chart
        $leavesByType = Leave::where('status', 'approved')
            ->whereYear('start_date', $currentYear)
            ->selectRaw('leave_type, COUNT(*) as count')
            ->groupBy('leave_type')
            ->pluck('count', 'leave_type');

        // Payroll stats
        $totalPayrollThisMonth = Payroll::whereMonth('period_start', $currentMonth)
            ->whereYear('period_start', $currentYear)
            ->where('status', 'released')
            ->sum('net_pay');

        $draftPayrolls = Payroll::where('status', 'draft')->count();

        // Recent activities
        $recentEmployees = Employee::latest()->take(5)->get();
        $recentLeaves    = Leave::with('employee')->latest()->take(5)->get();

        return compact(
            'totalEmployees',
            'newThisMonth',
            'employeesByDept',
            'presentToday',
            'lateToday',
            'absentToday',
            'monthlyAttendance',
            'pendingLeaves',
            'approvedLeaves',
            'leavesByType',
            'totalPayrollThisMonth',
            'draftPayrolls',
            'recentEmployees',
            'recentLeaves'
        );
    }
}