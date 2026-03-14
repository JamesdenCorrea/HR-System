<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attendance extends Model
{
    //
    use HasFactory;

    protected $fillable =[
        'employee_id',
        'date',
        'clock_in',
        'clock_out',
        'status',
        'ip_address',
        'notes',
    ];

    protected $casts =[
        'date' => 'date',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
    public function getWorkHoursAttribute(): string
    {
        if (!$this->clock_in || !$this->clock_out){
            return '-';
        }
        $in = \Carbon\Carbon::parse($this->clock_in);
        $out = \Carbon\Carbon::parse($this->clock_out);

        $diff = $in->diff($out);
        return $diff->h . 'h ' . $diff->i . 'm';
    }
}
