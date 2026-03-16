<?php

namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AttendanceExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $month;
    protected $year;
    protected $employeeId;

    public function __construct($month = null, $year = null, $employeeId = null)
    {
        $this->month      = $month;
        $this->year       = $year;
        $this->employeeId = $employeeId;
    }

    public function collection()
    {
        $query = Attendance::with('employee');

        if ($this->month && $this->year) {
            $query->whereMonth('date', $this->month)
                  ->whereYear('date', $this->year);
        }

        if ($this->employeeId) {
            $query->where('employee_id', $this->employeeId);
        }

        return $query->orderBy('date', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'Employee ID',
            'Employee Name',
            'Date',
            'Clock In',
            'Clock Out',
            'Work Hours',
            'Status',
        ];
    }

    public function map($record): array
    {
        return [
            $record->employee?->employee_id ?? '—',
            $record->employee?->full_name ?? '—',
            \Carbon\Carbon::parse($record->date)->format('F d, Y'),
            $record->clock_in
                ? \Carbon\Carbon::parse($record->clock_in)->format('h:i A')
                : '—',
            $record->clock_out
                ? \Carbon\Carbon::parse($record->clock_out)->format('h:i A')
                : '—',
            $record->work_hours,
            ucfirst($record->status),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}