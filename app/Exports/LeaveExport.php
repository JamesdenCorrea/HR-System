<?php

namespace App\Exports;

use App\Models\Leave;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LeaveExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $status;
    protected $leaveType;
    protected $year;

    public function __construct($status = null, $leaveType = null, $year = null)
    {
        $this->status    = $status;
        $this->leaveType = $leaveType;
        $this->year      = $year;
    }

    public function collection()
    {
        $query = Leave::with('employee');

        if ($this->status) {
            $query->where('status', $this->status);
        }

        if ($this->leaveType) {
            $query->where('leave_type', $this->leaveType);
        }

        if ($this->year) {
            $query->whereYear('start_date', $this->year);
        }

        return $query->orderBy('start_date', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'Employee ID',
            'Employee Name',
            'Leave Type',
            'Start Date',
            'End Date',
            'Days Requested',
            'Reason',
            'Status',
        ];
    }

    public function map($leave): array
    {
        return [
            $leave->employee?->employee_id ?? '—',
            $leave->employee?->full_name ?? '—',
            ucfirst($leave->leave_type),
            $leave->start_date->format('F d, Y'),
            $leave->end_date->format('F d, Y'),
            $leave->days_requested,
            $leave->reason,
            ucfirst($leave->status),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}