<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Leave extends Model
{
    //
    use HasFactory;

    protected $fillable =[
        'employee_id',
        'leave_type',
        'start_date',
        'end_date',
        'days_requested',
        'reason',
        'status',
        'approved_by',
        'rejection_reason',
    ];

    protected $casts =[
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function employee ()
    {
        return $this->belongsTo(Employee::class);
    }
    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
    public function getStatusBadgeAttribute(): string
    {
        return match($this->status){
            'approved' => 'bg-green-100 text-green-800',
            'rejected' => 'bg-red-100 text-red-800',
            default => 'bg-yellow text-yellow-800',
        };
    }

}
