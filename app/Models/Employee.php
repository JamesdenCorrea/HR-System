<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'employee_id',
        'user_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'department',
        'position',
        'date_hired',
        'employment_status',
        'profile_photo',
    ];

    protected $cast = [
        'date_hired' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFullNameAttribute(): string{
        return "{$this->first_name} {$this->last_name}";
    }
}
