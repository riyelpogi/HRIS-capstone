<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveRequests extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'from',
        'to',
        'reason',
        'status',
        'reason_to_decline'

    ];

    public function user()
    {
       return $this->belongsTo(User::class, 'employee_id', 'employee_id');
    }

}
