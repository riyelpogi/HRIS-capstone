<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestOff extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'date',
        'reason',
        'status',
        'reason_to_decline',
        'rest_day'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'employee_id', 'employee_id');
    }

}
