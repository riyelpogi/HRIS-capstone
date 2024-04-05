<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingsAvailable extends Model
{
    use HasFactory;
    protected $fillable = [
        'training_name',
        'department_name',
        'department',
        'start_date',
        'to_date',
        'training_description',
        'status'
    ];

    public function approved_applicants()
    {
        return $this->hasMany(TrainingApplicant::class, 'training_id')
                            ->where('status', 'approved');
    }

    public function training_applicants()
    {
        return $this->hasMany(TrainingApplicant::class, 'training_id')
                        ->where('status', '!=', 'canceled');
    }
}
