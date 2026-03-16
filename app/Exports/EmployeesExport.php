<?php

namespace App\Exports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EmployeesExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    public function collection()
    {
        return Employee::where('employment_status', 'active')
            ->orderBy('last_name')->get();
    }

    public function headings(): array
    {
        return [
            'Employee ID',
            'First Name',
            'Last Name',
            'Email',
            'Phone',
            'Department',
            'Position',
            'Date Hired',
            'Status',
        ];
    }

    public function map($employee): array
    {
        return [
            $employee->employee_id,
            $employee->first_name,
            $employee->last_name,
            $employee->email,
            $employee->phone ?? '—',
            $employee->department,
            $employee->position,
            \Carbon\Carbon::parse($employee->date_hired)->format('F d, Y'),
            ucfirst($employee->employment_status),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}