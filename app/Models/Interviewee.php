<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interviewee extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'job_id',
        'date',
        'time',
        'interview_type',
        'status',
        'application_id'
    ];

    public function job()
    {
        return $this->belongsTo(Jobs::class, 'job_id', 'job_id');
    }

    public function application()
    {
        return $this->belongsTo(jobApplicants::class,'id','application_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
