<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use App\Models\Employee;
use App\Models\SalaryInformation;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class PayrollController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // List all payrolls
        $query = Payroll::with('employee');

        if($request->filled('period_label')) {
            $query->where('period_label', $request->period_label);
        }

        if($request->filled('employee_id')){
            $query->where('employee_id', (int) $request->employee_id);
        }

        if($request->filled('status')){
            $query->where('status', $request->status);
        }

        $payrolls = $query->latest()->paginate(15)->withQueryString();
        $employees = Employee::where('employment_status', 'active')->get();
        $periods = Payroll::select('period_label')->distinct()->pluck('period_label');

        return view('payroll.index', compact('payrolls', 'employees', 'periods'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // generate payroll form
        $employees = Employee::where('employment_status', 'active')
        ->with('salaryInformation')->get();

        return view('payroll.create', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'period_start' => 'required|date',
            'period_end' =>  'required|date|after_or_equal:period_start',
            'basic_salary' => 'required|numeric|min:0',
            'allowance' =>  'nullable|numeric|min:0',
            'overtime_pay' => 'nullable|numeric|min:0',
            'sss_deduction' => 'nullable|numeric|min:0',
            'philhealth_deduction' => 'nullable|numeric|min:0',
            'tax_deduction' => 'nullable|numeric|min:0',
            'other_deductions' => 'nullable|numeric|min:0',
        ]);

        $basicSalary = $validated['basic_salary'];
        $allowance = $validated['allowance'] ?? 0;
        $overtimePay = $validated['overtime_pay'] ?? 0;
        $sss = $validated['sss_deduction'] ?? 0;
        $philhealth = $validated['philhealth_deduction'] ?? 0;
        $pagibig = $validated['pagibig_deduction'] ?? 0;
        $tax = $validated['tax_deduction'] ?? 0;
        $otherDeductions = $validated['other_deductions'] ?? 0;

        $grossPay = $basicSalary + $allowance + $overtimePay;
        $totalDeductions = $sss + $philhealth + $pagibig + $tax + $otherDeductions;
        $netPay = $grossPay - $totalDeductions;

        $periodStart = Carbon::parse($validated['period_start']);
        $periodEnd = Carbon::parse($validated['period_end']);
        $periodLabel = $periodStart->format('F Y');

        PayrolL::create([
            'employee_id' => $validated['employee_id'],
            'period_label' => $periodLabel,
            'period_start' => $validated['period_start'],
            'period_end' => $validated['period_end'],
            'basic_salary' => $basicSalary,
            'allowance' => $allowance,
            'overtime_pay' => $overtimePay,
            'sss_deduction' => $sss,
            'philheath_deduction' => $philhealth,
            'pagibig_deduction' => $pagibig,
            'tax_deduction' => $tax,
            'other_deductions' => $otherDeductions,
            'gross_pay' => $grossPay,
            'total_deductions' => $totalDeductions,
            'net_pay' => $netPay,
            'status' => 'draft',
            'created_by' => auth()->id(),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Payroll $payroll)
    {
        //
        return view('payroll.show', compact('payroll'));
    }

    public function release(Payroll $payroll)
    {
        $payroll->update(['status' => 'released']);

        return back()->with('success', 'Payroll released successfully');
    }
    // download payslip as pdf
    public function downloadPdf(Payroll $payroll)
    {
        $pdf = Pdf::loadView('payroll.pdf', compact('payroll'));

        return $pdf->download(
            'payslip-' . $payroll->employee->employee_id .
            '-' . $payroll->period_label . '.pdf'
        );
    }

    // employee view their own payslips
    public function myPayslips()
    {
        $employee = Employee::where('user_id', auth()->id())->firstOrFail();
        $payrolls = Payroll::where('employee_id', $employee->id)
        ->where('status', 'released')
        ->latest()->paginate(10);

        return view('payroll.my-payslips', compact('payrolls'));
    }

    // salary information list
    public function salaryIndex()
    {
        $employees = Employee::where('employment_status', 'active')
        ->with('salaryInformation')->get();

        return view('payroll.salary-index', compact('employees'));
    }

    // salary edit information
    public function salaryEdit(Employee $employee)
    {
        $salary = SalaryInformation::firstOrCreate(
            ['employee_id' => $employee->id],
            [
                'monthly_salary' => 0,
                'allowance' => 0,
                'sss_deduction' => 0,
                'philhealth_deduction' => 0,
                'pagibig_deduction' => 0,
            ]
        );
        return view('payroll.salary-edit', compact('employee'. 'salary'));
    }

    public function salaryUpdate(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'mothly_salary' => 'required|numeric|min:0',
            'allowance' => 'nullable|numeric|min:0',
            'sss_deduction' => 'nullable|numeric|min:0',
            'philhealth_deduction' => 'nullable|numeric|min:0',
            'pagibig_deduction' => 'nullable|numeric|min:0',
        ]);

        SalaryInformation::updateOrCreate(
            ['employee_id' => $employee->id],
            $validated
        );

        return redirect()->route('hr.payroll.salary-index')
        -with('success', 'Salary information updated for ' . $employee->fullname);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payroll $payroll)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payroll $payroll)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payroll $payroll)
    {
        //
    }
}
