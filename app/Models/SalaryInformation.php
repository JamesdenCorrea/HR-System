<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SalaryInformation extends Model
{
    //

    use HasFactory;

    protected $table = 'salary_informations';

    protected $fillable = [
        'employee_id',
        'mothly_salary',
        'allowance',
        'sss_deduction',
        'philhealth_deduction',
        'pagibig_deduction',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
