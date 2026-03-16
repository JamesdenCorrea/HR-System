<?php

namespace App\Exports;

use App\Models\Payroll;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PayrollExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $month;
    protected $year;

    public function __construct($month = null, $year = null)
    {
        $this->month = $month;
        $this->year  = $year;
    }

    public function collection()
    {
        $query = Payroll::with('employee')->where('status', 'released');

        if ($this->month && $this->year) {
            $query->whereMonth('period_start', $this->month)
                  ->whereYear('period_start', $this->year);
        }

        return $query->orderBy('period_start', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'Employee ID',
            'Employee Name',
            'Period',
            'Basic Salary',
            'Allowance',
            'Overtime Pay',
            'Gross Pay',
            'SSS',
            'PhilHealth',
            'Pag-IBIG',
            'Tax',
            'Other Deductions',
            'Total Deductions',
            'Net Pay',
        ];
    }

    public function map($payroll): array
    {
        return [
            $payroll->employee?->employee_id ?? '—',
            $payroll->employee?->full_name ?? '—',
            $payroll->period_label,
            number_format($payroll->basic_salary, 2),
            number_format($payroll->allowance, 2),
            number_format($payroll->overtime_pay, 2),
            number_format($payroll->gross_pay, 2),
            number_format($payroll->sss_deduction, 2),
            number_format($payroll->philhealth_deduction, 2),
            number_format($payroll->pagibig_deduction, 2),
            number_format($payroll->tax_deduction, 2),
            number_format($payroll->other_deductions, 2),
            number_format($payroll->total_deductions, 2),
            number_format($payroll->net_pay, 2),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}