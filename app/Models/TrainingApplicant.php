<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingApplicant extends Model
{
    use HasFactory;

    protected $fillable = [
        'training_id',
        'employee_id',
        'status'
    ];

    public function user()
    {
       return $this->belongsTo(User::class, 'employee_id', 'employee_id');
    }

    public function training_available()
    {
       return $this->belongsTo(TrainingsAvailable::class, 'training_id');
    }
}

