<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BenefitsApplicant extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'benefit_id',
        'status',
        'notice',
        'date_approved'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'employee_id', 'employee_id');
    }

    public function benefit()
    {
        return $this->belongsTo(Benefits::class,'benefit_id');
    }

}
