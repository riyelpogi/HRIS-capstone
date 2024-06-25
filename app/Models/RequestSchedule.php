<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;

class RequestSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'cutoff',
        'Mon',
        'Tue',
        'Wed',
        'Thu',
        'Fri',
        'Sat',
        'Sun',
        'status',
        'reason_to_decline'
    ];

   

    public function user()
    {
        return $this->belongsTo(User::class, 'employee_id', 'employee_id');
    }


}
