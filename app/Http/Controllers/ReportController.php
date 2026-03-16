<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Attendance;
use App\Models\Leave;
use App\Models\Payroll;
use App\Exports\EmployeesExport;
use App\Exports\AttendanceExport;
use App\Exports\LeaveExport;
use App\Exports\PayrollExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ReportController extends Controller
{
    // Reports home page
    public function index()
    {
        return view('reports.index');
    }

    // Employee report
    public function employees(Request $request)
    {
        $query = Employee::query();

        if ($request->filled('department')) {
            $query->where('department', $request->department);
        }

        if ($request->filled('status')) {
            $query->where('employment_status', $request->status);
        }

        $employees   = $query->orderBy('last_name')->get();
        $departments = Employee::distinct()->pluck('department');

        return view('reports.employees', compact('employees', 'departments'));
    }

    // Attendance report
    public function attendance(Request $request)
    {
        $month = $request->month ?? Carbon::now()->format('Y-m');
        $year  = substr($month, 0, 4);
        $mon   = substr($month, 5, 2);

        $query = Attendance::with('employee')
            ->whereMonth('date', $mon)
            ->whereYear('date', $year);

        if ($request->filled('employee_id')) {
            $query->where('employee_id', (int) $request->employee_id);
        }

        $records   = $query->orderBy('date', 'desc')->get();
        $employees = Employee::where('employment_status', 'active')->get();

        // Summary stats
        $summary = [
            'present'  => $records->where('status', 'present')->count(),
            'late'     => $records->where('status', 'late')->count(),
            'absent'   => $records->where('status', 'absent')->count(),
            'half_day' => $records->where('status', 'half-day')->count(),
        ];

        return view('reports.attendance', compact('records', 'employees', 'month', 'summary'));
    }

    // Leave report
    public function leaves(Request $request)
    {
        $year = $request->year ?? Carbon::now()->year;

        $query = Leave::with('employee')
            ->whereYear('start_date', $year);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('leave_type')) {
            $query->where('leave_type', $request->leave_type);
        }

        $leaves = $query->orderBy('start_date', 'desc')->get();

        $summary = [
            'total'    => $leaves->count(),
            'approved' => $leaves->where('status', 'approved')->count(),
            'pending'  => $leaves->where('status', 'pending')->count(),
            'rejected' => $leaves->where('status', 'rejected')->count(),
        ];

        return view('reports.leaves', compact('leaves', 'year', 'summary'));
    }

    // Payroll report
    public function payroll(Request $request)
    {
        $month = $request->month ?? Carbon::now()->format('Y-m');
        $year  = substr($month, 0, 4);
        $mon   = substr($month, 5, 2);

        $payrolls = Payroll::with('employee')
            ->whereMonth('period_start', $mon)
            ->whereYear('period_start', $year)
            ->where('status', 'released')
            ->orderBy('period_start', 'desc')
            ->get();

        $summary = [
            'total_gross'      => $payrolls->sum('gross_pay'),
            'total_deductions' => $payrolls->sum('total_deductions'),
            'total_net'        => $payrolls->sum('net_pay'),
            'count'            => $payrolls->count(),
        ];

        return view('reports.payroll', compact('payrolls', 'month', 'summary'));
    }

    // Export to Excel
    public function exportExcel(Request $request, string $type)
    {
        return match($type) {
            'employees' => Excel::download(
                new EmployeesExport(),
                'employees-' . now()->format('Y-m-d') . '.xlsx'
            ),
            'attendance' => Excel::download(
                new AttendanceExport(
                    $request->mon,
                    $request->yr
                ),
                'attendance-' . ($request->mon ?? now()->month) . '-' . ($request->yr ?? now()->year) . '.xlsx'
            ),
            'leaves' => Excel::download(
                new LeaveExport(
                    $request->status,
                    $request->leave_type,
                    $request->yr ?? now()->year
                ),
                'leaves-' . ($request->yr ?? now()->year) . '.xlsx'
            ),
            'payroll' => Excel::download(
                new PayrollExport(
                    $request->mon,
                    $request->yr
                ),
                'payroll-' . ($request->mon ?? now()->month) . '-' . ($request->yr ?? now()->year) . '.xlsx'
            ),
            default => back()->with('error', 'Invalid export type.')
        };
    }

    // Export to PDF
    public function exportPdf(Request $request, string $type)
    {
        return match($type) {
            'employees' => $this->employeesPdf($request),
            'attendance' => $this->attendancePdf($request),
            'leaves'     => $this->leavesPdf($request),
            'payroll'    => $this->payrollPdf($request),
            default      => back()->with('error', 'Invalid export type.')
        };
    }

    private function employeesPdf(Request $request)
    {
        $employees = Employee::orderBy('last_name')->get();
        $pdf = Pdf::loadView('reports.pdf.employees', compact('employees'))
            ->setPaper('a4', 'landscape');
        return $pdf->download('employees-' . now()->format('Y-m-d') . '.pdf');
    }

    private function attendancePdf(Request $request)
    {
        $month = $request->month ?? Carbon::now()->format('Y-m');
        $year  = substr($month, 0, 4);
        $mon   = substr($month, 5, 2);

        $records = Attendance::with('employee')
            ->whereMonth('date', $mon)
            ->whereYear('date', $year)
            ->orderBy('date', 'desc')->get();

        $pdf = Pdf::loadView('reports.pdf.attendance', compact('records', 'month'))
            ->setPaper('a4', 'landscape');
        return $pdf->download('attendance-' . $month . '.pdf');
    }

    private function leavesPdf(Request $request)
    {
        $year   = $request->year ?? Carbon::now()->year;
        $leaves = Leave::with('employee')
            ->whereYear('start_date', $year)
            ->orderBy('start_date', 'desc')->get();

        $pdf = Pdf::loadView('reports.pdf.leaves', compact('leaves', 'year'))
            ->setPaper('a4', 'landscape');
        return $pdf->download('leaves-' . $year . '.pdf');
    }

    private function payrollPdf(Request $request)
    {
        $month = $request->month ?? Carbon::now()->format('Y-m');
        $year  = substr($month, 0, 4);
        $mon   = substr($month, 5, 2);

        $payrolls = Payroll::with('employee')
            ->whereMonth('period_start', $mon)
            ->whereYear('period_start', $year)
            ->where('status', 'released')
            ->get();

        $summary = [
            'total_gross'      => $payrolls->sum('gross_pay'),
            'total_deductions' => $payrolls->sum('total_deductions'),
            'total_net'        => $payrolls->sum('net_pay'),
        ];

        $pdf = Pdf::loadView('reports.pdf.payroll', compact('payrolls', 'month', 'summary'))
            ->setPaper('a4', 'landscape');
        return $pdf->download('payroll-' . $month . '.pdf');
    }
}