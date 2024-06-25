<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TwoZeroOneFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'sss',
        'tin',
        'philhealth',
        'nbi',
        'diploma',
        'tor',
        'resume',
        'birth_certificate',
        'employment_contracts',
        'others'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'employee_id', 'employee_id');
    }

}
