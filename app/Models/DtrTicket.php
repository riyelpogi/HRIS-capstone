<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DtrTicket extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'date',
        'time',
        'inorout',
        'file_name',
        'status',
        'reason_to_decline'
    ];


    public function user()
    {
       return $this->belongsTo(User::class, 'employee_id', 'employee_id');
    }

}
