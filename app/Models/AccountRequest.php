<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AccountRequest extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'role',
        'department',
        'position',
        'status',
        'requested_by',
        'processed_by',
        'rejection_reason',
    ];

    public function requestedBy()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }
    
    public function processedBy()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status){
            'approved' => 'bg-green-100 text-green-800',
            'rejected' => 'bg-red-100 text-red-800',
            default => 'bg-yellow-100 text-yellow-800',
        };
    }
}
