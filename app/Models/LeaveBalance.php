<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LeaveBalance extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'year',
        'vacation_total',
        'vacation_used',
        'sick_total',
        'sick_used',
        'emergency_total',
        'emergency_used',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function getVacationRemainingAttribute(): int
    {
        return $this->vacation_total - $this->vacation_used;
    }

    public function getSickRemainingAttribute(): int
    {
        return $this->sick_total - $this->sick_used;
    }

    public function getEmergencyRemainingAttribute(): int
    {
        return $this->emergency_total - $this->emergency_used;
    }
}
