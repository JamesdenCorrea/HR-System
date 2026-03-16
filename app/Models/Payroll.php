<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    //
    use HasFactory;

    protected $fillable =[
        'employee_id',
        'period_label',
        'period_start',
        'period_end',
        'basic_salary',
        'allowance',
        'overtime_pay',
        'sss_deduction',
        'philhealth_deduction',
        'pagibig_deduction',
        'tax_deductions',
        'other_deductions',
        'gross_pay',
        'total_deductions',
        'net_pay',
        'status',
        'created_by',
    ];

    protected $casts =[
        'period_start' => 'date',
        'period_end' => 'date',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

}
